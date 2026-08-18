<?php
require_once "config.php";
require_once "includes/functions.php";

require_login();
$ship = get_ship($_GET['id'] ?? $_SESSION['booking']['ship_id'] ?? 'dharmakartika');
if (!empty($_POST['selected_seat'])) {
    $_SESSION['booking'] = [
        "ship_id"=>$ship['id'],
        "seat"=>$_POST['selected_seat'],
        "passengers"=>(int)($_POST['passengers'] ?? 1),
        "total"=>$ship['price'] * (int)($_POST['passengers'] ?? 1)
    ];
    header("Location: passenger.php"); exit;
}
$pageTitle = "Pilih Kursi";
include "includes/header.php";
?>
<div class="page-bg"><div class="container booking-page">
    <div class="steps"><span class="active">1 <b>Pilih Kursi</b></span><i></i><span>2 <b>Data Penumpang</b></span><i></i><span>3 <b>Pembayaran</b></span></div>
    <div class="booking-grid">
        <section class="seat-card">
            <div class="section-heading compact-heading"><div><span class="eyebrow dark">KURSI <?= e($ship['name']) ?></span><h2>Pilih kursi favoritmu</h2></div><span class="class-tag"><?= e($ship['class']) ?></span></div>
            <div class="seat-legend"><span><i class="seat available"></i>Tersedia</span><span><i class="seat selected"></i>Dipilih</span><span><i class="seat taken"></i>Terisi</span></div>
            <form method="post" id="seatForm">
                <input type="hidden" name="selected_seat" id="selectedSeat">
                <div class="deck">
                    <div class="deck-title">AREA PENUMPANG</div>
                    <?php
                    $taken = ['A2','B3','C4','D1','E5'];
                    foreach (range(1,5) as $row):
                    ?>
                    <div class="seat-row">
                        <b><?= $row ?></b>
                        <?php foreach (['A','B'] as $letter): $s=$letter.$row; $isTaken=in_array($s,$taken); ?>
                            <button type="button" class="seat <?= $isTaken?'taken':'available' ?>" <?= $isTaken?'disabled':'' ?> data-seat="<?= $s ?>" onclick="selectSeat(this)"><?= $s ?></button>
                        <?php endforeach; ?>
                        <span class="aisle">•</span>
                        <?php foreach (['C','D','E'] as $letter): $s=$letter.$row; $isTaken=in_array($s,$taken); ?>
                            <button type="button" class="seat <?= $isTaken?'taken':'available' ?>" <?= $isTaken?'disabled':'' ?> data-seat="<?= $s ?>" onclick="selectSeat(this)"><?= $s ?></button>
                        <?php endforeach; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="seat-note">💡 Pilih satu kursi untuk melanjutkan.</div>
            </form>
        </section>
        <aside class="booking-summary sticky"><span>Ringkasan Pesanan</span><h3><?= e($ship['name']) ?></h3><div class="summary-route">📍 <?= e($ship['from']) ?> → <?= e($ship['to']) ?></div><hr><div><span>Tanggal</span><b><?= e($ship['date']) ?></b></div><div><span>Kelas</span><b><?= e($ship['class']) ?></b></div><div><span>Kursi</span><b id="summarySeat">Belum dipilih</b></div><hr><div class="total"><span>Total</span><strong id="summaryPrice"><?= rupiah($ship['price']) ?></strong></div><button form="seatForm" class="btn btn-primary full" type="submit" id="continueSeat" disabled>Lanjutkan</button></aside>
    </div>
</div></div>
<?php include "includes/footer.php"; ?>