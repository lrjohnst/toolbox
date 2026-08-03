<?php
$result = "";
$resultstring = "";
$to_encode = "";
$radio_encode = "";
$radio_decode = "";
if (isset($_POST['encode_or_decode'])) {
    $to_encode = $_POST['to_encode'];
    if ($_POST['encode_or_decode'] === 'encode') {
        $result = base64_encode($to_encode);
        $resultstring = "encoded to Base64";
        $radio_encode = 'checked="checked"';
    }
    if ($_POST['encode_or_decode'] === 'decode') {
        $decoded = base64_decode($to_encode, true);
        if ($decoded === false) {
            $result = "";
            $resultstring = "error: invalid Base64 input";
        } else {
            $result = $decoded;
            $resultstring = "decoded from Base64";
        }
        $radio_decode = 'checked="checked"';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Base64 Encode / Decode — Phitech Toolbox</title>
    <meta name="description" content="A simple encoding and decoding tool for Base64.">
    <link rel="stylesheet" href="/style.css">
</head>
<body>
<nav>
    <a href="/" class="brand">Phitech Toolbox</a>
    <a href="/base64" class="active">Base64</a>
    <a href="/json-encode">JSON</a>
    <a href="/openssl-encrypt">OpenSSL</a>
</nav>
<div class="container">
    <h1>Base64 Encode / Decode</h1>
    <p>Enter your string to encode or decode and hit submit.</p>
    <form action="/base64/" method="post">
        <div class="form-row">
            <label for="to_encode">Input string:</label>
            <textarea id="to_encode" name="to_encode" rows="8"><?php echo htmlspecialchars($to_encode); ?></textarea>
        </div>
        <div class="radio-group">
            <label><input type="radio" name="encode_or_decode" value="encode" <?php echo $radio_encode; ?>> Encode to Base64</label>
            <label><input type="radio" name="encode_or_decode" value="decode" <?php echo $radio_decode; ?>> Decode from Base64</label>
        </div>
        <input type="submit" value="Submit">
    </form>
    <?php if ($resultstring !== ""): ?>
        <div class="result">
            <div class="result-label">Your string <?php echo htmlspecialchars($resultstring); ?>:</div>
            <textarea rows="8" disabled><?php echo htmlspecialchars($result); ?></textarea>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
