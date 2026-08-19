<?php

require_once __DIR__ . '/includes/functions.php';

if (admin_logged_in()) {

    header('Location: dashboard.php');

    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username =
        trim($_POST['username'] ?? '');

    $password =
        $_POST['password'] ?? '';


    if (
        $username === 'admin'
        &&
        $password === 'admin123'
    ) {

        $_SESSION['oceango_admin'] = true;

        $_SESSION['admin_name'] =
            'Administrator';

        header('Location: dashboard.php');

        exit;

    }


    $error =
        'Username atau password salah.';
}

?>

<!DOCTYPE html>

<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Login Admin — Oceango
    </title>

    <link
        rel="stylesheet"
        href="assets/css/admin.css"
    >

</head>

<body class="login-body">


<div class="login-page">


    <div class="login-box">


        <div class="login-brand">

            <div class="login-anchor">
                ⚓
            </div>

            <h2>
                OCEANGO
            </h2>

            <span>
                ADMIN MANAGEMENT
            </span>

        </div>


        <h1>
            Login Admin
        </h1>

        <p>
            Masuk untuk mengelola seluruh
            aktivitas Oceango.
        </p>


        <?php if ($error): ?>

            <div class="error">
                <?= e($error) ?>
            </div>

        <?php endif; ?>


        <form method="POST">


            <div class="field">

                <label>
                    USERNAME
                </label>

                <input
                    type="text"
                    name="username"
                    value="admin"
                    required
                >

            </div>


            <div class="field">

                <label>
                    PASSWORD
                </label>

                <input
                    type="password"
                    name="password"
                    placeholder="Masukkan password"
                    required
                >

            </div>


            <button
                type="submit"
                class="btn btn-primary login-submit"
            >
                Masuk ke Dashboard →
            </button>


        </form>


        <div class="login-hint">

            <b>
                Login demo
            </b>

            <br>

            Username:
            <strong>admin</strong>

            <br>

            Password:
            <strong>admin123</strong>

        </div>


        <div class="login-back">

            <a href="../index.php">
                ← Kembali ke website Oceango
            </a>

        </div>


    </div>

</div>


</body>

</html>