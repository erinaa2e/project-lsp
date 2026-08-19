<?php

require_once __DIR__ . '/includes/functions.php';

require_admin();

require_once __DIR__ . '/../config.php';

if (!$pdo) {
    die("Database tidak terhubung.");
}

try {

    /*
    |--------------------------------------------------------------------------
    | AMBIL DATA SESUAI KOLOM DATABASE KAMU
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->query("
        SELECT
            id,
            booking_code,
            passenger_name,
            nik,
            phone,
            email,
            ship_id,
            travel_date,
            seat,
            total,
            payment_method,
            status,
            created_at
        FROM bookings
        ORDER BY created_at DESC, id DESC
    ");

    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {

    die(
        "Gagal mengambil data booking: "
        . htmlspecialchars($e->getMessage())
    );

}


/*
|--------------------------------------------------------------------------
| NAMA FILE
|--------------------------------------------------------------------------
*/

$filename =
    "data_booking_oceango_"
    . date("Y-m-d_H-i-s")
    . ".csv";


/*
|--------------------------------------------------------------------------
| HEADER DOWNLOAD
|--------------------------------------------------------------------------
*/

header("Content-Type: text/csv; charset=UTF-8");

header(
    "Content-Disposition: attachment; filename=\"$filename\""
);

header("Pragma: no-cache");

header("Expires: 0");


/*
|--------------------------------------------------------------------------
| BUKA OUTPUT
|--------------------------------------------------------------------------
*/

$output = fopen("php://output", "w");


/*
|--------------------------------------------------------------------------
| UTF-8 BOM
|--------------------------------------------------------------------------
*/

fprintf(
    $output,
    chr(0xEF) . chr(0xBB) . chr(0xBF)
);


/*
|--------------------------------------------------------------------------
| HEADER EXCEL
|--------------------------------------------------------------------------
*/

fputcsv(
    $output,
    [
        "No",
        "ID Booking",
        "Nama Penumpang",
        "NIK / KTP",
        "No. Telepon",
        "Email",
        "ID Kapal",
        "Tanggal Booking",
        "Tanggal Perjalanan",
        "Kursi",
        "Total",
        "Metode Pembayaran",
        "Status"
    ],
    ";"
);


/*
|--------------------------------------------------------------------------
| DATA
|--------------------------------------------------------------------------
*/

$no = 1;

foreach ($bookings as $booking) {

    $createdAt =
        $booking["created_at"]
        ?? null;

    $tanggalBooking = "";

    if ($createdAt) {

        $tanggalBooking =
            date(
                "Y-m-d H:i:s",
                strtotime($createdAt)
            );

    }


    fputcsv(
        $output,
        [
            $no,

            $booking["booking_code"]
                ?? $booking["id"]
                ?? "",

            $booking["passenger_name"]
                ?? "",

            $booking["nik"]
                ?? "",

            $booking["phone"]
                ?? "",

            $booking["email"]
                ?? "",

            $booking["ship_id"]
                ?? "",

            $tanggalBooking,

            $booking["travel_date"]
                ?? "",

            $booking["seat"]
                ?? "",

            $booking["total"]
                ?? 0,

            $booking["payment_method"]
                ?? "",

            $booking["status"]
                ?? "Menunggu"
        ],
        ";"
    );


    $no++;

}


fclose($output);

exit;