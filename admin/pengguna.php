<?php

require_once __DIR__ . '/includes/functions.php';

require_admin();


$users = [

    [
        'name' => 'Erinna',
        'email' => 'erinna@example.com',
        'phone' => '081234567890',
        'joined' => '2026-07-01',
        'status' => 'Aktif'
    ],

    [
        'name' => 'Andi',
        'email' => 'andi@example.com',
        'phone' => '081298765432',
        'joined' => '2026-07-03',
        'status' => 'Aktif'
    ],

    [
        'name' => 'Sinta',
        'email' => 'sinta@example.com',
        'phone' => '081277788899',
        'joined' => '2026-07-05',
        'status' => 'Aktif'
    ],

    [
        'name' => 'Raka',
        'email' => 'raka@example.com',
        'phone' => '081255566677',
        'joined' => '2026-07-09',
        'status' => 'Aktif'
    ],

    [
        'name' => 'Nadia',
        'email' => 'nadia@example.com',
        'phone' => '081211223344',
        'joined' => '2026-07-10',
        'status' => 'Aktif'
    ],

    [
        'name' => 'Bima',
        'email' => 'bima@example.com',
        'phone' => '081233445566',
        'joined' => '2026-07-11',
        'status' => 'Nonaktif'
    ],

    [
        'name' => 'Dina',
        'email' => 'dina@example.com',
        'phone' => '081277766655',
        'joined' => '2026-07-12',
        'status' => 'Aktif'
    ],

    [
        'name' => 'Fajar',
        'email' => 'fajar@example.com',
        'phone' => '081299887766',
        'joined' => '2026-07-13',
        'status' => 'Aktif'
    ],

    [
        'name' => 'Nina',
        'email' => 'nina@example.com',
        'phone' => '081288776655',
        'joined' => '2026-07-14',
        'status' => 'Aktif'
    ],

    [
        'name' => 'Yoga',
        'email' => 'yoga@example.com',
        'phone' => '081266554433',
        'joined' => '2026-07-15',
        'status' => 'Aktif'
    ],

    [
        'name' => 'Lala',
        'email' => 'lala@example.com',
        'phone' => '081233221100',
        'joined' => '2026-07-16',
        'status' => 'Aktif'
    ],

    [
        'name' => 'Doni',
        'email' => 'doni@example.com',
        'phone' => '081244332211',
        'joined' => '2026-07-17',
        'status' => 'Aktif'
    ]

];


$page =
    (int) ($_GET['page'] ?? 1);

if ($page < 1) {
    $page = 1;
}


$perPage = 8;

$total =
    count($users);

$totalPages =
    (int) ceil($total / $perPage);


if ($page > $totalPages) {
    $page = $totalPages;
}


$offset =
    ($page - 1) * $perPage;

$currentUsers =
    array_slice(
        $users,
        $offset,
        $perPage
    );


$pageTitle =
    'Pengguna';

include __DIR__ . '/includes/header.php';

?>


<div class="page-head">

    <div>

        <h2>
            Pengguna
        </h2>

        <p>
            Data pelanggan yang terdaftar di Oceango.
        </p>

    </div>

</div>


<div class="card">

    <div class="table-wrap">

        <table class="table">

            <thead>

                <tr>

                    <th>
                        NAMA
                    </th>

                    <th>
                        EMAIL
                    </th>

                    <th>
                        NO. TELEPON
                    </th>

                    <th>
                        TERDAFTAR
                    </th>

                    <th>
                        STATUS
                    </th>

                </tr>

            </thead>


            <tbody>


            <?php foreach ($currentUsers as $user): ?>


                <tr>

                    <td>

                        <div class="name">

                            <div class="mini-avatar">

                                <?= e(
                                    strtoupper(
                                        substr(
                                            $user['name'],
                                            0,
                                            1
                                        )
                                    )
                                ) ?>

                            </div>


                            <b>
                                <?= e($user['name']) ?>
                            </b>

                        </div>

                    </td>


                    <td>
                        <?= e($user['email']) ?>
                    </td>


                    <td>
                        <?= e($user['phone']) ?>
                    </td>


                    <td>
                        <?= tanggal($user['joined']) ?>
                    </td>


                    <td>

                        <span
                            class="status <?= $user['status'] === 'Aktif'
                                ? 'success'
                                : 'danger'
                            ?>"
                        >
                            <?= e($user['status']) ?>
                        </span>

                    </td>

                </tr>


            <?php endforeach; ?>


            </tbody>

        </table>

    </div>

</div>


<div class="pagination">


    <?php for (
        $i = 1;
        $i <= $totalPages;
        $i++
    ): ?>


        <a
            href="pengguna.php?page=<?= $i ?>"
            class="<?= $i === $page ? 'active' : '' ?>"
        >
            <?= $i ?>
        </a>


    <?php endfor; ?>


</div>


<?php

include __DIR__ . '/includes/footer.php';

?>