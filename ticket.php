<?php

require_once "config.php";
require_once "includes/functions.php";

require_login();


/*
|--------------------------------------------------------------------------
| CEK BOOKING
|--------------------------------------------------------------------------
*/

if (
    empty($_SESSION['booking']['code']) &&
    empty($_SESSION['booking']['booking_code']) &&
    empty($_SESSION['booking']['transaction_code'])
) {

    $pageTitle = "Pesanan Saya";

    include "includes/header.php";

    ?>

    <div class="empty-page">

        <div class="empty-icon">
            🎫
        </div>

        <h1>
            Belum ada pesanan
        </h1>

        <p>
            Pesanan tiket kapal kamu akan muncul di sini.
        </p>

        <a
            class="btn btn-primary"
            href="search.php"
        >
            Cari Tiket
        </a>

    </div>

    <?php

    include "includes/footer.php";

    exit;
}


/*
|--------------------------------------------------------------------------
| DATA BOOKING
|--------------------------------------------------------------------------
*/

$booking = $_SESSION['booking'];

$ship = get_ship(
    $booking['ship_id'] ?? null
);

if (!$ship) {

    die("Data kapal tidak ditemukan.");

}


/*
|--------------------------------------------------------------------------
| KODE BOOKING
|--------------------------------------------------------------------------
*/

$bookingCode =
    $booking['code']
    ?? $booking['booking_code']
    ?? $booking['transaction_code']
    ?? '-';


/*
|--------------------------------------------------------------------------
| PRINT MODE
|--------------------------------------------------------------------------
*/

$printMode =
    isset($_GET['print']) &&
    $_GET['print'] == '1';


$pageTitle =
    "E-Ticket " . $bookingCode;


include "includes/header.php";

?>

<div class="page-bg">

    <div class="container ticket-page">


        <!-- HEADER -->

        <div class="ticket-header">

            <div>

                <span class="eyebrow dark">
                    E-TICKET
                </span>

                <h1>
                    <?= e($bookingCode) ?>
                </h1>

                <p>
                    Booking berhasil
                    •
                    <?= e(
                        $booking['paid_at']
                        ?? ''
                    ) ?>
                </p>

            </div>


            <button
                class="btn btn-dark"
                onclick="window.print()"
            >
                🖨 Cetak Tiket
            </button>

        </div>


        <!-- TICKET -->

        <div class="big-ticket">


            <!-- MAIN -->

            <div class="ticket-main">


                <div class="ticket-brand">

                    ⚓ OCEANGO

                    <span>
                        <?= e(
                            $ship['class']
                            ?? '-'
                        ) ?>
                    </span>

                </div>


                <!-- ROUTE -->

                <div class="big-route">


                    <div>

                        <small>
                            <?= e(
                                $ship['from']
                            ) ?>
                        </small>

                        <strong>
                            <?= e(
                                $ship['time']
                                ?? '-'
                            ) ?>
                        </strong>

                        <span>
                            Pelabuhan
                        </span>

                    </div>


                    <div class="route-icon">
                        ⛴
                    </div>


                    <div>

                        <small>
                            <?= e(
                                $ship['to']
                            ) ?>
                        </small>

                        <strong>
                            <?= e(
                                $ship['arrival_time']
                                ?? '-'
                            ) ?>
                        </strong>

                        <span>
                            Pelabuhan
                        </span>

                    </div>

                </div>


                <!-- INFORMATION -->

                <div class="ticket-info-grid">


                    <div>

                        <small>
                            Penumpang
                        </small>

                        <b>
                            <?= e(
                                $booking['passenger']['name']
                                ?? '-'
                            ) ?>
                        </b>

                    </div>


                    <div>

                        <small>
                            KTP
                        </small>

                        <b>
                            <?= e(
                                $booking['passenger']['id']
                                ?? '-'
                            ) ?>
                        </b>

                    </div>


                    <div>

                        <small>
                            Tanggal Lahir
                        </small>

                        <b>
                            <?= e(
                                $booking['passenger']['birth']
                                ?? '-'
                            ) ?>
                        </b>

                    </div>


                    <div>

                        <small>
                            Jenis Kelamin
                        </small>

                        <b>
                            <?= e(
                                $booking['passenger']['gender']
                                ?? '-'
                            ) ?>
                        </b>

                    </div>


                    <div>

                        <small>
                            Nomor Telepon
                        </small>

                        <b>
                            <?= e(
                                $booking['passenger']['phone']
                                ?? '-'
                            ) ?>
                        </b>

                    </div>


                    <div>

                        <small>
                            Email
                        </small>

                        <b>
                            <?= e(
                                $booking['passenger']['email']
                                ?? '-'
                            ) ?>
                        </b>

                    </div>


                    <div>

                        <small>
                            Kursi
                        </small>

                        <b>
                            <?= e(
                                $booking['seat']
                                ?? '-'
                            ) ?>
                        </b>

                    </div>


                    <div>

                        <small>
                            Tanggal Perjalanan
                        </small>

                        <b>
                            <?= e(
                                $ship['date']
                                ?? '-'
                            ) ?>
                        </b>

                    </div>


                    <div>

                        <small>
                            Kapal
                        </small>

                        <b>
                            <?= e(
                                $ship['name']
                                ?? '-'
                            ) ?>
                        </b>

                    </div>


                    <div>

                        <small>
                            Pembayaran
                        </small>

                        <b>
                            <?= e(
                                $booking['payment']
                                ?? $booking['payment_method']
                                ?? 'Lunas'
                            ) ?>
                        </b>

                    </div>


                    <div>

                        <small>
                            Total
                        </small>

                        <b>
                            <?= rupiah(
                                $booking['total']
                                ?? 0
                            ) ?>
                        </b>

                    </div>

                </div>

            </div>


            <!-- QR -->

            <div class="ticket-qr">

                <div class="fake-qr">
                    ▦
                </div>

                <b>
                    <?= e($bookingCode) ?>
                </b>

                <small>
                    Tunjukkan tiket ini saat boarding.
                </small>

            </div>


        </div>


        <!-- BUTTON -->

        <div
            class="ticket-actions no-print"
            style="
                margin-top:25px;
                display:flex;
                gap:12px;
                justify-content:flex-end;
            "
        >

            <button
                class="btn btn-dark"
                onclick="window.print()"
            >
                🖨 Cetak / Simpan PDF
            </button>

        </div>


    </div>

