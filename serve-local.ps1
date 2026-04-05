$ErrorActionPreference = "Stop"

$root = "C:\projetos\Sites\site_maiko"
$port = 4173
$listener = [System.Net.Sockets.TcpListener]::new([System.Net.IPAddress]::Loopback, $port)

function Get-ContentType {
  param([string]$FilePath)

  switch ([System.IO.Path]::GetExtension($FilePath).ToLowerInvariant()) {
    ".html" { return "text/html; charset=utf-8" }
    ".css" { return "text/css; charset=utf-8" }
    ".js" { return "application/javascript; charset=utf-8" }
    ".png" { return "image/png" }
    ".jpg" { return "image/jpeg" }
    ".jpeg" { return "image/jpeg" }
    ".svg" { return "image/svg+xml" }
    default { return "application/octet-stream" }
  }
}

$listener.Start()
Write-Output ("Serving {0} at http://localhost:{1}/" -f $root, $port)

try {
  while ($true) {
    $client = $listener.AcceptTcpClient()

    try {
      $stream = $client.GetStream()
      $reader = [System.IO.StreamReader]::new($stream)

      $requestLine = $reader.ReadLine()
      if ([string]::IsNullOrWhiteSpace($requestLine)) {
        continue
      }

      while (($headerLine = $reader.ReadLine()) -ne "") {
        if ($null -eq $headerLine) {
          break
        }
      }

      $requestPath = ($requestLine -split " ")[1]
      $requestPath = $requestPath.Split("?")[0].TrimStart("/")
      $requestPath = [System.Uri]::UnescapeDataString($requestPath)

      if ([string]::IsNullOrWhiteSpace($requestPath)) {
        $requestPath = "index.html"
      }

      $safePath = $requestPath.Replace("/", "\")
      $filePath = Join-Path $root $safePath

      if ((Test-Path $filePath -PathType Leaf) -and $filePath.StartsWith($root)) {
        $body = [System.IO.File]::ReadAllBytes($filePath)
        $contentType = Get-ContentType -FilePath $filePath
        $statusLine = "HTTP/1.1 200 OK"
      } else {
        $body = [System.Text.Encoding]::UTF8.GetBytes("404")
        $contentType = "text/plain; charset=utf-8"
        $statusLine = "HTTP/1.1 404 Not Found"
      }

      $headerText = (
        "{0}`r`nContent-Type: {1}`r`nContent-Length: {2}`r`nConnection: close`r`n`r`n" -f
        $statusLine, $contentType, $body.Length
      )

      $headerBytes = [System.Text.Encoding]::ASCII.GetBytes($headerText)
      $stream.Write($headerBytes, 0, $headerBytes.Length)
      $stream.Write($body, 0, $body.Length)
      $stream.Flush()
    } finally {
      if ($reader) {
        $reader.Dispose()
      }

      if ($stream) {
        $stream.Dispose()
      }

      $client.Dispose()
    }
  }
} finally {
  $listener.Stop()
}
