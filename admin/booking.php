<?php

require_once __DIR__ . '/includes/functions.php';
require_admin();

require_once __DIR__ . '/../config.php';


/*
|--------------------------------------------------------------------------
| AMBIL DATA BOOKING
|--------------------------------------------------------------------------
*/

$bookings = [];
$dbError = null;

try {

    if (!$pdo) {
        throw new Exception("Database tidak terhubung.");
    }

    $stmt = $pdo->query("
        SELECT *
        FROM bookings
        ORDER BY id DESC
    ");

    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (Throwable $e) {

    $dbError = $e->getMessage();

}


$pageTitle = "Booking";

include __DIR__ . '/includes/header.php';

?>


<div class="page-head">

    <div>

        <h2>
            Booking
        </h2>

        <p>
            Kelola transaksi dan tiket penumpang.
        </p>

    </div>


    <div>

        <a
            href="export_booking.php"
            class="export-btn"
        >
            📊 Export Data ke Excel
        </a>

    </div>

</div>


<?php if ($dbError): ?>

    <div
        class="alert error"
        style="
            margin-bottom:20px;
            padding:15px;
            border-radius:10px;
        "
    >

        <strong>
            Database Error:
        </strong>

        <?= e($dbError) ?>

    </div>

<?php endif; ?>


<div class="card">

    <div class="table-wrap">

        <table class="table">

            <thead>

                <tr>

                    <th>ID</th>

                    <th>PENUMPANG</th>

                    <th>EMAIL</th>

                    <th>NO. TELEPON</th>

                    <th>RUTE</th>

                    <th>TANGGAL BOOKING</th>

                    <th>TANGGAL PERJALANAN</th>

                    <th>KURSI</th>

                    <th>TOTAL</th>

                    <th>METODE</th>

                    <th>STATUS</th>

                </tr>

            </thead>


            <tbody>


            <?php if (empty($bookings)): ?>

                <tr>

                    <td
                        colspan="11"
                        style="
                            text-align:center;
                            padding:50px;
                        "
                    >

                        <strong>
                            Belum ada data booking.
                        </strong>

                        <br>

                        <small>
                            Booking dari website akan muncul di sini
                            setelah tersimpan ke database.
                        </small>

                    </td>

                </tr>

            <?php else: ?>


                <?php foreach ($bookings as $booking): ?>


                    <?php

                    /*
                    |--------------------------------------------------------------------------
                    | ID / KODE TRANSAKSI
                    |--------------------------------------------------------------------------
                    */

                    $bookingId =
                        $booking['transaction_code']
                        ?? $booking['booking_code']
                        ?? $booking['id']
                        ?? '-';


                    /*
                    |--------------------------------------------------------------------------
                    | NAMA
                    |--------------------------------------------------------------------------
                    */

                    $name =
                        $booking['passenger_name']
                        ?? $booking['name']
                        ?? '-';


                    /*
                    |--------------------------------------------------------------------------
                    | EMAIL
                    |--------------------------------------------------------------------------
                    */

                    $email =
                        $booking['passenger_email']
                        ?? $booking['email']
                        ?? '-';


                    /*
                    |--------------------------------------------------------------------------
                    | TELEPON
                    |--------------------------------------------------------------------------
                    */

                    $phone =
                        $booking['passenger_phone']
                        ?? $booking['phone']
                        ?? '-';


                    /*
                    |--------------------------------------------------------------------------
                    | RUTE
                    |--------------------------------------------------------------------------
                    */

                    $from =
                        $booking['from_city']
                        ?? $booking['from']
                        ?? '';

                    $to =
                        $booking['to_city']
                        ?? $booking['to']
                        ?? '';


                    /*
                    |--------------------------------------------------------------------------
                    | TANGGAL PERJALANAN
                    |--------------------------------------------------------------------------
                    */

                    $travelDate =
                        $booking['travel_date']
                        ?? $booking['date']
                        ?? null;


                    /*
                    |--------------------------------------------------------------------------
                    | KURSI
                    |--------------------------------------------------------------------------
                    */

                    $seat =
                        $booking['seat']
                        ?? '-';


                    /*
                    |--------------------------------------------------------------------------
                    | TOTAL
                    |--------------------------------------------------------------------------
                    */

                    $total =
                        $booking['total']
                        ?? 0;


                    /*
                    |--------------------------------------------------------------------------
                    | METODE PEMBAYARAN
                    |--------------------------------------------------------------------------
                    */

                    $paymentMethod =
                        $booking['payment_method']
                        ?? '-';


                    /*
                    |--------------------------------------------------------------------------
                    | STATUS
                    |--------------------------------------------------------------------------
                    */

                    $status =
                        $booking['payment_status']
                        ?? $booking['status']
                        ?? 'Menunggu';


                    /*
                    |--------------------------------------------------------------------------
                    | TANGGAL BOOKING
                    |--------------------------------------------------------------------------
                    */

                    $createdAt =
                        $booking['created_at']
                        ?? null;


                    /*
                    |--------------------------------------------------------------------------
                    | STATUS CLASS
                    |--------------------------------------------------------------------------
                    */

                    $statusLower =
                        strtolower(trim($status));

                    if ($statusLower === 'berhasil') {

                        $statusClass = 'success';

                    } elseif (
                        $statusLower === 'dibatalkan'
                        || $statusLower === 'gagal'
                    ) {

                        $statusClass = 'danger';

                    } else {

                        $statusClass = 'warning';

                    }

                    ?>


                    <tr>


                        <!-- ID -->

                        <td>

                            <strong>
                                #<?= e($bookingId) ?>
                            </strong>

                        </td>


                        <!-- PENUMPANG -->

                        <td>

                            <strong>
                                <?= e($name) ?>
                            </strong>


                            <?php

                            $nik =
                                $booking['nik']
                                ?? $booking['id_number']
                                ?? null;

                            ?>


                            <?php if ($nik): ?>

                                <small
                                    style="
                                        display:block;
                                        color:#888;
                                        margin-top:4px;
                                    "
                                >

                                    KTP:
                                    <?= e($nik) ?>

                                </small>

                            <?php endif; ?>

                        </td>


                        <!-- EMAIL -->

                        <td>

                            <?= e($email) ?>

                        </td>


                        <!-- TELEPON -->

                        <td>

                            <?= e($phone) ?>

                        </td>


                        <!-- RUTE -->

                        <td>

                            <?php if ($from || $to): ?>

                                <?= e($from) ?>

                                →

                                <?= e($to) ?>

                            <?php else: ?>

                                -

                            <?php endif; ?>

                        </td>


                        <!-- TANGGAL BOOKING -->

                        <td>

                            <?php if ($createdAt): ?>

                                <?= tanggal(
                                    date(
                                        'Y-m-d',
                                        strtotime($createdAt)
                                    )
                                ) ?>

                                <small
                                    style="
                                        display:block;
                                        color:#888;
                                        margin-top:3px;
                                    "
                                >

                                    <?= e(
                                        date(
                                            'H:i',
                                            strtotime($createdAt)
                                        )
                                    ) ?>

                                </small>

                            <?php else: ?>

                                -

                            <?php endif; ?>

                        </td>


                        <!-- TANGGAL PERJALANAN -->

                        <td>

                            <?php if ($travelDate): ?>

                                <?= tanggal($travelDate) ?>

                            <?php else: ?>

                                -

                            <?php endif; ?>

                        </td>


                        <!-- KURSI -->

                        <td>

                            <?= e($seat) ?>

                        </td>


                        <!-- TOTAL -->

                        <td>

                            <strong>
                                <?= rupiah($total) ?>
                            </strong>

                        </td>


                        <!-- METODE -->

                        <td>

                            <?= e($paymentMethod) ?>

                        </td>


                        <!-- STATUS -->

                        <td>

                            <span
                                class="status <?= $statusClass ?>"
                            >

                                <?= e($status) ?>

                            </span>

                        </td>


                    </tr>


                <?php endforeach; ?>


            <?php endif; ?>


            </tbody>

        </table>

    </div>

</div>

<style>

.export-btn {

    display: inline-flex;

    align-items: center;

    gap: 8px;

    padding: 11px 18px;

    border-radius: 10px;

    background: #198754;

    color: #ffffff;

    text-decoration: none;

    font-size: 13px;

    font-weight: 700;

    border: none;

    cursor: pointer;

    transition: all .2s ease;

    box-shadow: 0 4px 12px rgba(25,135,84,.18);

}

.export-btn:hover {

    background: #157347;

    color: #ffffff;

    transform: translateY(-1px);

    box-shadow: 0 6px 16px rgba(25,135,84,.25);

}


@media (max-width: 700px) {

    .page-head {

        flex-direction: column;

        align-items: flex-start;

        gap: 15px;

    }

    .export-btn {

        width: 100%;

        justify-content: center;

    }

}

</style>

<?php

include __DIR__ . '/includes/footer.php';

?>