</div>


<style>

/* ================================
   TICKET
================================ */

.ticket-page {
    padding-top: 40px;
    padding-bottom: 60px;
}


.ticket-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    margin-bottom: 25px;
}


.ticket-header h1 {
    margin: 5px 0;
}


.ticket-header p {
    color: #71808a;
}


/* BIG TICKET */

.big-ticket {

    display: grid;

    grid-template-columns: 1fr 220px;

    background: #ffffff;

    border-radius: 20px;

    overflow: hidden;

    box-shadow:
        0 12px 40px rgba(0,0,0,.08);

    border: 1px solid #e3ebef;

}


/* MAIN */

.ticket-main {
    padding: 30px;
}


.ticket-brand {

    display: flex;

    justify-content: space-between;

    align-items: center;

    font-size: 18px;

    font-weight: 800;

    color: #063451;

}


.ticket-brand span {

    font-size: 11px;

    padding: 6px 10px;

    border-radius: 20px;

    background: #eef7fb;

    color: #167ca8;

}


/* ROUTE */

.big-route {

    display: grid;

    grid-template-columns: 1fr 80px 1fr;

    align-items: center;

    text-align: center;

    margin: 35px 0;

}


.big-route small {

    display: block;

    font-size: 11px;

    color: #87959e;

    margin-bottom: 5px;

}


.big-route strong {

    display: block;

    font-size: 28px;

    color: #063451;

}


.big-route span {

    display: block;

    margin-top: 5px;

    font-size: 10px;

    color: #89969e;

}


.route-icon {

    font-size: 32px;
}


/* INFO */

.ticket-info-grid {

    display: grid;

    grid-template-columns:
        repeat(3, 1fr);

    gap: 18px;

    border-top: 1px dashed #dce5e9;

    padding-top: 25px;

}


.ticket-info-grid div {

    min-width: 0;

}


.ticket-info-grid small {

    display: block;

    color: #89969e;

    font-size: 10px;

    margin-bottom: 5px;

}


.ticket-info-grid b {

    display: block;

    color: #263944;

    font-size: 12px;

    word-break: break-word;

}


/* QR */

.ticket-qr {

    border-left: 1px dashed #ccd9df;

    padding: 30px 20px;

    display: flex;

    flex-direction: column;

    align-items: center;

    justify-content: center;

    text-align: center;

    background: #fbfdfe;

}


.fake-qr {

    width: 140px;

    height: 140px;

    border: 8px solid #ffffff;

    box-shadow:
        0 0 0 1px #dce5e9;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 80px;

    margin-bottom: 15px;

}


.ticket-qr b {

    font-size: 11px;

    letter-spacing: .08em;

}


.ticket-qr small {

    margin-top: 8px;

    color: #7d8b93;

    font-size: 9px;

}


/* MOBILE */

@media(max-width: 750px) {

    .ticket-header {

        flex-direction: column;

        align-items: flex-start;

    }


    .big-ticket {

        grid-template-columns: 1fr;

    }


    .ticket-qr {

        border-left: none;

        border-top: 1px dashed #ccd9df;

    }


    .ticket-info-grid {

        grid-template-columns: 1fr 1fr;

    }

}


/* PRINT */

@media print {

    body {
        background: #ffffff !important;
    }


    header,
    footer,
    .no-print,
    .ticket-header button {
        display: none !important;
    }


    .page-bg {
        background: #ffffff !important;
    }


    .ticket-page {
        padding: 0 !important;
        max-width: 100% !important;
    }


    .big-ticket {

        box-shadow: none !important;

        border: 1px solid #222 !important;

        break-inside: avoid;

    }


    .ticket-main {
        padding: 20px;
    }


    .ticket-qr {
        background: #ffffff !important;
    }

}

</style>


<?php

include "includes/footer.php";

?>