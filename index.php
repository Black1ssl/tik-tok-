<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $url = trim($_POST["url"]);

    if (empty($url)) {
        die("URL tidak boleh kosong");
    }

    $safe_url = escapeshellarg($url);
    $filename = "tiktok_" . time() . ".mp4";
    $filepath = "/tmp/" . $filename;

    $command = "yt-dlp -f mp4 -o '$filepath' $safe_url 2>&1";
    shell_exec($command);

    if (!file_exists($filepath)) {
        die("Gagal mengunduh video.");
    }

    // Paksa download ke browser
    header("Content-Type: video/mp4");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header("Content-Length: " . filesize($filepath));
    readfile($filepath);

    // Hapus file setelah download
    unlink($filepath);
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>TikTok Downloader</title>
</head>
<body>
    <form method="POST">
        <input type="text" name="url" placeholder="Tempel link TikTok" required>
        <button type="submit">Download</button>
    </form>
</body>
</html>
