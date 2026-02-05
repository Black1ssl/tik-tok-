<?php
// index.php
$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $url = trim($_POST["url"]);

    if (empty($url)) {
        $error = "URL tidak boleh kosong.";
    } else {
        // Sanitasi URL (keamanan dasar)
        $safe_url = escapeshellarg($url);

        // Perintah yt-dlp
        $command = "yt-dlp -f mp4 -o 'video_%(id)s.%(ext)s' $safe_url 2>&1";

        // Eksekusi
        $output = shell_exec($command);

        if ($output) {
            $success = "Video berhasil diunduh.";
        } else {
            $error = "Gagal mengunduh video.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>TikTok Downloader</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .box {
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            width: 350px;
            box-shadow: 0 5px 15px rgba(0,0,0,.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
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
        .error {
            color: red;
            margin-bottom: 10px;
            text-align: center;
        }
        .success {
            color: green;
            margin-bottom: 10px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="box">
    <h2>TikTok Downloader</h2>

    <?php if ($error): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="success"><?= $success ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="url" placeholder="Tempel link TikTok" required>
        <button type="submit">Download</button>
    </form>
</div>

</body>
</html>
