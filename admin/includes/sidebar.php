<?php

$currentPage =
    basename($_SERVER['PHP_SELF']);

?>

<aside class="admin-sidebar">

    <div class="sidebar-brand">

        <div class="sidebar-logo">
            ⚓
        </div>

        <div>

            <strong>
                OCEANGO
            </strong>

            <span>
                ADMIN
            </span>

        </div>

    </div>


    <div class="sidebar-section-title">
        OVERVIEW
    </div>


    <nav class="admin-nav">

        <a
            href="dashboard.php"
            class="<?= $currentPage === 'dashboard.php' ? 'active' : '' ?>"
        >
            <span>⌂</span>
            Dashboard
        </a>

    </nav>


    <div class="sidebar-section-title">
        MANAGEMENT
    </div>


    <nav class="admin-nav">

        <a
            href="kapal.php"
            class="<?= $currentPage === 'kapal.php' ? 'active' : '' ?>"
        >
            <span>🚢</span>
            Kapal
        </a>


        <a
            href="jadwal.php"
            class="<?= $currentPage === 'jadwal.php' ? 'active' : '' ?>"
        >
            <span>📅</span>
            Jadwal
        </a>


        <a
            href="rute.php"
            class="<?= $currentPage === 'rute.php' ? 'active' : '' ?>"
        >
            <span>🗺️</span>
            Rute
        </a>


        <a
            href="kursi.php"
            class="<?= $currentPage === 'kursi.php' ? 'active' : '' ?>"
        >
            <span>💺</span>
            Kursi
        </a>

    </nav>


    <div class="sidebar-section-title">
        TRANSACTIONS
    </div>


    <nav class="admin-nav">

        <a
            href="booking.php"
            class="<?= $currentPage === 'booking.php' ? 'active' : '' ?>"
        >
            <span>🎫</span>
            Booking

            <small class="menu-badge">
                8
            </small>

        </a>


        <a
            href="pembayaran.php"
            class="<?= $currentPage === 'pembayaran.php' ? 'active' : '' ?>"
        >
            <span>💳</span>
            Pembayaran

        </a>

    </nav>


    <div class="sidebar-section-title">
        USERS & REPORT
    </div>


    <nav class="admin-nav">

        <a
            href="penumpang.php"
            class="<?= $currentPage === 'penumpang.php' ? 'active' : '' ?>"
        >
            <span>👥</span>
            Penumpang
        </a>


        <a
            href="laporan.php"
            class="<?= $currentPage === 'laporan.php' ? 'active' : '' ?>"
        >
            <span>📊</span>
            Laporan
        </a>

    </nav>


    <div class="sidebar-bottom">

        <a href="logout.php">

            <span>↪</span>

            Keluar

        </a>

    </div>

</aside>