<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function e($value)
{
    return htmlspecialchars(
        (string) $value,
        ENT_QUOTES,
        'UTF-8'
    );
}

function admin_logged_in()
{
    return !empty($_SESSION['oceango_admin']);
}

function require_admin()
{
    if (!admin_logged_in()) {
        header('Location: login.php');
        exit;
    }
}

function redirect($url)
{
    header('Location: ' . $url);
    exit;
}

function rupiah($value)
{
    return 'Rp ' . number_format(
        (float) $value,
        0,
        ',',
        '.'
    );
}

function tanggal($value)
{
    $time = strtotime($value);

    if (!$time) {
        return e($value);
    }

    $bulan = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember'
    ];

    return date('d', $time)
        . ' '
        . $bulan[(int) date('m', $time)]
        . ' '
        . date('Y', $time);
}