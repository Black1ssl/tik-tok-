<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $url = trim($_POST["url"]);

    if (empty($url)) {
        die("URL tidak boleh kosong");
    }

    $allowed = [
        "tiktok.com",
        "instagram.com",
        "youtube.com",
        "youtu.be",
        "twitter.com",
        "x.com"
    ];

    $valid = false;
    foreach ($allowed as $domain) {
        if (stripos($url, $domain) !== false) {
            $valid = true;
            break;
        }
    }

    if (!$valid) {
        die("Platform belum didukung.");
    }

    $safe_url = escapeshellarg($url);
    $filename = "video_" . time() . ".mp4";
    $filepath = "/tmp/" . $filename;

    // COMMAND YANG BENAR
    $command = "yt-dlp -f mp4 --merge-output-format mp4 -o $filepath $safe_url 2>&1";
    $output = shell_exec($command);

    if (!file_exists($filepath)) {
        die("<pre>Gagal mengunduh video:\n$output</pre>");
    }

    header("Content-Type: video/mp4");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header("Content-Length: " . filesize($filepath));
    readfile($filepath);

    unlink($filepath);
    exit;
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Multi Platform Video Downloader</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .box {
            background: #fff;
            padding: 25px;
            width: 360px;
            border-radius: 8px;
            box-shadow: 0 6px 15px rgba(0,0,0,.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 10px;
        }
        p {
            font-size: 13px;
            text-align: center;
            color: #666;
            margin-bottom: 15px;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 12px;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #000;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background: #333;
        }
    </style>
</head>
<body>

<div class="box">
    <h2>Video Downloader</h2>
    <p>Mendukung TikTok, Instagram, YouTube Shorts, Twitter (X)</p>

    <form method="POST">
        <input type="text" name="url" placeholder="Tempel link video" required>
        <button type="submit">Download</button>
    </form>
</div>

</body>
</html>
