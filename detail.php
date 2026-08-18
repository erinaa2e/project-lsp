<?php
require_once "includes/functions.php";
$ship = get_ship($_GET['id'] ?? 'dharmakartika');
$pageTitle = $ship['name'];
include "includes/header.php";
?>
<div class="page-bg"><div class="container detail-page">
    <div class="breadcrumb"><a href="search.php">Cari Tiket</a> <span>›</span> Detail Kapal</div>
    <div class="detail-hero">
        <div class="detail-art"><img src="assets/img/ship.svg" alt="Kapal"></div>
        <div><span class="class-tag"><?= e($ship['class']) ?></span><h1><?= e($ship['name']) ?></h1><p>Perjalanan nyaman dengan fasilitas lengkap untuk rute <?= e($ship['route']) ?>.</p><div class="rating">★ <?= e($ship['rating']) ?> <span>• 120+ ulasan</span></div></div>
    </div>
    <div class="detail-grid">
        <div class="detail-content">
            <div class="info-card"><h3>Detail Perjalanan</h3><div class="timeline"><div><b><?= e($ship['time']) ?></b><span><?= e($ship['from']) ?></span><small>Pelabuhan Tanjung Perak</small></div><i></i><div><b><?= e($ship['duration']) ?></b><span>Perjalanan laut</span></div><i></i><div><b>19:30</b><span><?= e($ship['to']) ?></span><small>Pelabuhan Tanjung Priok</small></div></div></div>
            <div class="info-card"><h3>Fasilitas</h3><div class="amenities"><span>❄️ AC</span><span>🛏️ Tempat Tidur</span><span>🚿 Kamar Mandi</span><span>📱 Charging Point</span><span>🍽️ Kantin</span><span>🛟 Keselamatan</span></div></div>
        </div>
        <aside class="booking-summary"><span>Harga tiket</span><strong><?= rupiah($ship['price']) ?></strong><small>per penumpang</small><hr><div><span>Kelas</span><b><?= e($ship['class']) ?></b></div><div><span>Kursi tersedia</span><b><?= e($ship['available']) ?></b></div><a class="btn btn-primary full" href="booking.php?id=<?= e($ship['id']) ?>">Pilih Kursi</a></aside>
    </div>
</div></div>
<?php include "includes/footer.php"; ?>