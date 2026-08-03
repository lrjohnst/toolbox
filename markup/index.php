<?php
require __DIR__ . '/Parsedown.php';

$to_markup = "";
$rendered = "";

if (isset($_POST['to_markup']) && $_POST['to_markup'] !== "") {
    $to_markup = $_POST['to_markup'];
    $parsedown = new Parsedown();
    $parsedown->setSafeMode(true);        // escape raw HTML (XSS-bescherming)
    $parsedown->setBreaksEnabled(true);   // enkele newline = <br>
    $rendered = $parsedown->text($to_markup);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Markup Preview — Phitech Toolbox</title>
    <meta name="description" content="Paste Markdown and get a nicely formatted preview.">
    <link rel="stylesheet" href="/style.css">
    <style>
        .markup-preview { background: #fff; border: 1px solid #ddd; border-radius: 6px; padding: 1.25rem 1.5rem; }
        .markup-preview h1, .markup-preview h2, .markup-preview h3 { color: #2c3e50; margin: 1rem 0 0.5rem; }
        .markup-preview h1 { font-size: 1.6rem; border-bottom: 1px solid #eee; padding-bottom: 0.3rem; }
        .markup-preview h2 { font-size: 1.3rem; border-bottom: 1px solid #eee; padding-bottom: 0.2rem; }
        .markup-preview h3 { font-size: 1.1rem; }
        .markup-preview p { margin: 0.6rem 0; }
        .markup-preview ul, .markup-preview ol { margin: 0.6rem 0 0.6rem 1.5rem; }
        .markup-preview li { margin: 0.2rem 0; }
        .markup-preview code { background: #f0f0f0; padding: 0.1rem 0.35rem; border-radius: 3px; font-size: 0.88rem; }
        .markup-preview pre { background: #1e1e2e; color: #cdd6f4; padding: 1rem; border-radius: 6px; overflow-x: auto; margin: 0.75rem 0; }
        .markup-preview pre code { background: none; padding: 0; color: inherit; }
        .markup-preview blockquote { border-left: 4px solid #3498db; margin: 0.75rem 0; padding: 0.25rem 1rem; color: #555; background: #f8fafd; }
        .markup-preview a { color: #3498db; }
        .markup-preview table { border-collapse: collapse; margin: 0.75rem 0; width: 100%; }
        .markup-preview th, .markup-preview td { border: 1px solid #ddd; padding: 0.4rem 0.6rem; text-align: left; }
        .markup-preview th { background: #f5f5f5; }
        .markup-preview img { max-width: 100%; }
        .markup-preview hr { border: none; border-top: 1px solid #ddd; margin: 1rem 0; }
    </style>
</head>
<body>
<nav>
    <a href="/" class="brand">Phitech Toolbox</a>
    <a href="/base64">Base64</a>
    <a href="/json-encode">JSON</a>
    <a href="/openssl-encrypt">OpenSSL</a>
    <a href="/markup" class="active">Markup</a>
</nav>
<div class="container">
    <h1>Markup Preview</h1>
    <p>Paste Markdown text to see it nicely formatted.</p>
    <form action="/markup/" method="post">
        <div class="form-row">
            <label for="to_markup">Markdown input:</label>
            <textarea id="to_markup" name="to_markup" rows="12"><?php echo htmlspecialchars($to_markup); ?></textarea>
        </div>
        <input type="submit" value="Preview">
    </form>
    <?php if ($rendered !== ""): ?>
        <div class="result">
            <div class="result-label">Preview:</div>
            <div class="markup-preview"><?php echo $rendered; ?></div>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
