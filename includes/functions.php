<?php
function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function is_logged_in() {
    return !empty($_SESSION['user']);
}

function require_login() {
    if (!is_logged_in()) {
        header("Location: login.php?redirect=booking");
        exit;
    }
}

function rupiah($number) {
    return "Rp " . number_format((float)$number, 0, ',', '.');
}

function ships() {
    return [
        [
            "id" => "dharmakartika",
            "name" => "KM Dharma Kartika IX",
            "route" => "Surabaya → Jakarta",
            "from" => "Surabaya",
            "to" => "Jakarta",
            "date" => "25 Mei 2024",
            "time" => "07:00 - 19:30",
            "duration" => "12j 30m",
            "class" => "Eksekutif",
            "price" => 350000,
            "available" => 30,
            "rating" => "4.8",
            "color" => "navy"
        ],
        [
            "id" => "dorlonda",
            "name" => "KM Dorlonda",
            "route" => "Surabaya → Jakarta",
            "from" => "Surabaya",
            "to" => "Jakarta",
            "date" => "25 Mei 2024",
            "time" => "09:00 - 21:00",
            "duration" => "12j 00m",
            "class" => "Ekonomi",
            "price" => 250000,
            "available" => 45,
            "rating" => "4.6",
            "color" => "blue"
        ],
        [
            "id" => "kelud",
            "name" => "KM Kelud",
            "route" => "Surabaya → Jakarta",
            "from" => "Surabaya",
            "to" => "Jakarta",
            "date" => "25 Mei 2024",
            "time" => "13:00 - 23:30",
            "duration" => "10j 30m",
            "class" => "Ekonomi",
            "price" => 220000,
            "available" => 28,
            "rating" => "4.7",
            "color" => "cyan"
        ]
    ];
}

function get_ship($id) {
    foreach (ships() as $ship) {
        if ($ship['id'] === $id) return $ship;
    }
    return ships()[0];
}
?>