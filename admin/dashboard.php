<?php

$pageTitle = 'Dashboard';

include __DIR__ . '/includes/header.php';

?>


<div class="page-head">

    <div>

        <h2>
            Dashboard 👋
        </h2>

        <p>
            Ringkasan aktivitas Oceango hari ini.
        </p>

    </div>


    <a
        href="jadwal.php?action=tambah"
        class="btn btn-primary"
    >
        + Tambah Jadwal
    </a>

</div>


<!-- STAT -->

<div class="stats">


    <div class="card stat">

        <div class="stat-icon">
            🚢
        </div>

        <h3>
            24
        </h3>

        <p>
            Total Kapal
        </p>

        <span class="growth">
            ↑ 8% bulan ini
        </span>

    </div>


    <div class="card stat">

        <div class="stat-icon">
            🎫
        </div>

        <h3>
            186
        </h3>

        <p>
            Total Booking
        </p>

        <span class="growth">
            ↑ 12% bulan ini
        </span>

    </div>


    <div class="card stat">

        <div class="stat-icon">
            💳
        </div>

        <h3>
            Rp 28,5jt
        </h3>

        <p>
            Pendapatan
        </p>

        <span class="growth">
            ↑ 15% bulan ini
        </span>

    </div>


    <div class="card stat">

        <div class="stat-icon">
            👥
        </div>

        <h3>
            542
        </h3>

        <p>
            Pengguna
        </p>

        <span class="growth">
            ↑ 6% bulan ini
        </span>

    </div>

</div>


<div class="grid2">


    <!-- BOOKING -->

    <div class="card">

        <div class="card-head">

            <h3>
                Booking Terbaru
            </h3>

            <a href="booking.php">
                Lihat Semua →
            </a>

        </div>


        <div class="table-wrap">

            <table class="table">

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

                            <div class="name">

                                <div class="mini-avatar">
                                    E
                                </div>

                                <div>

                                    <b>
                                        Erinna
                                    </b>

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

                            <span class="status success">
                                Berhasil
                            </span>

                        </td>

                    </tr>


                    <tr>

                        <td>

                            <div class="name">

                                <div class="mini-avatar">
                                    A
                                </div>

                                <div>

                                    <b>
                                        Andi
                                    </b>

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

                            <span class="status warning">
                                Menunggu
                            </span>

                        </td>

                    </tr>


                    <tr>

                        <td>

                            <div class="name">

                                <div class="mini-avatar">
                                    S
                                </div>

                                <div>

                                    <b>
                                        Sinta
                                    </b>

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

                            <span class="status success">
                                Berhasil
                            </span>

                        </td>

                    </tr>


                </tbody>

            </table>

        </div>

    </div>


    <!-- QUICK ACTION -->

    <div class="card">

        <div class="card-head">

            <h3>
                Aksi Cepat
            </h3>

        </div>


        <div class="card-body">


            <div class="quick">


                <a href="kapal.php">

                    <div class="quick-icon">
                        🚢
                    </div>

                    <div>

                        <b>
                            Kelola Kapal
                        </b>

                        <small>
                            Tambah dan edit kapal
                        </small>

                    </div>

                </a>


                <a href="jadwal.php">

                    <div class="quick-icon">
                        🗓
                    </div>

                    <div>

                        <b>
                            Jadwal
                        </b>

                        <small>
                            Atur perjalanan kapal
                        </small>

                    </div>

                </a>


                <a href="booking.php">

                    <div class="quick-icon">
                        🎫
                    </div>

                    <div>

                        <b>
                            Booking
                        </b>

                        <small>
                            Kelola tiket penumpang
                        </small>

                    </div>

                </a>


                <a href="pengguna.php">

                    <div class="quick-icon">
                        👥
                    </div>

                    <div>

                        <b>
                            Pengguna
                        </b>

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

include __DIR__ . '/includes/footer.php';

?>