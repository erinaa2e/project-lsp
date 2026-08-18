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
| DATA TRANSAKSI
|--------------------------------------------------------------------------
*/

$bookingCode = $_SESSION['booking']['booking_code']
    ?? "OCG-" . date("Ymd") . "-" . strtoupper(substr(md5(uniqid()), 0, 6));

$total = $booking['total'] ?? 0;


/*
|--------------------------------------------------------------------------
| BUAT TABEL BOOKINGS OTOMATIS
|--------------------------------------------------------------------------
|
| Kalau tabel bookings belum ada, sistem akan membuatnya otomatis.
|
*/

if ($pdo) {

    try {

        $pdo->exec("
            CREATE TABLE IF NOT EXISTS bookings (

                id INT AUTO_INCREMENT PRIMARY KEY,

                transaction_code VARCHAR(50) NOT NULL UNIQUE,

                user_id INT NULL,

                passenger_name VARCHAR(150) NOT NULL,
                passenger_phone VARCHAR(50) NULL,
                passenger_email VARCHAR(150) NULL,

                ship_id INT NULL,
                ship_name VARCHAR(150) NULL,

                from_city VARCHAR(100) NULL,
                to_city VARCHAR(100) NULL,

                travel_date DATE NULL,

                seat VARCHAR(50) NULL,

                total DECIMAL(15,2) NOT NULL DEFAULT 0,

                payment_method VARCHAR(50) NULL,

                payment_status VARCHAR(30) NOT NULL DEFAULT 'Menunggu',

                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

            ) ENGINE=InnoDB
            DEFAULT CHARSET=utf8mb4
            COLLATE=utf8mb4_unicode_ci
        ");

    } catch (PDOException $e) {

        $error = "Database tidak dapat dipersiapkan: " . $e->getMessage();

    }

}


/*
|--------------------------------------------------------------------------
| PROSES PEMBAYARAN
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $method = $_POST['payment_method'] ?? '';

    if ($method === '') {

        $error = "Silakan pilih metode pembayaran.";

    } else {

        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA PENUMPANG
        |--------------------------------------------------------------------------
        */

        $passenger = $_SESSION['booking']['passenger'] ?? [];

        $passengerName =
            $passenger['name']
            ?? $_SESSION['user']['name']
            ?? '-';

        $passengerPhone =
            $passenger['phone']
            ?? $passenger['no_hp']
            ?? $passenger['phone_number']
            ?? null;

        $passengerEmail =
            $passenger['email']
            ?? $_SESSION['user']['email']
            ?? null;


        /*
        |--------------------------------------------------------------------------
        | USER ID
        |--------------------------------------------------------------------------
        */

        $userId = $_SESSION['user']['id'] ?? null;


        /*
        |--------------------------------------------------------------------------
        | DATA KAPAL
        |--------------------------------------------------------------------------
        */

        $shipId = $booking['ship_id'] ?? null;

        $shipName = $ship['name'] ?? null;

        $fromCity = $ship['from'] ?? null;

        $toCity = $ship['to'] ?? null;

        $travelDate =
            $ship['date']
            ?? $booking['date']
            ?? null;

        $seat =
            $booking['seat']
            ?? '-';


        /*
        |--------------------------------------------------------------------------
        | SIMPAN KE DATABASE
        |--------------------------------------------------------------------------
        */

        if (!$pdo) {

            $error = "Database tidak terhubung.";

        } else {

            try {

                /*
                |--------------------------------------------------------------------------
                | CEK APAKAH TRANSAKSI SUDAH PERNAH DISIMPAN
                |--------------------------------------------------------------------------
                */

                $check = $pdo->prepare("
                    SELECT id
                    FROM bookings
                    WHERE transaction_code = ?
                    LIMIT 1
                ");

                $check->execute([
                    $transactionCode
                ]);

                $existingBooking = $check->fetch();


                /*
                |--------------------------------------------------------------------------
                | INSERT BOOKING
                |--------------------------------------------------------------------------
                */

                if (!$existingBooking) {

                    $insert = $pdo->prepare("
                        INSERT INTO bookings (

                            transaction_code,

                            user_id,

                            passenger_name,
                            passenger_phone,
                            passenger_email,

                            ship_id,
                            ship_name,

                            from_city,
                            to_city,

                            travel_date,

                            seat,

                            total,

                            payment_method,
                            payment_status

                        ) VALUES (

                            ?,
                            ?,

                            ?,
                            ?,
                            ?,

                            ?,
                            ?,

                            ?,
                            ?,

                            ?,

                            ?,

                            ?,

                            ?,
                            ?

                        )
                    ");

                    $insert->execute([

                        $transactionCode,

                        $userId,

                        $passengerName,
                        $passengerPhone,
                        $passengerEmail,

                        $shipId,
                        $shipName,

                        $fromCity,
                        $toCity,

                        $travelDate,

                        $seat,

                        $total,

                        $method,
                        'Berhasil'

                    ]);

                }


                /*
                |--------------------------------------------------------------------------
                | SIMPAN DATA KE SESSION
                |--------------------------------------------------------------------------
                */

                $_SESSION['booking']['payment_method'] =
                    $method;

                $_SESSION['booking']['transaction_code'] =
                    $transactionCode;

                $_SESSION['booking']['payment_status'] =
                    'Berhasil';


                /*
                |--------------------------------------------------------------------------
                | SIMPAN ID BOOKING
                |--------------------------------------------------------------------------
                */

                if ($existingBooking) {

                    $_SESSION['booking']['database_id'] =
                        $existingBooking['id'];

                } else {

                    $_SESSION['booking']['database_id'] =
                        $pdo->lastInsertId();

                }


                /*
                |--------------------------------------------------------------------------
                | SELESAI
                |--------------------------------------------------------------------------
                */

                header("Location: success.php");
                exit;


            } catch (PDOException $e) {

                $error =
                    "Data booking gagal disimpan ke database. "
                    . $e->getMessage();

            }

        }

    }

}


/*
|--------------------------------------------------------------------------
| PAGE
|--------------------------------------------------------------------------
*/

$pageTitle = "Pembayaran";

include "includes/header.php";

?>

<div class="page-bg">

    <div class="container booking-page">


        <!-- STEPS -->

        <div class="steps">

            <span class="done">
                ✓ <b>Pilih Kursi</b>
            </span>

            <i></i>

            <span class="done">
                ✓ <b>Data Penumpang</b>
            </span>

            <i></i>

            <span class="active">
                3 <b>Pembayaran</b>
            </span>

        </div>


        <!-- CONTENT -->

        <div class="booking-grid">


            <!-- PAYMENT FORM -->

            <section class="form-card">

                <span class="eyebrow dark">
                    PEMBAYARAN
                </span>

                <h2>
                    Pilih metode pembayaran
                </h2>

                <p class="muted">
                    Pilih salah satu metode pembayaran yang tersedia
                    untuk menyelesaikan pemesanan tiket kamu.
                </p>


                <?php if (!empty($error)): ?>

                    <div class="alert error">
                        <?= e($error) ?>
                    </div>

                <?php endif; ?>


                <form
    method="post"
    action="process_payment.php"
    id="paymentForm"
>


                    <!-- PAYMENT OPTIONS -->

                    <div class="payment-options">


                        <!-- QRIS -->

                        <label
                            class="payment-option active"
                            data-payment="QRIS"
                        >

                            <input
                                type="radio"
                                name="payment_method"
                                value="QRIS"
                                checked
                                hidden
                            >

                            <span>
                                📱
                            </span>

                            <div>

                                <b>
                                    QRIS
                                </b>

                                <small>
                                    Bayar menggunakan QRIS
                                </small>

                            </div>

                        </label>


                        <!-- BANK -->

                        <label
                            class="payment-option"
                            data-payment="Transfer Bank"
                        >

                            <input
                                type="radio"
                                name="payment_method"
                                value="Transfer Bank"
                                hidden
                            >

                            <span>
                                🏦
                            </span>

                            <div>

                                <b>
                                    Transfer Bank
                                </b>

                                <small>
                                    Transfer melalui rekening bank
                                </small>

                            </div>

                        </label>


                        <!-- EWALLET -->

                        <label
                            class="payment-option"
                            data-payment="E-Wallet"
                        >

                            <input
                                type="radio"
                                name="payment_method"
                                value="E-Wallet"
                                hidden
                            >

                            <span>
                                💳
                            </span>

                            <div>

                                <b>
                                    E-Wallet
                                </b>

                                <small>
                                    DANA, OVO, GoPay dan lainnya
                                </small>

                            </div>

                        </label>


                    </div>


                    <!-- QRIS -->

                    <div
                        class="transaction-card"
                        id="qrisPaymentBox"
                    >

                        <div class="transaction-header">

                            <div>

                                <small>
                                    KODE TRANSAKSI
                                </small>

                                <strong>
                                    <?= e($bookingCode) ?>
                                </strong>

                            </div>

                            <span class="transaction-status">
                                Menunggu Pembayaran
                            </span>

                        </div>


                        <div class="qr-payment">

                            <div class="qr-wrapper">

                                <div class="qr-code">

                                    <img
                                        src="assets/img/barcode.jpeg"
                                        alt="QR Pembayaran Oceango"
                                        class="payment-qr-image"
                                    >

                                </div>

                                <small>
                                    Scan QR untuk melakukan pembayaran
                                </small>

                            </div>


                            <div class="transaction-info">

                                <div>

                                    <small>
                                        TOTAL PEMBAYARAN
                                    </small>

                                    <strong>
                                        <?= rupiah($total) ?>
                                    </strong>

                                </div>


                                <div>

                                    <small>
                                        NAMA PENUMPANG
                                    </small>

                                    <b>
                                        <?= e(
                                            $_SESSION['booking']['passenger']['name']
                                            ?? $_SESSION['user']['name']
                                            ?? '-'
                                        ) ?>
                                    </b>

                                </div>


                                <div>

                                    <small>
                                        RUTE
                                    </small>

                                    <b>
                                        <?= e($ship['from']) ?>
                                        →
                                        <?= e($ship['to']) ?>
                                    </b>

                                </div>


                                <div>

                                    <small>
                                        KAPAL
                                    </small>

                                    <b>
                                        <?= e($ship['name']) ?>
                                    </b>

                                </div>

                            </div>

                        </div>


                        <div class="barcode-section">

                            <small>
                                BARCODE PEMBAYARAN
                            </small>

                            <img
                                src="assets/img/barcode2.jpeg"
                                alt="Barcode Pembayaran"
                                class="payment-barcode-image"
                            >

                            <strong>
                                <?= e($transactionCode) ?>
                            </strong>

                        </div>

                    </div>


                    <!-- BANK -->

                    <div
                        class="transaction-card payment-info-box"
                        id="bankPaymentBox"
                        style="display:none;"
                    >

                        <div class="transaction-header">

                            <div>

                                <small>
                                    TRANSFER BANK
                                </small>

                                <strong>
                                    Rekening Pembayaran
                                </strong>

                            </div>

                        </div>


                        <div class="payment-info-content">

                            <span>
                                Bank Oceango
                            </span>

                            <strong>
                                1234567890
                            </strong>

                            <small>
                                a.n. PT Oceango Indonesia
                            </small>

                        </div>

                    </div>


                    <!-- EWALLET -->

                    <div
                        class="transaction-card payment-info-box"
                        id="walletPaymentBox"
                        style="display:none;"
                    >

                        <div class="transaction-header">

                            <div>

                                <small>
                                    E-WALLET
                                </small>

                                <strong>
                                    Pembayaran E-Wallet
                                </strong>

                            </div>

                        </div>


                        <div class="payment-info-content">

                            <span>
                                Nomor E-Wallet
                            </span>

                            <strong>
                                0812 3456 7890
                            </strong>

                            <small>
                                Oceango Payment
                            </small>

                        </div>

                    </div>


                    <!-- ACTION -->

                    <div class="form-actions">

                        <a
                            href="passenger.php"
                            class="btn btn-outline"
                        >
                            ← Kembali
                        </a>


                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            Saya Sudah Membayar →
                        </button>

                    </div>


                </form>

            </section>


            <!-- SUMMARY -->

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


                <div>

                    <span>
                        Penumpang
                    </span>

                    <b>
                        <?= e(
                            $_SESSION['booking']['passenger']['name']
                            ?? $_SESSION['user']['name']
                            ?? '-'
                        ) ?>
                    </b>

                </div>


                <hr>


                <div class="total">

                    <span>
                        Total
                    </span>

                    <strong>
                        <?= rupiah($total) ?>
                    </strong>

                </div>

            </aside>


        </div>

    </div>

</div>


<style>

/* TRANSACTION */

.transaction-card {

    margin: 25px 0;

    border: 1px solid #dfe8ee;

    border-radius: 15px;

    overflow: hidden;

    background: #ffffff;

}


.transaction-header {

    padding: 18px 20px;

    background: #f7fafc;

    display: flex;

    align-items: center;

    justify-content: space-between;

    border-bottom: 1px solid #e3ebf0;

}


.transaction-header small {

    display: block;

    font-size: 8px;

    font-weight: 800;

    color: #8997a0;

    letter-spacing: .1em;

    margin-bottom: 5px;

}


.transaction-header strong {

    font-size: 15px;

    color: #082c49;

}


.transaction-status {

    background: #fff3d9;

    color: #a56a00;

    font-size: 8px;

    font-weight: 800;

    padding: 7px 10px;

    border-radius: 20px;

}


/* QR */

.qr-payment {

    padding: 25px;

    display: grid;

    grid-template-columns: 220px 1fr;

    gap: 30px;

    align-items: center;

}


.qr-wrapper {

    text-align: center;

}


.qr-code {

    width: 200px;

    height: 200px;

    padding: 8px;

    margin: auto;

    display: flex;

    align-items: center;

    justify-content: center;

    border: 1px solid #e2eaf0;

    border-radius: 10px;

    background: #ffffff;

}


.payment-qr-image {

    width: 100%;

    height: 100%;

    object-fit: contain;

    display: block;

}


.qr-wrapper small {

    display: block;

    margin-top: 10px;

    color: #7e8c96;

    font-size: 9px;

}


/* INFO */

.transaction-info {

    display: grid;

    gap: 15px;

}


.transaction-info > div {

    padding-bottom: 13px;

    border-bottom: 1px solid #edf1f4;

}


.transaction-info small {

    display: block;

    font-size: 9px;

    color: #8997a0;

    margin-bottom: 5px;

}


.transaction-info strong {

    font-size: 20px;

    color: #082c49;

}


.transaction-info b {

    font-size: 11px;

    color: #263944;

}


/* BARCODE */

.barcode-section {

    padding: 20px;

    border-top: 1px dashed #d5e0e6;

    text-align: center;

    background: #fcfdfe;

}


.barcode-section > small {

    display: block;

    font-size: 8px;

    font-weight: 800;

    letter-spacing: .15em;

    color: #8a969e;

    margin-bottom: 10px;

}


.payment-barcode-image {

    display: block;

    width: 260px;

    max-width: 100%;

    height: auto;

    max-height: 100px;

    object-fit: contain;

    margin: 10px auto;

}


.barcode-section > strong {

    display: block;

    font-size: 10px;

    letter-spacing: .12em;

    color: #082c49;

    margin-top: 4px;

}


/* PAYMENT INFO */

.payment-info-content {

    padding: 25px;

    display: flex;

    flex-direction: column;

    gap: 8px;

    text-align: center;

}


.payment-info-content span {

    font-size: 10px;

    color: #8997a0;

}


.payment-info-content strong {

    font-size: 25px;

    color: #082c49;

}


.payment-info-content small {

    font-size: 10px;

    color: #7e8c96;

}


/* PAYMENT OPTION */

.payment-option {

    transition: .2s ease;

}


.payment-option:hover {

    border-color: #6cb6d9;

    background: #f7fcff;

}


.payment-option.active {

    border-color: #1680b6;

    background: #f0f9fd;

    box-shadow:
        0 0 0 2px rgba(22,128,182,.06);

}


/* MOBILE */

@media(max-width:720px) {

    .qr-payment {

        grid-template-columns: 1fr;

        text-align: center;

    }

    .qr-wrapper {

        margin: auto;

    }

    .transaction-header {

        align-items: flex-start;

        gap: 10px;

        flex-direction: column;

    }

    .payment-qr-image {

        width: 180px;

        height: 180px;

    }

    .payment-barcode-image {

        width: 220px;

    }

}

</style>


<script>

/*
|--------------------------------------------------------------------------
| PAYMENT OPTION
|--------------------------------------------------------------------------
*/

const paymentOptions =
    document.querySelectorAll(".payment-option");

const qrisBox =
    document.getElementById("qrisPaymentBox");

const bankBox =
    document.getElementById("bankPaymentBox");

const walletBox =
    document.getElementById("walletPaymentBox");


paymentOptions.forEach(function(option) {

    option.addEventListener("click", function() {

        paymentOptions.forEach(function(item) {

            item.classList.remove("active");

        });


        option.classList.add("active");


        const radio =
            option.querySelector(
                "input[type='radio']"
            );

        radio.checked = true;


        const payment =
            option.dataset.payment;


        qrisBox.style.display = "none";

        bankBox.style.display = "none";

        walletBox.style.display = "none";


        if (payment === "QRIS") {

            qrisBox.style.display = "block";

        }

        else if (payment === "Transfer Bank") {

            bankBox.style.display = "block";

        }

        else if (payment === "E-Wallet") {

            walletBox.style.display = "block";

        }

    });

});

</script>


<?php

include "includes/footer.php";

?>