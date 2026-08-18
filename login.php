<?php
require_once "config.php";
require_once "includes/functions.php";
$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($pdo) {
        $stmt = $pdo->prepare("SELECT id,name,email,password FROM users WHERE email=? LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password'])) {
            unset($user['password']);
            $_SESSION['user'] = $user;
            header("Location: search.php");
            exit;
        }
    }
    // Demo login: email apa saja yang sudah terdaftar di sesi
    if (!empty($_SESSION['registered_demo']) && $email === $_SESSION['registered_demo']['email'] && $password === $_SESSION['registered_demo']['password']) {
        $_SESSION['user'] = $_SESSION['registered_demo'];
        header("Location: search.php"); exit;
    }
    $error = "Email atau password salah.";
}
$pageTitle = "Masuk";
include "includes/header.php";
?>
<div class="auth-page">
    <div class="auth-card">
        <a class="auth-logo" href="index.php">⚓ OCEANGO</a>
        <div class="auth-head"><span class="eyebrow dark">SELAMAT DATANG KEMBALI!</span><h1>Masuk ke akunmu</h1><p>Login untuk melanjutkan pemesanan tiket kapal.</p></div>
        <?php if ($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>
        <form method="post" class="form-stack">
            <label>Email<input type="email" name="email" required placeholder="nama@email.com"></label>
            <label>Password<div class="password-wrap"><input id="password" type="password" name="password" required placeholder="Masukkan password"><button type="button" onclick="togglePassword('password')">👁</button></div></label>
            <div class="form-row-between"><label class="check"><input type="checkbox"> Ingat saya</label><a href="#">Lupa Password?</a></div>
            <button class="btn btn-primary full" type="submit">Login</button>
        </form>
        <p class="auth-bottom">Belum punya akun? <a href="register.php">Daftar di sini</a></p>
    </div>
</div>
<?php include "includes/footer.php"; ?>