"""Isolated API checks: temporary SQLite database and local LLM fixtures only."""
import argparse
import base64
from contextlib import closing
import hashlib
from http.server import BaseHTTPRequestHandler, ThreadingHTTPServer
import json
import os
from pathlib import Path
import socket
import sqlite3
import subprocess
import tempfile
import threading
import time
import urllib.error
import urllib.request

ROOT = Path(__file__).resolve().parents[1]
EMAIL = "api-check@example.com"
PASSWORD = "api-check-password"


class Providers(BaseHTTPRequestHandler):
    modes = {"ollama": "good", "senopati": "good"}
    calls = []
    completed = threading.Event()

    def log_message(self, *_args):
        pass

    def do_POST(self):
        provider = "ollama" if self.path == "/api/chat" else "senopati"
        body = json.loads(self.rfile.read(int(self.headers["Content-Length"])))
        self.calls.append((provider, body, self.headers.get("Authorization")))
        mode = self.modes[provider]
        if mode == "down":
            self.send_response(503)
            self.end_headers()
            self.wfile.write(b'{"error":"fixture unavailable"}')
            return
        if not body.get("stream"):
            if provider == "ollama":
                data = {"model": "ollama-test", "done": True,
                        "message": {"content": "Riset teruji ✓"},
                        "prompt_eval_count": 5, "eval_count": 7}
            else:
                data = {"model": "senopati-test",
                        "choices": [{"message": {"content": "Fallback teruji"}, "finish_reason": "stop"}],
                        "usage": {"total_tokens": 17}}
            if mode == "malformed":
                data = {"unexpected": "not a chat completion"}
            payload = json.dumps(data, ensure_ascii=False).encode()
            self.send_response(200)
            self.send_header("Content-Type", "application/json")
            self.send_header("Content-Length", str(len(payload)))
            self.end_headers()
            self.wfile.write(payload)
            return

        self.completed.clear()
        self.send_response(200)
        self.send_header("Content-Type", "application/x-ndjson" if provider == "ollama" else "text/event-stream")
        self.end_headers()
        if provider == "ollama":
            messages = [
                {"model": "ollama-test", "message": {"content": "Riset "}, "done": False},
                {"model": "ollama-test", "message": {"content": "teruji ✓"}, "done": False},
                {"model": "ollama-test", "message": {"content": ""}, "done": True,
                 "prompt_eval_count": 5, "eval_count": 7},
            ]
            lines = [(json.dumps(item, ensure_ascii=False) + "\n").encode() for item in messages]
            if mode == "partial":
                lines = lines[:1] + [b'{"error":"fixture interrupted"}\n']
        else:
            messages = [
                {"model": "senopati-test", "choices": [{"delta": {"content": "Fallback "}, "finish_reason": None}]},
                {"model": "senopati-test", "choices": [{"delta": {"content": "teruji"}, "finish_reason": None}]},
                {"model": "senopati-test", "choices": [{"delta": {}, "finish_reason": "stop"}],
                 "usage": {"total_tokens": 17}},
            ]
            lines = [("data: " + json.dumps(item) + "\n\n").encode() for item in messages] + [b"data: [DONE]\n\n"]
        try:
            for index, line in enumerate(lines):
                # Split frames and UTF-8 bytes independently of logical events.
                for offset in range(0, len(line), 7):
                    self.wfile.write(line[offset:offset + 7])
                    self.wfile.flush()
                if index == 0:
                    time.sleep(.8)
            self.completed.set()
        except (BrokenPipeError, ConnectionResetError):
            pass


