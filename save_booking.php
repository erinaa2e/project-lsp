<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/*
|--------------------------------------------------------------------------
| DATABASE
|--------------------------------------------------------------------------
*/

$dbHost = "localhost";
$dbName = "oceango";
$dbUser = "root";
$dbPass = "";

try {

    $pdo = new PDO(
        "mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4",
        $dbUser,
        $dbPass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );

} catch (PDOException $e) {

    die("Database gagal terhubung: " . $e->getMessage());

}


/*
|--------------------------------------------------------------------------
| CEK METHOD
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Request tidak valid.");
}


/*
|--------------------------------------------------------------------------
| AMBIL DATA DARI FORM
|--------------------------------------------------------------------------
*/

$user_id = $_SESSION['user_id'] ?? null;

$ship_id = $_POST['ship_id'] ?? null;

$passenger_name = trim($_POST['passenger_name'] ?? '');

$nik = trim($_POST['nik'] ?? '');

$phone = trim($_POST['phone'] ?? '');

$email = trim($_POST['email'] ?? '');

$travel_date = $_POST['travel_date'] ?? '';

$seat = trim($_POST['seat'] ?? '');

$total = $_POST['total'] ?? 0;

$payment_method = trim($_POST['payment_method'] ?? '');


/*
|--------------------------------------------------------------------------
| VALIDASI
|--------------------------------------------------------------------------
*/

if (
    empty($ship_id) ||
    empty($passenger_name) ||
    empty($phone) ||
    empty($email) ||
    empty($travel_date) ||
    empty($seat) ||
    empty($payment_method)
) {

    die("Data booking belum lengkap.");

}


/*
|--------------------------------------------------------------------------
| BERSIHKAN TOTAL
|--------------------------------------------------------------------------
*/

$total = (int) preg_replace('/[^0-9]/', '', $total);


/*
|--------------------------------------------------------------------------
| BUAT KODE BOOKING
|--------------------------------------------------------------------------
*/

$booking_code = 'OCG' . date('YmdHis') . rand(100, 999);


/*
|--------------------------------------------------------------------------
| STATUS PEMBAYARAN
|--------------------------------------------------------------------------
|
| Karena halaman ini dipanggil setelah user klik BAYAR/selesai,
| kita simpan status sebagai Berhasil.
|
*/

$status = 'Berhasil';


/*
|--------------------------------------------------------------------------
| SIMPAN KE DATABASE
|--------------------------------------------------------------------------
*/

$sql = "
    INSERT INTO bookings
    (
        booking_code,
        user_id,
        ship_id,
        passenger_name,
        nik,
        phone,
        email,
        travel_date,
        seat,
        total,
        payment_method,
        status,
        created_at
    )
    VALUES
    (
        :booking_code,
        :user_id,
        :ship_id,
        :passenger_name,
        :nik,
        :phone,
        :email,
        :travel_date,
        :seat,
        :total,
        :payment_method,
        :status,
        NOW()
    )
";


$stmt = $pdo->prepare($sql);

$stmt->execute([

    ':booking_code'   => $booking_code,

    ':user_id'        => $user_id,

    ':ship_id'        => $ship_id,

    ':passenger_name' => $passenger_name,

    ':nik'            => $nik,

    ':phone'          => $phone,

    ':email'          => $email,

    ':travel_date'    => $travel_date,

    ':seat'           => $seat,

    ':total'          => $total,

    ':payment_method' => $payment_method,

    ':status'         => $status

]);


/*
|--------------------------------------------------------------------------
| SIMPAN KODE BOOKING KE SESSION
|--------------------------------------------------------------------------
*/

$_SESSION['booking_code'] = $booking_code;


/*
|--------------------------------------------------------------------------
| REDIRECT KE HALAMAN BERHASIL
|--------------------------------------------------------------------------
*/

header(
    "Location: success.php?booking=" .
    urlencode($booking_code)
);

exit;