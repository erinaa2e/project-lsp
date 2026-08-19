<?php

require_once __DIR__ . '/includes/functions.php';

require_admin();


$ships = [

    [
        'id' => 1,
        'name' => 'Oceango Express',
        'code' => 'OCG-001',
        'type' => 'Fast Ferry',
        'capacity' => 450,
        'class' => 'Executive',
        'status' => 'Aktif'
    ],

    [
        'id' => 2,
        'name' => 'Oceango Marina',
        'code' => 'OCG-002',
        'type' => 'Passenger Ferry',
        'capacity' => 600,
        'class' => 'Business',
        'status' => 'Perawatan'
    ],

    [
        'id' => 3,
        'name' => 'Oceango Bahari',
        'code' => 'OCG-003',
        'type' => 'Ferry',
        'capacity' => 520,
        'class' => 'Economy',
        'status' => 'Aktif'
    ],

    [
        'id' => 4,
        'name' => 'Oceango Nusantara',
        'code' => 'OCG-004',
        'type' => 'Fast Ferry',
        'capacity' => 380,
        'class' => 'Executive',
        'status' => 'Aktif'
    ],

    [
        'id' => 5,
        'name' => 'Oceango Samudra',
        'code' => 'OCG-005',
        'type' => 'Passenger Ferry',
        'capacity' => 700,
        'class' => 'Business',
        'status' => 'Aktif'
    ],

    [
        'id' => 6,
        'name' => 'Oceango Island',
        'code' => 'OCG-006',
        'type' => 'Ferry',
        'capacity' => 410,
        'class' => 'Economy',
        'status' => 'Perawatan'
    ]

];


$action =
    $_GET['action'] ?? '';

$id =
    (int) ($_GET['id'] ?? 0);


$selected = null;


foreach ($ships as $ship) {

    if ($ship['id'] === $id) {

        $selected = $ship;

        break;
    }
}


/* TAMBAH / EDIT */

if (
    $action === 'tambah'
    ||
    $action === 'edit'
) {

    $pageTitle =
        $action === 'tambah'
            ? 'Tambah Kapal'
            : 'Edit Kapal';

    include __DIR__ . '/includes/header.php';


    $data =
        $selected
            ?: [
                'name' => '',
                'code' => '',
                'type' => 'Fast Ferry',
                'capacity' => '',
                'class' => 'Executive',
                'status' => 'Aktif'
            ];

?>


<div class="page-head">

    <div>

        <h2>
            <?= $action === 'tambah'
                ? 'Tambah Kapal'
                : 'Edit Kapal'
            ?>
        </h2>

        <p>
            Lengkapi informasi armada Oceango.
        </p>

    </div>

</div>


<div class="card form-card">


<form method="POST">


    <div class="form-grid">


        <div class="field">

            <label>
                NAMA KAPAL
            </label>

            <input
                type="text"
                name="name"
                value="<?= e($data['name']) ?>"
                placeholder="Contoh: Oceango Express"
                required
            >

        </div>


        <div class="field">

            <label>
                KODE KAPAL
            </label>

            <input
                type="text"
                name="code"
                value="<?= e($data['code']) ?>"
                placeholder="OCG-001"
                required
            >

        </div>


        <div class="field">

            <label>
                JENIS KAPAL
            </label>

            <select name="type">

                <option>
                    Fast Ferry
                </option>

                <option>
                    Passenger Ferry
                </option>

                <option>
                    Ferry
                </option>

            </select>

        </div>


        <div class="field">

            <label>
                KAPASITAS
            </label>

            <input
                type="number"
                name="capacity"
                value="<?= e($data['capacity']) ?>"
                placeholder="450"
                required
            >

        </div>


        <div class="field">

            <label>
                KELAS
            </label>

            <select name="class">

                <option>
                    Executive
                </option>

                <option>
                    Business
                </option>

                <option>
                    Economy
                </option>

            </select>

        </div>


        <div class="field">

            <label>
                STATUS
            </label>

            <select name="status">

                <option>
                    Aktif
                </option>

                <option>
                    Perawatan
                </option>

                <option>
                    Nonaktif
                </option>

            </select>

        </div>


    </div>


    <div class="form-actions">

        <a
            href="kapal.php"
            class="btn btn-light"
        >
            Batal
        </a>

        <button
            type="submit"
            class="btn btn-primary"
        >
            Simpan Kapal
        </button>

    </div>


</form>


</div>


<?php

include __DIR__ . '/includes/footer.php';

exit;

}


