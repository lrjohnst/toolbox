<?php
$result = "";
$highlighted = "";
$to_encode = "";
$error = "";

function highlight_json(string $json): string {
    $escaped = htmlspecialchars($json);
    // Keys (quoted strings before a colon)
    $escaped = preg_replace('/^(\s*)(&quot;.+?&quot;)(\s*:)/m', '$1<span class="jk">$2</span>$3', $escaped);
    // String values (remaining quoted strings)
    $escaped = preg_replace('/(&quot;.*?&quot;)/', '<span class="js">$1</span>', $escaped);
    // Numbers
    $escaped = preg_replace('/: (\d+\.?\d*)(,?)$/m', ': <span class="jn">$1</span>$2', $escaped);
    $escaped = preg_replace('/^(\s*)(\d+\.?\d*)(,?)$/m', '$1<span class="jn">$2</span>$3', $escaped);
    // Booleans and null
    $escaped = preg_replace('/\b(true|false)\b/', '<span class="jb">$1</span>', $escaped);
    $escaped = preg_replace('/\b(null)\b/', '<span class="jnull">$1</span>', $escaped);
    return $escaped;
}

if (isset($_POST['to_encode']) && $_POST['to_encode'] !== "") {
    $to_encode = $_POST['to_encode'];
    $decoded = json_decode($to_encode);

    if ($decoded === null && json_last_error() !== JSON_ERROR_NONE) {
        $error = "Invalid JSON: " . json_last_error_msg();
    } else {
        $result = json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $highlighted = highlight_json($result);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JSON Prettify — Phitech Toolbox</title>
    <meta name="description" content="Paste JSON and get a prettified, readable version back.">
    <link rel="stylesheet" href="/style.css">
    <style>
        .json-output { background: #1e1e2e; color: #cdd6f4; border-radius: 6px; padding: 1rem; overflow-x: auto; font-size: 0.85rem; line-height: 1.6; }
        .jk { color: #89b4fa; } /* keys */
        .js { color: #a6e3a1; } /* strings */
        .jn { color: #fab387; } /* numbers */
        .jb { color: #cba6f7; } /* booleans */
        .jnull { color: #6c7086; font-style: italic; } /* null */
    </style>
</head>
<body>
<nav>
    <a href="/" class="brand">Phitech Toolbox</a>
    <a href="/base64">Base64</a>
    <a href="/json-encode" class="active">JSON</a>
    <a href="/openssl-encrypt">OpenSSL</a>
</nav>
<div class="container">
    <h1>JSON Prettify</h1>
    <p>Paste your JSON to get a formatted, readable version.</p>
    <form action="/" method="post">
        <div class="form-row">
            <label for="to_encode">JSON input:</label>
            <textarea id="to_encode" name="to_encode" rows="10"><?php echo htmlspecialchars($to_encode); ?></textarea>
        </div>
        <input type="submit" value="Prettify">
    </form>
    <?php if ($error !== ""): ?>
        <div class="result">
            <div class="result-label" style="color:#e74c3c;"><?php echo htmlspecialchars($error); ?></div>
        </div>
    <?php endif; ?>
    <?php if ($highlighted !== ""): ?>
        <div class="result">
            <div class="result-label">Prettified JSON:</div>
            <pre class="json-output"><?php echo $highlighted; ?></pre>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
