<?php
// File: buat_password.php
// Gunakan file ini untuk generate hash password baru

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['password'])) {
    $password = $_POST['password'];
    $hash = password_hash($password, PASSWORD_DEFAULT);
    echo "<div style='background: #d4edda; padding: 20px; border-radius: 8px; margin: 20px;'>";
    echo "<h3>Hash untuk password '<strong>" . htmlspecialchars($password) . "</strong>':</h3>";
    echo "<p style='background: #fff; padding: 10px; font-family: monospace; word-break: break-all;'>" . $hash . "</p>";
    echo "<p>Copy hash di atas ke kolom password di tabel tbl_admin.</p>";
    echo "</div>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Generate Password Hash</title>
</head>
<body style="font-family: Arial; padding: 50px;">
    <h1>Generator Password Hash untuk Admin</h1>
    <form method="POST">
        <label>Password:</label>
        <input type="text" name="password" required style="padding: 10px; width: 300px;">
        <button type="submit" style="padding: 10px 20px;">Generate Hash</button>
    </form>
    <hr>
    <p><strong>Default password untuk admin adalah: admin123</strong></p>
    <p>Copy hash berikut ke database:</p>
    <code>$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi</code>
    <p><small>Ini adalah hash dari 'admin123'</small></p>
</body>
</html>