def check_api(php, php_args):
    with tempfile.TemporaryDirectory(prefix="researchmate-api-") as directory:
        temp = Path(directory)
        database = temp / "test.sqlite"
        database.touch()
        fixtures = ThreadingHTTPServer(("127.0.0.1", 0), Providers)
        worker = threading.Thread(target=fixtures.serve_forever, daemon=True)
        worker.start()
        with socket.socket() as sock:
            sock.bind(("127.0.0.1", 0))
            port = sock.getsockname()[1]
        env = dict(os.environ, APP_ENV="testing", APP_DEBUG="false",
                   APP_KEY="base64:" + base64.b64encode(os.urandom(32)).decode(),
                   DB_CONNECTION="sqlite", DB_DATABASE=str(database), DB_URL="",
                   CACHE_STORE="array", SESSION_DRIVER="array",
                   APP_CONFIG_CACHE=str(temp / "config.php"),
                   OLLAMA_URL=f"http://127.0.0.1:{fixtures.server_port}", OLLAMA_MODEL="ollama-test",
                   SENOPATI_URL=f"http://127.0.0.1:{fixtures.server_port}/v1/chat/completions",
                   SENOPATI_API_KEY="fixture-key", SENOPATI_MODEL="senopati-test")
        command = [php, *php_args]

        def php_code(code):
            bootstrap = "require 'vendor/autoload.php'; $app=require 'bootstrap/app.php'; $app->make(\\Illuminate\\Contracts\\Console\\Kernel::class)->bootstrap(); "
            return subprocess.check_output([*command, "-r", bootstrap + code], cwd=ROOT, env=env).decode()

        subprocess.run([*command, "artisan", "migrate", "--force", "--no-interaction"],
                       cwd=ROOT, env=env, check=True, capture_output=True)
        php_code("\\App\\Models\\User::create(['name'=>'API Check','email'=>'" + EMAIL +
                 "','password'=>'" + PASSWORD + "']);")
        router = ROOT / "vendor/laravel/framework/src/Illuminate/Foundation/resources/server.php"
        with tempfile.TemporaryFile() as log:
            server = subprocess.Popen([*command, "-S", f"127.0.0.1:{port}", str(router)],
                                      cwd=ROOT / "public", env=env, stdout=log, stderr=log)
            try:
                for _ in range(100):
                    try:
                        with socket.create_connection(("127.0.0.1", port), timeout=.1):
                            break
                    except OSError:
                        if server.poll() is not None:
                            raise RuntimeError("PHP API server failed to start")
                        time.sleep(.05)
                base = f"http://127.0.0.1:{port}"

                def request(path, data=None, token=None, status=200, method="POST", accept=True):
                    headers = {"Content-Type": "application/json"}
                    if accept:
                        headers["Accept"] = "application/json"
                    if token:
                        headers["Authorization"] = "Bearer " + token
                    payload = json.dumps(data).encode() if data is not None else None
                    req = urllib.request.Request(base + path, data=payload, method=method, headers=headers)
                    try:
                        response = urllib.request.urlopen(req, timeout=30)
                    except urllib.error.HTTPError as error:
                        response = error
                    assert response.status == status, (path, response.status, response.read().decode()[:300])
                    return response

                def json_request(*args, **kwargs):
                    with request(*args, **kwargs) as response:
                        assert "application/json" in response.headers.get("Content-Type", "")
                        return json.load(response)

                def count_logs():
                    with closing(sqlite3.connect(database)) as connection:
                        return connection.execute("select count(*) from chat_logs").fetchone()[0]

                def stream(token):
                    events = []
                    with request("/api/chat-ai/stream", {"prompt": "Uji aliran"}, token) as response:
                        assert "text/event-stream" in response.headers.get("Content-Type", "")
                        name = "message"
                        for line in response:
                            text = line.decode().strip()
                            if text.startswith("event:"):
                                name = text[6:].strip()
                            elif text.startswith("data:"):
                                data = json.loads(text[5:].strip())
                                if name == "delta" and not events:
                                    assert not Providers.completed.is_set(), "Stream was buffered until provider finished"
                                events.append((name, data))
                    return events

                json_request("/api/chat-ai", {"prompt": "test"}, status=401, accept=False)
                json_request("/api/chat-ai/stream", {"prompt": "test"}, status=401, accept=False)
                json_request("/api/login", {"email": EMAIL, "password": "wrong"}, status=401)
                login = json_request("/api/login", {"email": EMAIL, "password": PASSWORD})
                token = login["access_token"]
                assert login["token_type"] == "Bearer" and login["expires_at"]
                with closing(sqlite3.connect(database)) as connection:
                    stored = connection.execute("select token from personal_access_tokens").fetchone()[0]
                    assert stored == hashlib.sha256(token.split("|", 1)[1].encode()).hexdigest()
                limited = php_code("echo \\App\\Models\\User::firstOrFail()->createToken('limited', ['profile'])->plainTextToken;")
                json_request("/api/chat-ai", {"prompt": "test"}, limited, status=403)
                expired = php_code("echo \\App\\Models\\User::firstOrFail()->createToken('expired', ['chat'], now()->subMinute())->plainTextToken;")
                json_request("/api/chat-ai", {"prompt": "test"}, expired, status=401)
                for payload in ({}, {"prompt": []}, {"prompt": "x" * 1001}, {"prompt": "   "}):
                    result = json_request("/api/chat-ai", payload, token, status=422)
                    assert "prompt" in result["errors"]
                assert not Providers.calls and count_logs() == 0
                result = json_request("/api/chat-ai", {"prompt": "Bantu rencana riset"}, token, status=201)
                data = result["data"]
                assert result["status"] == "success" and data["ai_response"] == "Riset teruji ✓"
                assert data["model_used"] == "ollama-test" and data["tokens_used"] == 12
                assert data["provider"] == "ollama" and data["timestamp"]
                assert not {"user_id", "password", "api_key", "token"}.intersection(data)
                messages = Providers.calls[-1][1]["messages"]
                assert messages[0]["role"] == "system" and "ResearchMate" in messages[0]["content"]
                with closing(sqlite3.connect(database)) as connection:
                    record = connection.execute("select user_id,prompt,ai_response,tokens_used from chat_logs").fetchone()
                    user_id = connection.execute("select id from users where email=?", (EMAIL,)).fetchone()[0]
                    assert record == (user_id, "Bantu rencana riset", "Riset teruji ✓", 12)
                events = stream(token)
                assert "".join(item["delta"] for name, item in events if name == "delta") == "Riset teruji ✓"
                assert events[-1][0] == "done" and events[-1][1]["status"] == "success"
                assert count_logs() == 2
                Providers.modes["ollama"] = "down"
                fallback = json_request("/api/chat-ai", {"prompt": "Uji fallback"}, token, status=201)["data"]
                assert fallback["provider"] == "senopati" and fallback["tokens_used"] == 17
                assert Providers.calls[-1][2] == "Bearer fixture-key"
                events = stream(token)
                assert events[-1][0] == "done" and events[-1][1]["data"]["provider"] == "senopati"
                assert count_logs() == 4
                Providers.modes["senopati"] = "down"
                json_request("/api/chat-ai", {"prompt": "Uji gagal"}, token, status=503)
                assert count_logs() == 4
                Providers.modes.update(ollama="partial", senopati="good")
                before = len(Providers.calls)
                events = stream(token)
                assert events[0][0] == "delta" and events[-1][0] == "error"
                assert not any(name == "done" for name, _ in events) and count_logs() == 4
                assert [provider for provider, *_ in Providers.calls[before:]] == ["ollama"]
                with request("/api/token", token=token, method="DELETE", status=204) as response:
                    assert not response.read()
                json_request("/api/chat-ai", {"prompt": "test"}, token, status=401)
                print("PASS W11 API: Sanctum, validation, logs, LLM JSON, incremental SSE, fallback, revocation")
            except Exception:
                log.seek(0)
                print(log.read().decode(errors="replace")[-2500:])
                raise
            finally:
                server.terminate()
                server.wait(timeout=10)
                fixtures.shutdown()
                fixtures.server_close()
                worker.join(timeout=5)


if __name__ == "__main__":
    parser = argparse.ArgumentParser()
    parser.add_argument("--php", default="php")
    parser.add_argument("--php-arg", action="append", default=[])
    args = parser.parse_args()
    check_api(args.php, args.php_arg)
