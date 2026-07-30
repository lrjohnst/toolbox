<?php
$result = "";
$resultstring = "";
$to_encode = "";
$radio_encode = "";
$radio_decode = "";
$cipher_selected = "aes-256-cbc";
$key = "";
if (isset($_POST['encode_or_decode'])) {
    $to_encode = $_POST['to_encode'];
    $cipher_selected = $_POST['encryption_cipher'];
    $key = $_POST['encryption_key'];
    if ($_POST['encode_or_decode'] === 'encode') {
        $result = openssl_encrypt($to_encode, $cipher_selected, $key);
        $resultstring = "encrypted with " . $cipher_selected;
        $radio_encode = 'checked="checked"';
    }
    if ($_POST['encode_or_decode'] === 'decode') {
        $decrypted = openssl_decrypt($to_encode, $cipher_selected, $key);
        if ($decrypted === false) {
            $result = "";
            $resultstring = "error: decryption failed (wrong key or cipher?)";
        } else {
            $result = $decrypted;
            $resultstring = "decrypted from " . $cipher_selected;
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
    <title>OpenSSL Encrypt / Decrypt — Phitech Toolbox</title>
    <meta name="description" content="A simple encryption and decryption tool using OpenSSL ciphers.">
    <link rel="stylesheet" href="/style.css">
</head>
<body>
<nav>
    <a href="/" class="brand">Phitech Toolbox</a>
    <a href="/base64">Base64</a>
    <a href="/json-encode">JSON</a>
    <a href="/openssl-encrypt" class="active">OpenSSL</a>
</nav>
<div class="container">
    <h1>OpenSSL Encrypt / Decrypt</h1>
    <p>Enter your string to encrypt or decrypt and hit submit.</p>
    <form action="/" method="post">
        <div class="form-row">
            <label for="encryption_cipher">Encryption cipher:</label>
            <select name="encryption_cipher" id="encryption_cipher">
                <?php foreach (openssl_get_cipher_methods() as $cipher): ?>
                    <option value="<?php echo htmlspecialchars($cipher); ?>"<?php echo ($cipher_selected === $cipher) ? " selected" : ""; ?>><?php echo htmlspecialchars($cipher); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-row">
            <label for="encryption_key">Encryption key:</label>
            <input type="text" id="encryption_key" name="encryption_key" value="<?php echo htmlspecialchars($key); ?>">
        </div>
        <div class="form-row">
            <label for="to_encode">String to encrypt or decrypt:</label>
            <textarea id="to_encode" name="to_encode" rows="8"><?php echo htmlspecialchars($to_encode); ?></textarea>
        </div>
        <div class="radio-group">
            <label><input type="radio" name="encode_or_decode" value="encode" <?php echo $radio_encode; ?>> Encrypt</label>
            <label><input type="radio" name="encode_or_decode" value="decode" <?php echo $radio_decode; ?>> Decrypt</label>
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
