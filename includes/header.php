<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/functions.php';

$pageTitle = $pageTitle ?? APP_NAME;
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= e($pageTitle) ?> — <?= APP_NAME ?></title>

    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<header class="site-header">

    <div class="container nav-wrap">

        <!-- LOGO -->
        <a href="index.php" class="brand" id="oceangoLogo">
            <span class="brand-mark">⚓</span>
            <span>OCEANGO</span>
        </a>


        <!-- NAVIGASI -->
        <nav class="main-nav">

            <a href="index.php">Beranda</a>

            <a href="search.php">Cari Tiket</a>

            <a href="index.php#promo">Promo</a>

            <a href="index.php#about">Tentang Kami</a>

        </nav>


        <!-- USER ACTION -->
        <div class="nav-actions">

            <?php if (is_logged_in()): ?>

                <span class="user-chip">
                    👤 <?= e($_SESSION['user']['name']) ?>
                </span>

                <a
                    href="logout.php"
                    class="btn btn-dark btn-sm"
                >
                    Keluar
                </a>

            <?php else: ?>

                <a
                    href="login.php"
                    class="login-link"
                >
                    Masuk
                </a>

                <a
                    href="register.php"
                    class="btn btn-dark btn-sm"
                >
                    Daftar
                </a>

            <?php endif; ?>

        </div>


        <!-- MOBILE -->
        <button
            type="button"
            class="mobile-menu"
            id="mobileMenuButton"
        >
            ☰
        </button>

    </div>

</header>


<!-- =====================================================
     SECRET ADMIN ACCESS
     KLIK LOGO OCEANGO 5X
===================================================== -->

<div
    class="admin-secret-overlay"
    id="adminSecretOverlay"
>

    <div class="admin-secret-modal">

        <button
            type="button"
            class="admin-secret-close"
            id="closeAdminSecret"
        >
            ×
        </button>


        <div class="admin-secret-icon">
            ⚓
        </div>


        <span class="admin-secret-label">
            OCEANGO MANAGEMENT
        </span>


        <h3>
            Kelola Oceango
        </h3>


        <p>
            Akses khusus untuk mengelola kapal,
            jadwal, booking, pengguna, dan transaksi Oceango.
        </p>


        <a
            href="admin/login.php"
            class="admin-secret-button"
        >
            Masuk ke Admin
            <span>→</span>
        </a>

    </div>

</div>


<main>


<script>

document.addEventListener("DOMContentLoaded", function () {

    const logo = document.getElementById("oceangoLogo");
    const overlay = document.getElementById("adminSecretOverlay");
    const closeButton = document.getElementById("closeAdminSecret");
    const mobileButton = document.getElementById("mobileMenuButton");

    /*
    =====================================================
    MOBILE MENU
    =====================================================
    */

    if (mobileButton) {

        mobileButton.addEventListener("click", function () {

            document.body.classList.toggle("menu-open");

        });

    }


    /*
    =====================================================
    SECRET ADMIN
    KLIK LOGO OCEANGO 5X
    =====================================================
    */

    if (logo && overlay) {

        let clickCount = 0;
        let clickTimer = null;

        logo.addEventListener("click", function (event) {

            clickCount++;

            /*
            Jangan langsung pindah halaman
            selama proses klik logo.
            */
            event.preventDefault();

            clearTimeout(clickTimer);

            /*
            Kalau tidak mencapai 5 klik
            dalam 2 detik, hitungan direset.
            */
            clickTimer = setTimeout(function () {

                clickCount = 0;

            }, 2000);


            /*
            ================================
            SUDAH 5 KLIK
            ================================
            */

            if (clickCount === 5) {

                clickCount = 0;

                clearTimeout(clickTimer);

                overlay.classList.add("active");

            }

        });

    }


    /*
    =====================================================
    CLOSE ADMIN MODAL
    =====================================================
    */

    if (closeButton && overlay) {

        closeButton.addEventListener("click", function () {

            overlay.classList.remove("active");

        });

    }


    /*
    =====================================================
    KLIK DI LUAR MODAL
    =====================================================
    */

    if (overlay) {

        overlay.addEventListener("click", function (event) {

            if (event.target === overlay) {

                overlay.classList.remove("active");

            }

        });

    }


    /*
    =====================================================
    ESC UNTUK MENUTUP
    =====================================================
    */

    document.addEventListener("keydown", function (event) {

        if (event.key === "Escape" && overlay) {

            overlay.classList.remove("active");

        }

    });

});

</script>