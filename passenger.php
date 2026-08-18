<?php

require_once "config.php";
require_once "includes/functions.php";

require_login();


/*
|--------------------------------------------------------------------------
| CEK BOOKING
|--------------------------------------------------------------------------
*/

if (empty($_SESSION['booking'])) {
    header("Location: search.php");
    exit;
}


$booking = $_SESSION['booking'];

$ship = get_ship($booking['ship_id']);


if (!$ship) {
    header("Location: search.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| DATA USER
|--------------------------------------------------------------------------
*/

$userName  = $_SESSION['user']['name'] ?? '';
$userEmail = $_SESSION['user']['email'] ?? '';
$userPhone = $_SESSION['user']['phone'] ?? '';


/*
|--------------------------------------------------------------------------
| DATA PENUMPANG SEBELUMNYA
|--------------------------------------------------------------------------
|
| Kalau user kembali ke halaman ini, data sebelumnya
| akan tetap muncul.
|
*/

$passenger = $_SESSION['booking']['passenger'] ?? [];


$name = $passenger['name'] ?? $userName;

$nik = $passenger['nik']
    ?? $passenger['id']
    ?? '';

$birthDate = $passenger['birth_date']
    ?? $passenger['birth']
    ?? '';

$gender = $passenger['gender']
    ?? 'Pria';

$phone = $passenger['phone']
    ?? $userPhone;

$email = $passenger['email']
    ?? $userEmail;


/*
|--------------------------------------------------------------------------
| PROSES FORM
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    /*
    |--------------------------------------------------------------------------
    | AMBIL DATA
    |--------------------------------------------------------------------------
    */

    $name = trim($_POST['name'] ?? '');

    $nik = trim($_POST['nik'] ?? '');

    $birthDate = trim($_POST['birth_date'] ?? '');

    $gender = trim($_POST['gender'] ?? '');

    $phone = trim($_POST['phone'] ?? '');

    $email = trim($_POST['email'] ?? '');


    /*
    |--------------------------------------------------------------------------
    | VALIDASI
    |--------------------------------------------------------------------------
    */

    if (
        $name === '' ||
        $nik === '' ||
        $birthDate === '' ||
        $gender === '' ||
        $phone === '' ||
        $email === ''
    ) {

        $error = "Semua data penumpang wajib diisi.";

    } else {


        /*
        |--------------------------------------------------------------------------
        | SIMPAN DATA PENUMPANG KE SESSION
        |--------------------------------------------------------------------------
        |
        | INI YANG NANTI AKAN DIBACA OLEH process_payment.php
        |
        */

        $_SESSION['booking']['passenger'] = [

            'name' => $name,

            'nik' => $nik,

            'birth_date' => $birthDate,

            'gender' => $gender,

            'phone' => $phone,

            'email' => $email

        ];


        /*
        |--------------------------------------------------------------------------
        | LANJUT KE PAYMENT
        |--------------------------------------------------------------------------
        */

        header("Location: payment.php");

        exit;
    }
}


/*
|--------------------------------------------------------------------------
| PAGE
|--------------------------------------------------------------------------
*/

$pageTitle = "Data Penumpang";

include "includes/header.php";

?>


<div class="page-bg">

    <div class="container booking-page">


        <!-- =====================================================
             STEPS
        ====================================================== -->

        <div class="steps">

            <span class="done">
                ✓ <b>Pilih Kursi</b>
            </span>

            <i></i>

            <span class="active">
                2 <b>Data Penumpang</b>
            </span>

            <i></i>

            <span>
                3 <b>Pembayaran</b>
            </span>

        </div>


        <div class="booking-grid">


            <!-- =================================================
                 FORM DATA PENUMPANG
            ================================================== -->

            <section class="form-card">

                <span class="eyebrow dark">
                    DATA PENUMPANG
                </span>

                <h2>
                    Lengkapi data penumpang
                </h2>

                <p class="muted">
                    Pastikan data sesuai dengan identitas yang akan
                    digunakan saat perjalanan.
                </p>


                <?php if (!empty($error)): ?>

                    <div
                        class="alert error"
                        style="
                            margin:20px 0;
                            padding:14px 16px;
                            border-radius:10px;
                            background:#fff0f0;
                            color:#c62828;
                        "
                    >

                        <?= e($error) ?>

                    </div>

                <?php endif; ?>


                <form
                    method="post"
                    class="form-grid"
                >


                    <!-- NAMA -->

                    <label class="full-col">

                        Nama Lengkap

                        <input
                            type="text"
                            name="name"
                            required
                            value="<?= e($name) ?>"
                            placeholder="Masukkan nama lengkap"
                        >

                    </label>


                    <!-- KTP -->

                    <label>

                        Nomor Identitas (KTP)

                        <input
                            type="text"
                            name="nik"
                            required
                            maxlength="30"
                            value="<?= e($nik) ?>"
                            placeholder="Masukkan nomor KTP"
                        >

                    </label>


                    <!-- TANGGAL LAHIR -->

                    <label>

                        Tanggal Lahir

                        <input
                            type="date"
                            name="birth_date"
                            required
                            value="<?= e($birthDate) ?>"
                            max="<?= date('Y-m-d') ?>"
                        >

                    </label>


                    <!-- JENIS KELAMIN -->

                    <label>

                        Jenis Kelamin

                        <select
                            name="gender"
                            required
                        >

                            <option
                                value="Pria"
                                <?= $gender === 'Pria' ? 'selected' : '' ?>
                            >
                                Pria
                            </option>

                            <option
                                value="Wanita"
                                <?= $gender === 'Wanita' ? 'selected' : '' ?>
                            >
                                Wanita
                            </option>

                        </select>

                    </label>


                    <!-- TELEPON -->

                    <label>

                        Nomor Telepon

                        <input
                            type="text"
                            name="phone"
                            required
                            value="<?= e($phone) ?>"
                            placeholder="Contoh: 08123456789"
                        >

                    </label>


                    <!-- EMAIL -->

                    <label class="full-col">

                        Email

                        <input
                            type="email"
                            name="email"
                            required
                            value="<?= e($email) ?>"
                            placeholder="Masukkan email"
                        >

                    </label>


                    <!-- SIMPAN DATA -->

                    <label class="check full-col">

                        <input
                            type="checkbox"
                            name="save_passenger"
                            value="1"
                        >

                        Simpan data penumpang untuk pemesanan berikutnya.

                    </label>


                    <!-- BUTTON -->

                    <div class="form-actions full-col">

                        <a
                            class="btn btn-outline"
                            href="booking.php?id=<?= e($ship['id']) ?>"
                        >
                            Kembali
                        </a>


                        <button
                            class="btn btn-primary"
                            type="submit"
                        >
                            Lanjut ke Pembayaran →
                        </button>

                    </div>

                </form>

            </section>


            <!-- =================================================
                 RINGKASAN PESANAN
            ================================================== -->

            <aside class="booking-summary sticky">

                <span>
                    Ringkasan Pesanan
                </span>

                <h3>
                    <?= e($ship['name']) ?>
                </h3>


                <div class="summary-route">

                    📍

                    <?= e($ship['from']) ?>

                    →

                    <?= e($ship['to']) ?>

                </div>


                <hr>


                <div>

                    <span>
                        Tanggal
                    </span>

                    <b>
                        <?= e($ship['date']) ?>
                    </b>

                </div>


                <div>

                    <span>
                        Kursi
                    </span>

                    <b>
                        <?= e($booking['seat']) ?>
                    </b>

                </div>


                <div class="total">

                    <span>
                        Total
                    </span>

                    <strong>
                        <?= rupiah($booking['total']) ?>
                    </strong>

                </div>

            </aside>


        </div>

    </div>

</div>


<?php

include "includes/footer.php";

?>