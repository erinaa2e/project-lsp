<?php

require_once __DIR__ . '/includes/functions.php';

require_admin();


$schedules = [

    [
        'id' => 1,
        'ship' => 'Oceango Express',
        'route' => 'Surabaya → Jakarta',
        'date' => '2026-08-14',
        'time' => '08:00',
        'price' => 450000,
        'status' => 'Tersedia'
    ],

    [
        'id' => 2,
        'ship' => 'Oceango Marina',
        'route' => 'Jakarta → Surabaya',
        'date' => '2026-08-14',
        'time' => '13:00',
        'price' => 375000,
        'status' => 'Tersedia'
    ],

    [
        'id' => 3,
        'ship' => 'Oceango Bahari',
        'route' => 'Bali → Lombok',
        'date' => '2026-08-15',
        'time' => '09:00',
        'price' => 280000,
        'status' => 'Tersedia'
    ],

    [
        'id' => 4,
        'ship' => 'Oceango Nusantara',
        'route' => 'Lombok → Bali',
        'date' => '2026-08-15',
        'time' => '15:00',
        'price' => 280000,
        'status' => 'Penuh'
    ]

];


$action =
    $_GET['action'] ?? '';

$id =
    (int) ($_GET['id'] ?? 0);

$selected = null;


foreach ($schedules as $schedule) {

    if ($schedule['id'] === $id) {

        $selected = $schedule;

        break;
    }

}


/* FORM */

if (
    $action === 'tambah'
    ||
    $action === 'edit'
) {

    $pageTitle =
        $action === 'tambah'
            ? 'Tambah Jadwal'
            : 'Edit Jadwal';

    include __DIR__ . '/includes/header.php';


    $data =
        $selected
            ?: [
                'ship' => 'Oceango Express',
                'route' => '',
                'date' => '',
                'time' => '08:00',
                'price' => '',
                'status' => 'Tersedia'
            ];

?>


<div class="page-head">

    <div>

        <h2>
            <?= $action === 'tambah'
                ? 'Tambah Jadwal'
                : 'Edit Jadwal'
            ?>
        </h2>

        <p>
            Atur jadwal perjalanan kapal.
        </p>

    </div>

</div>


<div class="card form-card">


<form method="POST">


<div class="form-grid">


    <div class="field">

        <label>
            KAPAL
        </label>

        <select name="ship">

            <option>
                Oceango Express
            </option>

            <option>
                Oceango Marina
            </option>

            <option>
                Oceango Bahari
            </option>

            <option>
                Oceango Nusantara
            </option>

        </select>

    </div>


    <div class="field">

        <label>
            RUTE
        </label>

        <input
            type="text"
            name="route"
            value="<?= e($data['route']) ?>"
            placeholder="Surabaya → Jakarta"
            required
        >

    </div>


    <div class="field">

        <label>
            TANGGAL
        </label>

        <input
            type="date"
            name="date"
            value="<?= e($data['date']) ?>"
            required
        >

    </div>


    <div class="field">

        <label>
            JAM
        </label>

        <input
            type="time"
            name="time"
            value="<?= e($data['time']) ?>"
            required
        >

    </div>


    <div class="field">

        <label>
            HARGA TIKET
        </label>

        <input
            type="number"
            name="price"
            value="<?= e($data['price']) ?>"
            required
        >

    </div>


    <div class="field">

        <label>
            STATUS
        </label>

        <select name="status">

            <option>
                Tersedia
            </option>

            <option>
                Penuh
            </option>

            <option>
                Dibatalkan
            </option>

        </select>

    </div>


</div>


<div class="form-actions">

    <a
        href="jadwal.php"
        class="btn btn-light"
    >
        Batal
    </a>

    <button
        type="submit"
        class="btn btn-primary"
    >
        Simpan Jadwal
    </button>

</div>


</form>


</div>


<?php

include __DIR__ . '/includes/footer.php';

exit;

}


/* LIST */

$pageTitle =
    'Jadwal';

include __DIR__ . '/includes/header.php';

?>


<div class="page-head">

    <div>

        <h2>
            Jadwal Perjalanan
        </h2>

        <p>
            Kelola jadwal keberangkatan kapal.
        </p>

    </div>


    <a
        href="jadwal.php?action=tambah"
        class="btn btn-primary"
    >
        + Tambah Jadwal
    </a>

</div>


<div class="card">

    <div class="table-wrap">

        <table class="table">

            <thead>

                <tr>

                    <th>
                        KAPAL
                    </th>

                    <th>
                        RUTE
                    </th>

                    <th>
                        TANGGAL
                    </th>

                    <th>
                        JAM
                    </th>

                    <th>
                        HARGA
                    </th>

                    <th>
                        STATUS
                    </th>

                    <th>
                        AKSI
                    </th>

                </tr>

            </thead>


            <tbody>


            <?php foreach ($schedules as $schedule): ?>


                <tr>

                    <td>

                        <b>
                            <?= e($schedule['ship']) ?>
                        </b>

                    </td>


                    <td>
                        <?= e($schedule['route']) ?>
                    </td>


                    <td>
                        <?= tanggal($schedule['date']) ?>
                    </td>


                    <td>
                        <?= e($schedule['time']) ?>
                    </td>


                    <td>
                        <?= rupiah($schedule['price']) ?>
                    </td>


                    <td>

                        <span
                            class="status <?= $schedule['status'] === 'Tersedia'
                                ? 'success'
                                : 'warning'
                            ?>"
                        >
                            <?= e($schedule['status']) ?>
                        </span>

                    </td>


                    <td>

                        <a
                            href="jadwal.php?action=edit&id=<?= $schedule['id'] ?>"
                            class="btn btn-light"
                        >
                            Edit
                        </a>

                    </td>

                </tr>


            <?php endforeach; ?>


            </tbody>

        </table>

    </div>

</div>


<?php

include __DIR__ . '/includes/footer.php';

?>