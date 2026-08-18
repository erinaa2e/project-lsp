<?php

session_start();

require_once __DIR__ . "/config.php";

if (!$pdo) {
    die("Database tidak terhubung.");
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: payment.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| USER
|--------------------------------------------------------------------------
*/

$user_id =
    $_SESSION["user_id"]
    ?? $_SESSION["user"]["id"]
    ?? null;


/*
|--------------------------------------------------------------------------
| BOOKING SESSION
|--------------------------------------------------------------------------
*/

$booking   = $_SESSION["booking"] ?? [];
$ship_id   = $booking["ship_id"] ?? null;
$passenger = $booking["passenger"] ?? [];


/*
|--------------------------------------------------------------------------
| DATA PENUMPANG
|--------------------------------------------------------------------------
*/

$passenger_name =
    trim(
        $passenger["name"]
        ?? $passenger["nama"]
        ?? $booking["passenger_name"]
        ?? $_SESSION["user"]["name"]
        ?? ""
    );

$birth_date =
    $passenger["birth"]
    ?? $passenger["birth_date"]
    ?? $passenger["tanggal_lahir"]
    ?? $passenger["dob"]
    ?? null;

$gender =
    $passenger["gender"]
    ?? $passenger["jenis_kelamin"]
    ?? null;

$nik =
    $passenger["id"]
    ?? $passenger["nik"]
    ?? $passenger["ktp"]
    ?? null;

$phone =
    $passenger["phone"]
    ?? $passenger["no_telp"]
    ?? $passenger["no_hp"]
    ?? null;

$email =
    $passenger["email"]
    ?? $_SESSION["user"]["email"]
    ?? null;


/*
|--------------------------------------------------------------------------
| DATA PERJALANAN
|--------------------------------------------------------------------------
*/

$travel_date =
    $booking["travel_date"]
    ?? $booking["date"]
    ?? null;

$seat =
    $booking["seat"]
    ?? null;

$total =
    $booking["total"]
    ?? 0;

$total = (int) preg_replace(
    "/[^0-9]/",
    "",
    (string) $total
);


/*
|--------------------------------------------------------------------------
| PAYMENT
|--------------------------------------------------------------------------
*/

$payment_method =
    trim($_POST["payment_method"] ?? "");

if ($passenger_name === "") {

    $_SESSION["payment_error"] =
        "Nama penumpang belum tersedia.";

    header("Location: payment.php");
    exit;
}

if ($payment_method === "") {

    $_SESSION["payment_error"] =
        "Silakan pilih metode pembayaran.";

    header("Location: payment.php");
    exit;
}


/*
|--------------------------------------------------------------------------
| BUAT KODE TIKET
|--------------------------------------------------------------------------
|
| Contoh:
| OCG-20260818-AB12CD
|
*/

$booking_code =
    "OCG-"
    . date("Ymd")
    . "-"
    . strtoupper(substr(md5(uniqid()), 0, 6));

$transaction_code = $booking_code;


/*
|--------------------------------------------------------------------------
| STATUS
|--------------------------------------------------------------------------
*/

$status = "Berhasil";


/*
|--------------------------------------------------------------------------
| SIMPAN KE DATABASE
|--------------------------------------------------------------------------
*/

try {

    /*
    |--------------------------------------------------------------------------
    | CEK APAKAH KOLOM TERSEDIA
    |--------------------------------------------------------------------------
    |
    | Struktur ini mengikuti database bookings yang sudah kamu gunakan.
    |
    */

    $sql = "
        INSERT INTO bookings
        (
            transaction_code,
            booking_code,

            user_id,
            ship_id,

            passenger_name,
            birth_date,
            gender,
            nik,
            phone,
            email,

            travel_date,
            seat,

            total,
            payment_method,
            status,

            booking_date,
            created_at
        )

        VALUES
        (
            :transaction_code,
            :booking_code,

            :user_id,
            :ship_id,

            :passenger_name,
            :birth_date,
            :gender,
            :nik,
            :phone,
            :email,

            :travel_date,
            :seat,

            :total,
            :payment_method,
            :status,

            NOW(),
            NOW()
        )
    ";


    $stmt = $pdo->prepare($sql);


    $stmt->execute([

        ":transaction_code" => $transaction_code,

        ":booking_code" => $booking_code,

        ":user_id" => $user_id,

        ":ship_id" => $ship_id,

        ":passenger_name" => $passenger_name,

        ":birth_date" => $birth_date ?: null,

        ":gender" => $gender ?: null,

        ":nik" => $nik ?: null,

        ":phone" => $phone ?: null,

        ":email" => $email ?: null,

        ":travel_date" => $travel_date ?: null,

        ":seat" => $seat ?: null,

        ":total" => $total,

        ":payment_method" => $payment_method,

        ":status" => $status

    ]);


    /*
    |--------------------------------------------------------------------------
    | SIMPAN DATA LENGKAP KE SESSION
    |--------------------------------------------------------------------------
    |
    | Ini penting supaya:
    |
    | success.php
    | ticket.php
    | tombol "Lihat Tiket"
    |
    | bisa menggunakan data tiket yang baru dibuat.
    |
    */

    $_SESSION["booking"]["code"] =
        $booking_code;

    $_SESSION["booking"]["booking_code"] =
        $booking_code;

    $_SESSION["booking"]["transaction_code"] =
        $transaction_code;

    $_SESSION["booking"]["payment_method"] =
        $payment_method;

    $_SESSION["booking"]["payment"] =
        $payment_method;

    $_SESSION["booking"]["payment_status"] =
        $status;

    $_SESSION["booking"]["status"] =
        $status;

    $_SESSION["booking"]["database_id"] =
        $pdo->lastInsertId();

    $_SESSION["booking"]["paid_at"] =
        date("Y-m-d H:i:s");

    /*
    |--------------------------------------------------------------------------
    | SIMPAN DATA PENUMPANG JUGA
    |--------------------------------------------------------------------------
    */

    $_SESSION["booking"]["passenger"] = [

        "name"   => $passenger_name,

        "id"     => $nik,

        "nik"    => $nik,

        "birth"  => $birth_date,

        "birth_date" => $birth_date,

        "gender" => $gender,

        "phone"  => $phone,

        "email"  => $email

    ];


    /*
    |--------------------------------------------------------------------------
    | REDIRECT KE HALAMAN BERHASIL
    |--------------------------------------------------------------------------
    */

    header("Location: success.php");
    exit;


} catch (PDOException $e) {

    die(
        "Booking gagal disimpan ke database.<br><br>"
        . htmlspecialchars($e->getMessage())
    );
}