<?php

require_once __DIR__ . '/functions.php';

require_admin();

$pageTitle = $pageTitle ?? 'Dashboard';

$currentPage = basename(
    $_SERVER['PHP_SELF']
);

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
        <?= e($pageTitle) ?> — Oceango Admin
    </title>

    <link
        rel="stylesheet"
        href="assets/css/admin.css"
    >

</head>

<body>

<div class="app">

    <!-- SIDEBAR -->

    <aside
        class="sidebar"
        id="sidebar"
    >

        <div class="brand">

            <div class="brand-mark">
                ⚓
            </div>

            <div>

                <b>
                    OCEANGO
                </b>

                <span>
                    MANAGEMENT
                </span>

            </div>

        </div>


        <div class="menu-title">
            MAIN MENU
        </div>


        <nav>

            <a
                href="dashboard.php"
                class="<?= $currentPage === 'dashboard.php' ? 'active' : '' ?>"
            >
                <span>▦</span>
                Dashboard
            </a>


            <a
                href="kapal.php"
                class="<?= $currentPage === 'kapal.php' ? 'active' : '' ?>"
            >
                <span>🚢</span>
                Kelola Kapal
            </a>


            <a
                href="jadwal.php"
                class="<?= $currentPage === 'jadwal.php' ? 'active' : '' ?>"
            >
                <span>🗓</span>
                Jadwal
            </a>


            <a
                href="booking.php"
                class="<?= $currentPage === 'booking.php' ? 'active' : '' ?>"
            >
                <span>🎫</span>
                Booking

                <em>
                    12
                </em>

            </a>


            <a
                href="pengguna.php"
                class="<?= $currentPage === 'pengguna.php' ? 'active' : '' ?>"
            >
                <span>👥</span>
                Pengguna
            </a>

        </nav>


        <div class="menu-title">
            SYSTEM
        </div>


        <nav>

            <a href="../index.php">

                <span>
                    🌐
                </span>

                Lihat Website

            </a>


            <a href="logout.php">

                <span>
                    ↪
                </span>

                Keluar

            </a>

        </nav>


        <div class="profile">

            <div class="avatar">
                A
            </div>

            <div>

                <b>
                    Administrator
                </b>

                <small>
                    Admin Oceango
                </small>

            </div>

        </div>

    </aside>


    <!-- MAIN -->

    <main class="main">


        <!-- TOPBAR -->

        <header class="topbar">

            <button
                class="hamburger"
                onclick="toggleSidebar()"
            >
                ☰
            </button>


            <div>

                <small>
                    OCEANGO MANAGEMENT
                </small>

                <h1>
                    <?= e($pageTitle) ?>
                </h1>

            </div>


            <div class="top-user">

                <span class="bell">
                    🔔
                </span>


                <div class="avatar sm">
                    A
                </div>


                <div>

                    <b>
                        Administrator
                    </b>

                    <small>
                        ● Online
                    </small>

                </div>

            </div>

        </header>


        <!-- CONTENT -->

        <section class="content">