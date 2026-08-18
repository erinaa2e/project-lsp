<?php
require_once "config.php";
require_once "includes/functions.php";
$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';
    if ($password !== $confirm) $error = "Konfirmasi password tidak sama.";
    elseif (strlen($password) < 6) $error = "Password minimal 6 karakter.";
    elseif ($pdo) {
        $check = $pdo->prepare("SELECT id FROM users WHERE email=?");
        $check->execute([$email]);
        if ($check->fetch()) $error = "Email sudah terdaftar.";
        else {
            $stmt = $pdo->prepare("INSERT INTO users(name,email,phone,password) VALUES(?,?,?,?)");
            $stmt->execute([$name,$email,$phone,password_hash($password,PASSWORD_DEFAULT)]);
            $_SESSION['user'] = ["id"=>$pdo->lastInsertId(),"name"=>$name,"email"=>$email,"phone"=>$phone];
            header("Location: search.php"); exit;
        }
    } else {
        $_SESSION['registered_demo'] = ["id"=>1,"name"=>$name,"email"=>$email,"phone"=>$phone,"password"=>$password];
        $_SESSION['user'] = ["id"=>1,"name"=>$name,"email"=>$email,"phone"=>$phone];
        header("Location: search.php"); exit;
    }
}
$pageTitle = "Daftar";
include "includes/header.php";
?>
<div class="auth-page">
    <div class="auth-card wide">
        <a class="auth-logo" href="index.php">⚓ OCEANGO</a>
        <div class="auth-head"><span class="eyebrow dark">BUAT AKUN BARU</span><h1>Mulai perjalananmu</h1><p>Daftar untuk menyimpan pesanan dan mendapatkan e-ticket.</p></div>
        <?php if ($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>
        <form method="post" class="form-grid">
            <label class="full-col">Nama Lengkap<input name="name" required placeholder="Masukkan nama lengkap"></label>
            <label>Email<input type="email" name="email" required placeholder="nama@email.com"></label>
            <label>Nomor Telepon<input name="phone" required placeholder="08xxxxxxxxxx"></label>
            <label>Password<input type="password" name="password" required placeholder="Minimal 6 karakter"></label>
            <label>Konfirmasi Password<input type="password" name="confirm" required placeholder="Ulangi password"></label>
            <label class="check full-col"><input type="checkbox" required> Saya menyetujui Syarat & Ketentuan dan Kebijakan Privasi.</label>
            <button class="btn btn-primary full full-col" type="submit">Daftar Sekarang</button>
        </form>
        <p class="auth-bottom">Sudah punya akun? <a href="login.php">Login di sini</a></p>
    </div>
</div>
<?php include "includes/footer.php"; ?>