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

    header("Location: search.php");
    exit;
}


$booking = $_SESSION['booking'];

$ship = get_ship($booking['ship_id'] ?? null);

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


$pageTitle = "Pembayaran Berhasil";

include "includes/header.php";

?>

<div class="success-page">

    <div class="success-card">

        <div class="success-icon">
            ✓
        </div>

        <span class="eyebrow dark">
            TRANSAKSI BERHASIL
        </span>

        <h1>
            Pembayaran Berhasil!
        </h1>

        <p>
            E-ticket telah dibuat dan tersimpan di pesanan kamu.
        </p>


        <!-- TICKET PREVIEW -->

        <div class="ticket-preview">

            <div class="ticket-top">

                <span>
                    ⚓ OCEANGO
                </span>

                <b>
                    <?= e($bookingCode) ?>
                </b>

            </div>


            <div class="ticket-route">

                <div>

                    <small>
                        ASAL
                    </small>

                    <strong>
                        <?= e($ship['from']) ?>
                    </strong>

                </div>


                <span>
                    ⛴
                </span>


                <div>

                    <small>
                        TUJUAN
                    </small>

                    <strong>
                        <?= e($ship['to']) ?>
                    </strong>

                </div>

            </div>


            <div class="ticket-details">


                <div>

                    <small>
                        Nama Penumpang
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
                        Kelas
                    </small>

                    <b>
                        <?= e(
                            $ship['class']
                            ?? '-'
                        ) ?>
                    </b>

                </div>


                <div>

                    <small>
                        Tanggal
                    </small>

                    <b>
                        <?= e(
                            $ship['date']
                            ?? '-'
                        ) ?>
                    </b>

                </div>


            </div>


            <div class="qr">

                ▦

                <small>
                    SCAN TICKET
                </small>

            </div>

        </div>


        <!-- ACTION -->

        <div class="success-actions">

            <a
                class="btn btn-outline"
                href="ticket.php"
            >
                🎫 Lihat Detail Booking
            </a>


            <a
                class="btn btn-primary"
                href="ticket.php?print=1"
            >
                🖨 Unduh / Cetak E-Ticket
            </a>

        </div>

    </div>

</div>


<?php

include "includes/footer.php";

?>