/* DETAIL */

if ($action === 'detail') {

    $pageTitle =
        'Detail Kapal';

    include __DIR__ . '/includes/header.php';


    if (!$selected) {

        ?>

        <div class="card empty">

            Data kapal tidak ditemukan.

        </div>

        <?php

        include __DIR__ . '/includes/footer.php';

        exit;
    }

?>


<div class="page-head">

    <div>

        <h2>
            Detail Kapal
        </h2>

        <p>
            Informasi lengkap armada.
        </p>

    </div>


    <a
        href="kapal.php?action=edit&id=<?= $selected['id'] ?>"
        class="btn btn-primary"
    >
        Edit Kapal
    </a>

</div>


<div class="card form-card">

    <div class="detail-ship-icon">
        🚢
    </div>

    <h2>
        <?= e($selected['name']) ?>
    </h2>

    <p class="muted">
        <?= e($selected['code']) ?>
        •
        <?= e($selected['type']) ?>
    </p>


    <div class="ship-meta">


        <div>

            <span>
                KAPASITAS
            </span>

            <b>
                <?= e($selected['capacity']) ?>
                Penumpang
            </b>

        </div>


        <div>

            <span>
                KELAS
            </span>

            <b>
                <?= e($selected['class']) ?>
            </b>

        </div>


        <div>

            <span>
                STATUS
            </span>

            <b>
                <?= e($selected['status']) ?>
            </b>

        </div>


        <div>

            <span>
                KODE
            </span>

            <b>
                <?= e($selected['code']) ?>
            </b>

        </div>


    </div>


    <a
        href="kapal.php"
        class="btn btn-light"
    >
        ← Kembali
    </a>

</div>


<?php

include __DIR__ . '/includes/footer.php';

exit;

}


/* LIST */

$pageTitle =
    'Kelola Kapal';

include __DIR__ . '/includes/header.php';

?>


<div class="page-head">

    <div>

        <h2>
            Kelola Kapal
        </h2>

        <p>
            Kelola seluruh armada kapal Oceango.
        </p>

    </div>


    <a
        href="kapal.php?action=tambah"
        class="btn btn-primary"
    >
        + Tambah Kapal
    </a>

</div>


<div class="toolbar">

    <input
        type="text"
        class="search"
        placeholder="🔎  Cari nama kapal..."
    >

    <span class="muted">
        24 kapal terdaftar
    </span>

</div>


<div class="cards">


<?php foreach ($ships as $ship): ?>


<div class="card ship">


    <div class="ship-top">

        <div class="ship-icon">
            🚢
        </div>


        <span
            class="status <?= $ship['status'] === 'Aktif'
                ? 'success'
                : 'warning'
            ?>"
        >
            <?= e($ship['status']) ?>
        </span>

    </div>


    <h3>
        <?= e($ship['name']) ?>
    </h3>


    <div class="muted">

        <?= e($ship['code']) ?>

        •

        <?= e($ship['type']) ?>

    </div>


    <div class="ship-meta">


        <div>

            <span>
                KAPASITAS
            </span>

            <b>
                <?= e($ship['capacity']) ?>
                Penumpang
            </b>

        </div>


        <div>

            <span>
                KELAS
            </span>

            <b>
                <?= e($ship['class']) ?>
            </b>

        </div>


    </div>


    <div class="actions">

        <a
            href="kapal.php?action=detail&id=<?= $ship['id'] ?>"
            class="btn btn-light"
        >
            Detail
        </a>


        <a
            href="kapal.php?action=edit&id=<?= $ship['id'] ?>"
            class="btn btn-primary"
        >
            Edit
        </a>

    </div>


</div>


<?php endforeach; ?>


</div>


<?php

include __DIR__ . '/includes/footer.php';

?>