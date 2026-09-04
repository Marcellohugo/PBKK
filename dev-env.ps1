# Dot-source once: . .\dev-env.ps1 (changes only the current PowerShell session).
$pbkkTools = Join-Path $env:LOCALAPPDATA 'PBKK\tools'
$pbkkNode = Join-Path $env:USERPROFILE '.cache\codex-runtimes\codex-primary-runtime\dependencies\node\bin'
if (Test-Path "$pbkkTools\php\php.exe") { $env:PATH = "$pbkkTools\php;$env:PATH" }
if (Test-Path "$pbkkNode\node.exe") { $env:PATH = "$pbkkNode;$env:PATH" }
if (Test-Path "$pbkkTools\composer.phar") {
    function global:composer { & php (Join-Path $env:LOCALAPPDATA 'PBKK\tools\composer.phar') @args }
}
if (Test-Path "$pbkkTools\node_modules\npm\bin\npm-cli.js") {
    function global:npm { & node (Join-Path $env:LOCALAPPDATA 'PBKK\tools\node_modules\npm\bin\npm-cli.js') @args }
}
