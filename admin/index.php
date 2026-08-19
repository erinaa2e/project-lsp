<?php

$pageTitle = "Dashboard";

include "includes/header.php";

?>

<div class="page-header">

    <div>

        <h2>
            Dashboard 👋
        </h2>

        <p>
            Selamat datang kembali di Oceango Management.
        </p>

    </div>


    <div class="page-actions">

        <a
            href="jadwal.php"
            class="admin-btn admin-btn-primary"
        >
            + Tambah Jadwal
        </a>

    </div>

</div>


<!-- STATISTICS -->

<div class="stats-grid">

    <div class="stat-card">

        <div class="stat-top">

            <div class="stat-icon purple">
                🚢
            </div>

        </div>

        <h3>
            24
        </h3>

        <p>
            Total Kapal
        </p>

        <span class="stat-growth">
            ↑ 8% bulan ini
        </span>

    </div>


    <div class="stat-card">

        <div class="stat-top">

            <div class="stat-icon blue">
                🎫
            </div>

        </div>

        <h3>
            186
        </h3>

        <p>
            Total Booking
        </p>

        <span class="stat-growth">
            ↑ 12% bulan ini
        </span>

    </div>


    <div class="stat-card">

        <div class="stat-top">

            <div class="stat-icon green">
                💳
            </div>

        </div>

        <h3>
            Rp 28,5jt
        </h3>

        <p>
            Pendapatan
        </p>

        <span class="stat-growth">
            ↑ 15% bulan ini
        </span>

    </div>


    <div class="stat-card">

        <div class="stat-top">

            <div class="stat-icon orange">
                👥
            </div>

        </div>

        <h3>
            542
        </h3>

        <p>
            Pengguna
        </p>

        <span class="stat-growth">
            ↑ 6% bulan ini
        </span>

    </div>

</div>


<!-- DASHBOARD -->

<div class="dashboard-grid">


    <!-- TRANSACTIONS -->

    <div class="admin-card">

        <div class="admin-card-header">

            <h3>
                Booking Terbaru
            </h3>

            <a href="booking.php">
                Lihat Semua →
            </a>

        </div>


        <div class="admin-table-wrap">

            <table class="admin-table">

                <thead>

                    <tr>

                        <th>
                            PENUMPANG
                        </th>

                        <th>
                            RUTE
                        </th>

                        <th>
                            TANGGAL
                        </th>

                        <th>
                            TOTAL
                        </th>

                        <th>
                            STATUS
                        </th>

                    </tr>

                </thead>


                <tbody>

                    <tr>

                        <td>

                            <div class="table-name">

                                <div class="table-avatar">
                                    👩
                                </div>

                                <div>

                                    <strong>
                                        Erinna
                                    </strong>

                                    <small>
                                        #OCG00124
                                    </small>

                                </div>

                            </div>

                        </td>

                        <td>
                            Surabaya → Jakarta
                        </td>

                        <td>
                            12 Agu 2026
                        </td>

                        <td>
                            Rp 450.000
                        </td>

                        <td>

                            <span class="status status-success">
                                Berhasil
                            </span>

                        </td>

                    </tr>


                    <tr>

                        <td>

                            <div class="table-name">

                                <div class="table-avatar">
                                    👨
                                </div>

                                <div>

                                    <strong>
                                        Andi
                                    </strong>

                                    <small>
                                        #OCG00123
                                    </small>

                                </div>

                            </div>

                        </td>

                        <td>
                            Jakarta → Surabaya
                        </td>

                        <td>
                            12 Agu 2026
                        </td>

                        <td>
                            Rp 375.000
                        </td>

                        <td>

                            <span class="status status-warning">
                                Menunggu
                            </span>

                        </td>

                    </tr>


                    <tr>

                        <td>

                            <div class="table-name">

                                <div class="table-avatar">
                                    👩
                                </div>

                                <div>

                                    <strong>
                                        Sinta
                                    </strong>

                                    <small>
                                        #OCG00122
                                    </small>

                                </div>

                            </div>

                        </td>

                        <td>
                            Bali → Lombok
                        </td>

                        <td>
                            11 Agu 2026
                        </td>

                        <td>
                            Rp 280.000
                        </td>

                        <td>

                            <span class="status status-success">
                                Berhasil
                            </span>

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>


    <!-- QUICK ACTION -->

    <div class="admin-card">

        <div class="admin-card-header">

            <h3>
                Aksi Cepat
            </h3>

        </div>


        <div class="admin-card-body">

            <div class="quick-actions">

                <a
                    href="kapal.php"
                    class="quick-action"
                >

                    <div class="quick-action-icon">
                        🚢
                    </div>

                    <div>

                        <strong>
                            Kelola Kapal
                        </strong>

                        <small>
                            Tambah & edit kapal
                        </small>

                    </div>

                </a>


                <a
                    href="jadwal.php"
                    class="quick-action"
                >

                    <div class="quick-action-icon">
                        🗓
                    </div>

                    <div>

                        <strong>
                            Jadwal
                        </strong>

                        <small>
                            Atur jadwal kapal
                        </small>

                    </div>

                </a>


                <a
                    href="booking.php"
                    class="quick-action"
                >

                    <div class="quick-action-icon">
                        🎫
                    </div>

                    <div>

                        <strong>
                            Booking
                        </strong>

                        <small>
                            Kelola tiket
                        </small>

                    </div>

                </a>


                <a
                    href="pengguna.php"
                    class="quick-action"
                >

                    <div class="quick-action-icon">
                        👥
                    </div>

                    <div>

                        <strong>
                            Pengguna
                        </strong>

                        <small>
                            Data pelanggan
                        </small>

                    </div>

                </a>

            </div>

        </div>

    </div>

</div>


<?php

include "includes/footer.php";

?>