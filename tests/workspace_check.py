"""Browser check for Livewire using disposable SQLite, two accounts and a local LLM fixture."""
import argparse
import base64
from contextlib import ExitStack, closing
import hashlib
import os
from pathlib import Path
import socket
import sqlite3
import subprocess
import tempfile
import threading
from http.server import ThreadingHTTPServer

from playwright.sync_api import expect, sync_playwright

from api_check import Providers, ROOT


def run(php, chrome):
    with tempfile.TemporaryDirectory() as directory, ExitStack() as cleanup:
        temp = Path(directory)
        database = temp / "chat.sqlite"
        database.touch()
        provider = ThreadingHTTPServer(("127.0.0.1", 0), Providers)
        threading.Thread(target=provider.serve_forever, daemon=True).start()
        cleanup.callback(provider.server_close)
        cleanup.callback(provider.shutdown)
        with socket.socket() as port:
            port.bind(("127.0.0.1", 0))
            base = f"http://127.0.0.1:{port.getsockname()[1]}"
        env = dict(os.environ, APP_URL=base, APP_ENV="local", APP_DEBUG="false",
                   APP_KEY="base64:" + base64.b64encode(os.urandom(32)).decode(),
                   DB_CONNECTION="sqlite", DB_DATABASE=str(database), DB_URL="",
                   CACHE_STORE="database", SESSION_DRIVER="database", QUEUE_CONNECTION="database",
                   OLLAMA_URL=f"http://127.0.0.1:{provider.server_port}", SENOPATI_API_KEY="")
        subprocess.run([php, "artisan", "migrate", "--seed", "--force", "--quiet"], cwd=ROOT, env=env, check=True)
        router = ROOT / "vendor/laravel/framework/src/Illuminate/Foundation/resources/server.php"
        log = cleanup.enter_context((temp / "server.log").open("wb"))
        for args, cwd in [(["-S", base.removeprefix("http://"), str(router)], ROOT / "public"),
                          (["artisan", "queue:work", "database", "--sleep=1", "--tries=1"], ROOT)]:
            proc = subprocess.Popen([php, *args], cwd=cwd, env=env, stdout=log, stderr=log)
            cleanup.callback(proc.wait, 10)
            cleanup.callback(proc.terminate)

        def sign_in(page, role):
            page.goto(base + "/chat")
            expect(page).to_have_url(base + "/login")
            page.locator(f'form[action$="/login/demo/{role}"] button').click()
            page.goto(base + "/chat")

        pw = cleanup.enter_context(sync_playwright())
        browser = pw.chromium.launch(executable_path=chrome)
        cleanup.callback(browser.close)
        page = browser.new_page()
        page.set_default_timeout(15000)
        sign_in(page, "admin")
        question = "Bagaimana menguji metode studi?"
        page.locator("#chat-prompt").fill(question)
        page.get_by_role("button", name="Kirim pesan").click()
        expect(page.locator(".from-ai p")).to_have_text("Riset teruji ✓", timeout=30000)
        page.reload()
        expect(page.locator(".from-user p")).to_have_text(question)
        expect(page.locator(".chat-thread")).to_have_count(1)

        Providers.modes["ollama"] = "down"
        page.locator("#chat-prompt").fill("Jelaskan lebih lanjut.")
        page.get_by_role("button", name="Kirim pesan").click()
        expect(page.get_by_role("alert")).to_contain_text("Pertanyaan tersimpan")
        Providers.modes["ollama"] = "good"
        page.get_by_role("button", name="Lanjutkan jawaban").click()
        expect(page.locator(".from-ai small")).to_have_count(2)
        context = Providers.calls[-1][1]["messages"]
        assert [item["role"] for item in context] == ["system", "user", "assistant", "user"]

        with closing(sqlite3.connect(database)) as db, db:
            thread = db.execute("SELECT id FROM chat_conversations").fetchone()[0]
            assert db.execute("SELECT count(*) FROM chat_messages").fetchone()[0] == 4
            db.execute("UPDATE chat_messages SET content=? WHERE id=(SELECT max(id) FROM chat_messages)",
                       ("Contoh:\n```html\n<h1>Riset</h1>\n```",))
        page.get_by_role("button", name="Percakapan baru").click()
        expect(page.locator(".from-user")).to_have_count(0)
        page.get_by_role("button", name=question).click()
        expect(page.locator("research-code code")).to_have_text("<h1>Riset</h1>")
        expect(page.locator("research-code .hljs-tag").first).to_be_visible()
        assert page.locator("research-code h1").count() == 0

        sample = b"studi A,12\nstudi B,15\n"
        page.locator("#document").set_input_files({"name": "catatan.txt", "mimeType": "text/plain", "buffer": sample})
        page.get_by_role("button", name="Periksa", exact=True).click()
        expect(page.locator(".scan-result")).to_contain_text("2 baris", timeout=30000)
        expect(page.locator(".scan-result code")).to_have_text(hashlib.sha256(sample).hexdigest())
        page.set_viewport_size({"width": 390, "height": 844})
        assert page.evaluate("document.documentElement.scrollWidth <= innerWidth")

        other = browser.new_page()
        sign_in(other, "staf")
        expect(other.locator(".chat-thread")).to_have_count(0)
        expect(other.locator(".scan-result")).to_have_count(0)
        with other.expect_response(lambda res: res.url.endswith("/update") and res.request.method == "POST") as denied:
            other.evaluate("(id) => window.Livewire.dispatch('select-thread', {id})", thread)
        assert denied.value.status == 404, denied.value.status
        print("PASS workspace: login, history, retry, context, code, file job, mobile and ownership")


if __name__ == "__main__":
    parser = argparse.ArgumentParser()
    parser.add_argument("--php", default="php")
    parser.add_argument("--chrome", help="Optional path to a local Chromium executable")
    options = parser.parse_args()
    run(options.php, options.chrome)
