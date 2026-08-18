<?php
require_once "config.php";
require_once "includes/functions.php";

/*
|--------------------------------------------------------------------------
| Ambil parameter pencarian
|--------------------------------------------------------------------------
*/

$from       = trim($_GET['from'] ?? '');
$to         = trim($_GET['to'] ?? '');
$date       = trim($_GET['date'] ?? '');
$class      = trim($_GET['class'] ?? '');
$passengers = max(1, (int)($_GET['passengers'] ?? 1));

$minPrice = isset($_GET['min_price'])
    ? (int)$_GET['min_price']
    : 0;

$maxPrice = isset($_GET['max_price'])
    ? (int)$_GET['max_price']
    : 999999999;

$timeFilter = $_GET['time'] ?? '';

$sort = $_GET['sort'] ?? 'recommended';


/*
|--------------------------------------------------------------------------
| Ambil semua kapal
|--------------------------------------------------------------------------
|
| Pastikan tabel database bernama "ships"
|
*/

$ships = [];

try {

    $stmt = $pdo->query("SELECT * FROM ships");

    $ships = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {

    $ships = [];

}


/*
|--------------------------------------------------------------------------
| Filter pencarian
|--------------------------------------------------------------------------
*/

$results = array_filter($ships, function ($ship) use (
    $from,
    $to,
    $date,
    $class,
    $minPrice,
    $maxPrice,
    $timeFilter
) {

    /*
    | Nama kolom dibuat fleksibel
    */

    $shipFrom = $ship['from']
        ?? $ship['origin']
        ?? $ship['pelabuhan_asal']
        ?? '';

    $shipTo = $ship['to']
        ?? $ship['destination']
        ?? $ship['pelabuhan_tujuan']
        ?? '';

    $shipDate = $ship['date']
        ?? $ship['departure_date']
        ?? $ship['tanggal']
        ?? '';

    $shipClass = $ship['class']
        ?? $ship['kelas']
        ?? '';

    $price = (int)(
        $ship['price']
        ?? $ship['harga']
        ?? 0
    );

    $shipTime = $ship['time']
        ?? $ship['departure_time']
        ?? $ship['jam']
        ?? '';


    /*
    |--------------------------------------------------------------------------
    | FILTER ASAL
    |--------------------------------------------------------------------------
    */

    if ($from !== '') {

        if (
            stripos($shipFrom, $from) === false
        ) {
            return false;
        }

    }


    /*
    |--------------------------------------------------------------------------
    | FILTER TUJUAN
    |--------------------------------------------------------------------------
    */

    if ($to !== '') {

        if (
            stripos($shipTo, $to) === false
        ) {
            return false;
        }

    }


    /*
    |--------------------------------------------------------------------------
    | FILTER TANGGAL
    |--------------------------------------------------------------------------
    */

    if ($date !== '') {

        if ($shipDate !== $date) {

            /*
            | Coba format tanggal Indonesia
            */

            $formattedDate = date(
                'Y-m-d',
                strtotime($shipDate)
            );

            if ($formattedDate !== $date) {
                return false;
            }

        }

    }


    /*
    |--------------------------------------------------------------------------
    | FILTER KELAS
    |--------------------------------------------------------------------------
    */

    if ($class !== '' && $class !== 'Semua Kelas') {

        if (
            strtolower($shipClass)
            !== strtolower($class)
        ) {
            return false;
        }

    }


    /*
    |--------------------------------------------------------------------------
    | FILTER HARGA
    |--------------------------------------------------------------------------
    */

    if ($price < $minPrice || $price > $maxPrice) {
        return false;
    }


    /*
    |--------------------------------------------------------------------------
    | FILTER WAKTU
    |--------------------------------------------------------------------------
    */

    if ($timeFilter !== '' && $shipTime !== '') {

        $hour = (int)date(
            'H',
            strtotime($shipTime)
        );


        if ($timeFilter === 'morning') {

            if ($hour < 5 || $hour >= 12) {
                return false;
            }

        }


        if ($timeFilter === 'afternoon') {

            if ($hour < 12 || $hour >= 18) {
                return false;
            }

        }


        if ($timeFilter === 'night') {

            if ($hour < 18 || $hour > 23) {
                return false;
            }

        }

    }


    return true;

});


$results = array_values($results);


/*
|--------------------------------------------------------------------------
| SORTING
|--------------------------------------------------------------------------
*/

if ($sort === 'price_low') {

    usort(
        $results,
        function ($a, $b) {

            $priceA = (int)(
                $a['price']
                ?? $a['harga']
                ?? 0
            );

            $priceB = (int)(
                $b['price']
                ?? $b['harga']
                ?? 0
            );

            return $priceA <=> $priceB;
        }
    );

}


if ($sort === 'price_high') {

    usort(
        $results,
        function ($a, $b) {

            $priceA = (int)(
                $a['price']
                ?? $a['harga']
                ?? 0
            );

            $priceB = (int)(
                $b['price']
                ?? $b['harga']
                ?? 0
            );

            return $priceB <=> $priceA;
        }
    );

}


if ($sort === 'departure') {

    usort(
        $results,
        function ($a, $b) {

            $timeA = $a['time']
                ?? $a['departure_time']
                ?? '00:00';

            $timeB = $b['time']
                ?? $b['departure_time']
                ?? '00:00';

            return strcmp(
                $timeA,
                $timeB
            );
        }
    );

}


$pageTitle = "Cari Tiket Kapal";

include "includes/header.php";
?>


<div class="search-page">

    <div class="container">


        <!-- =====================================================
             SEARCH BOX
        ====================================================== -->

        <div class="search-box">

            <form
                method="GET"
                action="search.php"
                id="searchForm"
            >

                <div class="search-field">

                    <label>
                        Pelabuhan Asal
                    </label>

                    <input
                        type="text"
                        name="from"
                        placeholder="Contoh: Surabaya"
                        value="<?= htmlspecialchars($from) ?>"
                    >

                </div>


                <button
                    type="button"
                    class="swap-btn"
                    id="swapLocation"
                >
                    ⇄
                </button>


                <div class="search-field">

                    <label>
                        Pelabuhan Tujuan
                    </label>

                    <input
                        type="text"
                        name="to"
                        placeholder="Contoh: Jakarta"
                        value="<?= htmlspecialchars($to) ?>"
                    >

                </div>


                <div class="search-field">

                    <label>
                        Tanggal Berangkat
                    </label>

                    <input
                        type="date"
                        name="date"
                        value="<?= htmlspecialchars($date) ?>"
                    >

                </div>


                <div class="search-field">

                    <label>
                        Penumpang
                    </label>

                    <select name="passengers">

                        <?php for ($i = 1; $i <= 10; $i++): ?>

                            <option
                                value="<?= $i ?>"
                                <?= $passengers == $i ? 'selected' : '' ?>
                            >
                                <?= $i ?> Dewasa
                            </option>

                        <?php endfor; ?>

                    </select>

                </div>


                <div class="search-field">

                    <label>
                        Kelas
                    </label>

                    <select name="class">

                        <option
                            value=""
                            <?= $class === '' ? 'selected' : '' ?>
                        >
                            Semua Kelas
                        </option>

                        <option
                            value="Ekonomi"
                            <?= $class === 'Ekonomi' ? 'selected' : '' ?>
                        >
                            Ekonomi
                        </option>

                        <option
                            value="Bisnis"
                            <?= $class === 'Bisnis' ? 'selected' : '' ?>
                        >
                            Bisnis
                        </option>

                        <option
                            value="VIP"
                            <?= $class === 'VIP' ? 'selected' : '' ?>
                        >
                            VIP
                        </option>

                    </select>

                </div>


                <button
                    type="submit"
                    class="search-btn"
                >
                    🔍 Cari Tiket
                </button>

            </form>

        </div>



        <!-- =====================================================
             HEADER RESULT
        ====================================================== -->

        <div class="result-header">

            <div>

                <span class="eyebrow dark">
                    HASIL PENCARIAN
                </span>

                <h1>

                    <?php if ($from || $to): ?>

                        <?= htmlspecialchars($from ?: 'Semua') ?>

                        <span>→</span>

                        <?= htmlspecialchars($to ?: 'Semua') ?>

                    <?php else: ?>

                        Semua Jadwal Kapal

                    <?php endif; ?>

                </h1>

                <p>

                    <?= count($results) ?>

                    perjalanan ditemukan

                </p>

            </div>


            <!-- SORT -->

            <form method="GET">

                <input
                    type="hidden"
                    name="from"
                    value="<?= htmlspecialchars($from) ?>"
                >

                <input
                    type="hidden"
                    name="to"
                    value="<?= htmlspecialchars($to) ?>"
                >

                <input
                    type="hidden"
                    name="date"
                    value="<?= htmlspecialchars($date) ?>"
                >

                <input
                    type="hidden"
                    name="class"
                    value="<?= htmlspecialchars($class) ?>"
                >

                <input
                    type="hidden"
                    name="passengers"
                    value="<?= $passengers ?>"
                >

                <input
                    type="hidden"
                    name="min_price"
                    value="<?= $minPrice ?>"
                >

                <input
                    type="hidden"
                    name="max_price"
                    value="<?= $maxPrice ?>"
                >

                <input
                    type="hidden"
                    name="time"
                    value="<?= htmlspecialchars($timeFilter) ?>"
                >


                <select
                    name="sort"
                    class="sort-select"
                    onchange="this.form.submit()"
                >

                    <option
                        value="recommended"
                        <?= $sort === 'recommended' ? 'selected' : '' ?>
                    >
                        Rekomendasi
                    </option>

                    <option
                        value="price_low"
                        <?= $sort === 'price_low' ? 'selected' : '' ?>
                    >
                        Harga Terendah
                    </option>

                    <option
                        value="price_high"
                        <?= $sort === 'price_high' ? 'selected' : '' ?>
                    >
                        Harga Tertinggi
                    </option>

                    <option
                        value="departure"
                        <?= $sort === 'departure' ? 'selected' : '' ?>
                    >
                        Keberangkatan Terawal
                    </option>

                </select>

            </form>

        </div>



        <div class="results-layout">


            <!-- =================================================
                 FILTER SIDEBAR
            ================================================== -->

            <aside class="filter-card">

                <div class="filter-title">

                    <h3>
                        Filter
                    </h3>

                    <a href="search.php">
                        Reset
                    </a>

                </div>


                <form method="GET">


                    <!-- KEEP SEARCH -->

                    <input
                        type="hidden"
                        name="from"
                        value="<?= htmlspecialchars($from) ?>"
                    >

                    <input
                        type="hidden"
                        name="to"
                        value="<?= htmlspecialchars($to) ?>"
                    >

                    <input
                        type="hidden"
                        name="date"
                        value="<?= htmlspecialchars($date) ?>"
                    >

                    <input
                        type="hidden"
                        name="passengers"
                        value="<?= $passengers ?>"
                    >

                    <input
                        type="hidden"
                        name="class"
                        value="<?= htmlspecialchars($class) ?>"
                    >


                    <!-- PRICE -->

                    <div class="filter-group">

                        <h4>
                            Harga
                        </h4>


                        <label>
                            Minimal
                        </label>

                        <input
                            type="number"
                            name="min_price"
                            placeholder="Rp 0"
                            value="<?= $minPrice ?: '' ?>"
                        >


                        <label>
                            Maksimal
                        </label>

                        <input
                            type="number"
                            name="max_price"
                            placeholder="Rp 1.000.000"
                            value="<?= $maxPrice != 999999999 ? $maxPrice : '' ?>"
                        >

                    </div>


                    <!-- CLASS -->

                    <div class="filter-group">

                        <h4>
                            Kelas Kapal
                        </h4>


                        <label class="check-row">

                            <input
                                type="radio"
                                name="class"
                                value=""
                                <?= $class === '' ? 'checked' : '' ?>
                            >

                            Semua Kelas

                        </label>


                        <label class="check-row">

                            <input
                                type="radio"
                                name="class"
                                value="Ekonomi"
                                <?= $class === 'Ekonomi' ? 'checked' : '' ?>
                            >

                            Ekonomi

                        </label>


                        <label class="check-row">

                            <input
                                type="radio"
                                name="class"
                                value="Bisnis"
                                <?= $class === 'Bisnis' ? 'checked' : '' ?>
                            >

                            Bisnis

                        </label>


                        <label class="check-row">

                            <input
                                type="radio"
                                name="class"
                                value="VIP"
                                <?= $class === 'VIP' ? 'checked' : '' ?>
                            >

                            VIP

                        </label>

                    </div>


                    <!-- TIME -->

                    <div class="filter-group">

                        <h4>
                            Waktu Berangkat
                        </h4>


                        <label class="check-row">

                            <input
                                type="radio"
                                name="time"
                                value=""
                                <?= $timeFilter === '' ? 'checked' : '' ?>
                            >

                            Semua Waktu

                        </label>


                        <label class="check-row">

                            <input
                                type="radio"
                                name="time"
                                value="morning"
                                <?= $timeFilter === 'morning' ? 'checked' : '' ?>
                            >

                            🌅 Pagi
                            <small>05:00 - 12:00</small>

                        </label>


                        <label class="check-row">

                            <input
                                type="radio"
                                name="time"
                                value="afternoon"
                                <?= $timeFilter === 'afternoon' ? 'checked' : '' ?>
                            >

                            ☀️ Siang
                            <small>12:00 - 18:00</small>

                        </label>


                        <label class="check-row">

                            <input
                                type="radio"
                                name="time"
                                value="night"
                                <?= $timeFilter === 'night' ? 'checked' : '' ?>
                            >

                            🌙 Malam
                            <small>18:00 - 24:00</small>

                        </label>

                    </div>


                    <input
                        type="hidden"
                        name="sort"
                        value="<?= htmlspecialchars($sort) ?>"
                    >


                    <button
                        type="submit"
                        class="filter-button"
                    >
                        Terapkan Filter
                    </button>

                </form>

            </aside>



            <!-- =================================================
                 RESULT LIST
            ================================================== -->

            <main class="ship-results">


                <?php if (empty($results)): ?>


                    <div class="empty-result">

                        <div class="empty-icon">
                            🚢
                        </div>

                        <h2>
                            Tiket Tidak Ditemukan
                        </h2>

                        <p>
                            Coba ubah pelabuhan, tanggal,
                            kelas, atau filter harga.
                        </p>

                        <a
                            href="search.php"
                            class="btn btn-primary"
                        >
                            Lihat Semua Jadwal
                        </a>

                    </div>


                <?php else: ?>


                    <?php foreach ($results as $ship): ?>


                        <?php

                        $id = $ship['id'] ?? '';

                        $name =
                            $ship['name']
                            ?? $ship['nama']
                            ?? $ship['ship_name']
                            ?? 'Kapal Oceango';

                        $origin =
                            $ship['from']
                            ?? $ship['origin']
                            ?? $ship['pelabuhan_asal']
                            ?? '-';

                        $destination =
                            $ship['to']
                            ?? $ship['destination']
                            ?? $ship['pelabuhan_tujuan']
                            ?? '-';

                        $shipDate =
                            $ship['date']
                            ?? $ship['departure_date']
                            ?? $ship['tanggal']
                            ?? '-';

                        $time =
                            $ship['time']
                            ?? $ship['departure_time']
                            ?? $ship['jam']
                            ?? '-';

                        $shipClass =
                            $ship['class']
                            ?? $ship['kelas']
                            ?? 'Ekonomi';

                        $price =
                            (int)(
                                $ship['price']
                                ?? $ship['harga']
                                ?? 0
                            );

                        $available =
                            (int)(
                                $ship['available']
                                ?? $ship['tersedia']
                                ?? 20
                            );

                        ?>


                        <article class="ship-card">


                            <!-- SHIP ICON -->

                            <div class="ship-logo">
                                🚢
                            </div>


                            <div class="ship-main">


                                <div class="ship-top">

                                    <div>

                                        <h3>
                                            <?= htmlspecialchars($name) ?>
                                        </h3>

                                        <span class="ship-class">

                                            <?= htmlspecialchars($shipClass) ?>

                                        </span>

                                    </div>


                                    <span class="seat-available">

                                        <?= $available ?> kursi tersedia

                                    </span>

                                </div>


                                <!-- ROUTE -->

                                <div class="ship-route">

                                    <div>

                                        <strong>
                                            <?= htmlspecialchars($time) ?>
                                        </strong>

                                        <span>
                                            <?= htmlspecialchars($origin) ?>
                                        </span>

                                    </div>


                                    <div class="route-line">

                                        <span>●</span>

                                        <i></i>

                                        <span>●</span>

                                    </div>


                                    <div>

                                        <strong>
                                            <?= htmlspecialchars($time) ?>
                                        </strong>

                                        <span>
                                            <?= htmlspecialchars($destination) ?>
                                        </span>

                                    </div>

                                </div>


                                <div class="ship-bottom">

                                    <div>

                                        <small>
                                            Berangkat
                                        </small>

                                        <b>
                                            <?= htmlspecialchars($shipDate) ?>
                                        </b>

                                    </div>


                                    <div>

                                        <small>
                                            Mulai dari
                                        </small>

                                        <strong class="ship-price">

                                            <?= rupiah($price) ?>

                                        </strong>

                                    </div>


                                    <a
                                        href="detail.php?id=<?= urlencode($id) ?>"
                                        class="btn btn-primary"
                                    >
                                        Pilih
                                    </a>

                                </div>


                            </div>

                        </article>


                    <?php endforeach; ?>


                <?php endif; ?>


            </main>

        </div>

    </div>

</div>



<script>

/*
|--------------------------------------------------------------------------
| TUKAR ASAL DAN TUJUAN
|--------------------------------------------------------------------------
*/

const swapButton =
    document.getElementById('swapLocation');


if (swapButton) {

    swapButton.addEventListener(
        'click',
        function () {

            const from =
                document.querySelector(
                    'input[name="from"]'
                );

            const to =
                document.querySelector(
                    'input[name="to"]'
                );

            const temp = from.value;

            from.value = to.value;

            to.value = temp;

        }
    );

}

</script>


<?php include "includes/footer.php"; ?>