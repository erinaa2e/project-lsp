<?php

/*
|--------------------------------------------------------------------------
| CEK SESSION USER
|--------------------------------------------------------------------------
*/

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pageTitle = "Pesan Tiket Kapal";

include "includes/header.php";


/*
|--------------------------------------------------------------------------
| CEK APAKAH USER SUDAH LOGIN
|--------------------------------------------------------------------------
|
| Sistem dibuat fleksibel karena kita belum mengubah sistem login user.
| Kalau salah satu session ini tersedia, user dianggap sudah login.
|
*/

$isLoggedIn = false;

if (
    isset($_SESSION["user_id"]) ||
    isset($_SESSION["user"]) ||
    isset($_SESSION["oceango_user"]) ||
    isset($_SESSION["logged_in"])
) {
    $isLoggedIn = true;
}


/*
|--------------------------------------------------------------------------
| CEK TIKET / BOARDING PASS
|--------------------------------------------------------------------------
*/

$bookingSession = $_SESSION["booking"] ?? [];

$ticketCode =
    $bookingSession["code"]
    ?? $bookingSession["booking_code"]
    ?? $bookingSession["transaction_code"]
    ?? "";

$hasTicket = !empty($ticketCode);

?>

<!-- =========================================================
     HERO
========================================================= -->

<section class="hero">

    <div class="hero-bg"></div>

    <div class="container hero-content">

        <div class="hero-copy">

            <span class="eyebrow">
                PERJALANAN LAUT LEBIH MUDAH
            </span>

            <h1>
                Pesan Tiket Kapal<br>
                <span>Jadi Lebih Mudah.</span>
            </h1>

            <p>
                Temukan jadwal kapal, pilih kursi,
                bayar dengan aman, dan dapatkan
                e-ticket dalam hitungan menit.
            </p>


            <!-- =================================================
                 TOMBOL CARI TIKET UTAMA
            ================================================== -->

            <?php if ($isLoggedIn): ?>

                <a
                    class="btn btn-light"
                    href="search.php"
                >
                    Cari Tiket Sekarang
                    <span>→</span>
                </a>

            <?php else: ?>

                <button
                    type="button"
                    class="btn btn-light"
                    onclick="openLoginModal()"
                >
                    Cari Tiket Sekarang
                    <span>→</span>
                </button>

            <?php endif; ?>


            <?php if ($isLoggedIn && $hasTicket): ?>

                <div class="hero-ticket-action">

                    <a
                        class="btn btn-ticket"
                        href="ticket.php"
                    >
                        🎫 Lihat Tiket / Boarding Pass
                    </a>

                    <small>
                        Tiket:
                        <strong>
                            <?= e($ticketCode) ?>
                        </strong>
                    </small>

                </div>

            <?php endif; ?>


        </div>


        <div class="ship-art">

            <img
                src="assets/img/ship.svg"
                alt="Ilustrasi kapal"
            >

        </div>

    </div>

</section>



<!-- =========================================================
     SEARCH CARD
========================================================= -->

<section class="search-card-wrap">

    <div class="container">

        <form
            class="search-card"
            action="search.php"
            method="get"
            id="homeSearchForm"
        >


            <!-- =================================================
                 ASAL
            ================================================== -->

            <div class="search-field">

                <label>
                    Pelabuhan Asal
                </label>

                <div class="field-input">

                    <span>📍</span>

                    <input
                        id="fromPort"
                        type="text"
                        name="from"
                        value="Surabaya"
                        placeholder="Pilih pelabuhan"
                        autocomplete="off"
                        required
                    >

                </div>

            </div>



            <!-- =================================================
                 SWAP
            ================================================== -->

            <button
                class="swap-btn"
                type="button"
                id="swapPortsBtn"
                title="Tukar pelabuhan"
            >
                ⇄
            </button>



            <!-- =================================================
                 TUJUAN
            ================================================== -->

            <div class="search-field">

                <label>
                    Pelabuhan Tujuan
                </label>

                <div class="field-input">

                    <span>⚓</span>

                    <input
                        id="toPort"
                        type="text"
                        name="to"
                        value="Jakarta"
                        placeholder="Pilih pelabuhan"
                        autocomplete="off"
                        required
                    >

                </div>

            </div>



            <!-- =================================================
                 TANGGAL
            ================================================== -->

            <div class="search-field">

                <label>
                    Tanggal Berangkat
                </label>

                <div class="field-input">

                    <span>📅</span>

                    <input
                        id="departureDate"
                        type="date"
                        name="date"
                        required
                    >

                </div>

            </div>



            <!-- =================================================
                 PENUMPANG
            ================================================== -->

            <div class="search-field compact">

                <label>
                    Penumpang
                </label>

                <div class="field-input">

                    <span>👥</span>

                    <select name="passengers">

                        <option value="1">
                            1 Dewasa
                        </option>

                        <option value="2">
                            2 Dewasa
                        </option>

                        <option value="3">
                            3 Dewasa
                        </option>

                        <option value="4">
                            4 Dewasa
                        </option>

                        <option value="5">
                            5 Dewasa
                        </option>

                        <option value="6">
                            6 Dewasa
                        </option>

                        <option value="7">
                            7 Dewasa
                        </option>

                        <option value="8">
                            8 Dewasa
                        </option>

                        <option value="9">
                            9 Dewasa
                        </option>

                        <option value="10">
                            10 Dewasa
                        </option>

                    </select>

                </div>

            </div>



            <!-- =================================================
                 KELAS
            ================================================== -->

            <div class="search-field compact">

                <label>
                    Kelas
                </label>

                <div class="field-input">

                    <span>💺</span>

                    <select name="class">

                        <option value="">
                            Semua Kelas
                        </option>

                        <option value="Ekonomi">
                            Ekonomi
                        </option>

                        <option value="Bisnis">
                            Bisnis
                        </option>

                        <option value="VIP">
                            VIP
                        </option>

                    </select>

                </div>

            </div>



            <!-- =================================================
                 BUTTON CARI TIKET
            ================================================== -->

            <button
                class="btn btn-primary search-submit"
                type="submit"
            >
                Cari Tiket
            </button>


        </form>

    </div>

</section>



<!-- =========================================================
     FEATURES
========================================================= -->

<section class="section">

    <div class="container">

        <div class="section-heading">

            <div>

                <span class="eyebrow dark">
                    KENAPA OCEANGO?
                </span>

                <h2>
                    Semua yang kamu butuhkan<br>
                    untuk perjalanan laut.
                </h2>

            </div>

        </div>


        <div class="feature-grid">


            <article class="feature-card">

                <div class="feature-icon">
                    🔎
                </div>

                <h3>
                    Pencarian Mudah
                </h3>

                <p>
                    Bandingkan jadwal, kelas,
                    harga, dan ketersediaan kapal
                    dengan cepat.
                </p>

            </article>



            <article class="feature-card">

                <div class="feature-icon">
                    💺
                </div>

                <h3>
                    Pilih Kursi
                </h3>

                <p>
                    Pilih posisi kursi yang kamu
                    inginkan sebelum melanjutkan
                    pembayaran.
                </p>

            </article>



            <article class="feature-card">

                <div class="feature-icon">
                    🔒
                </div>

                <h3>
                    Pembayaran Aman
                </h3>

                <p>
                    Proses pembayaran dibuat
                    sederhana dan nyaman untuk
                    setiap pengguna.
                </p>

            </article>



            <article class="feature-card">

                <div class="feature-icon">
                    🎫
                </div>

                <h3>
                    E-Ticket Instan
                </h3>

                <p>
                    Tiket langsung tersedia setelah
                    pembayaran berhasil dan siap
                    digunakan.
                </p>

            </article>


        </div>

    </div>

</section>



<!-- =========================================================
     PROMO
========================================================= -->

<section
    class="promo-section"
    id="promo"
>

    <div class="container promo">

        <div>

            <span class="eyebrow">
                PROMO SPESIAL
            </span>

            <h2>
                Mulai perjalananmu<br>
                hari ini.
            </h2>

            <p>
                Dapatkan pengalaman booking kapal
                yang praktis tanpa antre panjang.
            </p>


            <?php if ($isLoggedIn): ?>

                <a
                    href="search.php"
                    class="btn btn-light"
                >
                    Lihat Jadwal Kapal →
                </a>

            <?php else: ?>

                <button
                    type="button"
                    class="btn btn-light"
                    onclick="openLoginModal()"
                >
                    Lihat Jadwal Kapal →
                </button>

            <?php endif; ?>


        </div>


        <div class="promo-circle">
            ⚓
        </div>

    </div>

</section>



<!-- =========================================================
     LOGIN / DAFTAR MODAL
========================================================= -->

<div
    id="loginModal"
    class="login-modal"
    aria-hidden="true"
>

    <div
        class="login-modal-overlay"
        onclick="closeLoginModal()"
    ></div>


    <div class="login-modal-box">

        <button
            type="button"
            class="login-modal-close"
            onclick="closeLoginModal()"
            aria-label="Tutup"
        >
            ×
        </button>


        <div class="login-modal-icon">
            🔐
        </div>


        <h2>
            Login untuk Melanjutkan
        </h2>


        <p>
            Silakan login atau daftar terlebih dahulu
            untuk mencari dan memesan tiket kapal.
        </p>


        <div class="login-modal-actions">

            <a
                href="login.php?redirect=search.php"
                class="login-modal-login"
            >
                Login
            </a>


            <a
                href="register.php"
                class="login-modal-register"
            >
                Daftar
            </a>

        </div>


        <button
            type="button"
            class="login-modal-cancel"
            onclick="closeLoginModal()"
        >
            Nanti saja
        </button>

    </div>

</div>



<!-- =========================================================
     SEARCH JAVASCRIPT
========================================================= -->

<script>

document.addEventListener(
    "DOMContentLoaded",
    function () {


        /*
        |--------------------------------------------------------------------------
        | SET TANGGAL MINIMUM = HARI INI
        |--------------------------------------------------------------------------
        */

        const dateInput =
            document.getElementById(
                "departureDate"
            );


        if (dateInput) {

            const today =
                new Date();


            const year =
                today.getFullYear();


            const month =
                String(
                    today.getMonth() + 1
                ).padStart(2, "0");


            const day =
                String(
                    today.getDate()
                ).padStart(2, "0");


            const todayString =
                `${year}-${month}-${day}`;


            dateInput.min =
                todayString;


            if (!dateInput.value) {

                dateInput.value =
                    todayString;

            }

        }



        /*
        |--------------------------------------------------------------------------
        | TUKAR PELABUHAN
        |--------------------------------------------------------------------------
        */

        const swapButton =
            document.getElementById(
                "swapPortsBtn"
            );


        if (swapButton) {

            swapButton.addEventListener(
                "click",
                function () {

                    const from =
                        document.getElementById(
                            "fromPort"
                        );


                    const to =
                        document.getElementById(
                            "toPort"
                        );


                    const temporary =
                        from.value;


                    from.value =
                        to.value;


                    to.value =
                        temporary;


                    swapButton.classList.add(
                        "swapped"
                    );


                    setTimeout(
                        function () {

                            swapButton.classList.remove(
                                "swapped"
                            );

                        },
                        250
                    );

                }
            );

        }



        /*
        |--------------------------------------------------------------------------
        | VALIDASI PENCARIAN
        |--------------------------------------------------------------------------
        */

        const searchForm =
            document.getElementById(
                "homeSearchForm"
            );


        if (searchForm) {

            searchForm.addEventListener(
                "submit",
                function (event) {

                    const from =
                        document.getElementById(
                            "fromPort"
                        ).value.trim();


                    const to =
                        document.getElementById(
                            "toPort"
                        ).value.trim();


                    <?php if (!$isLoggedIn): ?>

                        event.preventDefault();

                        openLoginModal();

                        return;

                    <?php endif; ?>


                    if (
                        from.toLowerCase()
                        ===
                        to.toLowerCase()
                    ) {

                        event.preventDefault();


                        alert(
                            "Pelabuhan asal dan tujuan tidak boleh sama."
                        );


                        return;

                    }

                }
            );

        }

    }
);



/*
|--------------------------------------------------------------------------
| BUKA MODAL LOGIN
|--------------------------------------------------------------------------
*/

function openLoginModal() {

    const modal =
        document.getElementById(
            "loginModal"
        );


    if (!modal) {
        return;
    }


    modal.classList.add(
        "show"
    );


    modal.setAttribute(
        "aria-hidden",
        "false"
    );


    document.body.classList.add(
        "modal-open"
    );

}



/*
|--------------------------------------------------------------------------
| TUTUP MODAL LOGIN
|--------------------------------------------------------------------------
*/

function closeLoginModal() {

    const modal =
        document.getElementById(
            "loginModal"
        );


    if (!modal) {
        return;
    }


    modal.classList.remove(
        "show"
    );


    modal.setAttribute(
        "aria-hidden",
        "true"
    );


    document.body.classList.remove(
        "modal-open"
    );

}



/*
|--------------------------------------------------------------------------
| TOMBOL ESC UNTUK MENUTUP MODAL
|--------------------------------------------------------------------------
*/

document.addEventListener(
    "keydown",
    function (event) {

        if (
            event.key === "Escape"
        ) {

            closeLoginModal();

        }

    }
);

</script>



<!-- =========================================================
     LOGIN MODAL CSS
========================================================= -->

<style>

/*
|--------------------------------------------------------------------------
| TOMBOL TIKET / BOARDING PASS
|--------------------------------------------------------------------------
*/

.hero-ticket-action {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 7px;
    margin-top: 14px;
}

.btn-ticket {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 46px;
    padding: 0 18px;
    border-radius: 12px;
    color: #ffffff;
    background: linear-gradient(135deg, #063b5c, #087eae);
    text-decoration: none;
    font-weight: 700;
    box-shadow: 0 8px 22px rgba(0, 80, 120, .20);
    transition: transform .2s ease, box-shadow .2s ease;
}

.btn-ticket:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 28px rgba(0, 80, 120, .28);
}

.hero-ticket-action small {
    color: rgba(255, 255, 255, .85);
    font-size: 12px;
}

.hero-ticket-action small strong {
    color: #ffffff;
}

@media (max-width: 600px) {
    .hero-ticket-action {
        align-items: stretch;
    }

    .btn-ticket {
        width: 100%;
    }

    .hero-ticket-action small {
        text-align: center;
    }
}


/*
|--------------------------------------------------------------------------
| MODAL
|--------------------------------------------------------------------------
*/

.login-modal {

    position: fixed;

    inset: 0;

    z-index: 99999;

    display: flex;

    align-items: center;

    justify-content: center;

    padding: 20px;

    visibility: hidden;

    opacity: 0;

    transition:
        opacity .25s ease,
        visibility .25s ease;

}


.login-modal.show {

    visibility: visible;

    opacity: 1;

}


.login-modal-overlay {

    position: absolute;

    inset: 0;

    background:
        rgba(5, 25, 40, .65);

    backdrop-filter:
        blur(5px);

}


.login-modal-box {

    position: relative;

    z-index: 2;

    width: 100%;

    max-width: 430px;

    background: #ffffff;

    border-radius: 22px;

    padding: 38px 34px 30px;

    text-align: center;

    box-shadow:
        0 25px 70px
        rgba(0, 0, 0, .25);

    transform:
        translateY(20px)
        scale(.97);

    transition:
        transform .25s ease;

}


.login-modal.show
.login-modal-box {

    transform:
        translateY(0)
        scale(1);

}


.login-modal-icon {

    width: 68px;

    height: 68px;

    margin: 0 auto 18px;

    border-radius: 18px;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 30px;

    background:
        linear-gradient(
            135deg,
            #e9f8ff,
            #d9f1ff
        );

}


.login-modal-box h2 {

    margin: 0 0 10px;

    font-size: 25px;

    color: #062f49;

}


.login-modal-box p {

    margin: 0 auto 26px;

    max-width: 340px;

    line-height: 1.6;

    color: #64748b;

    font-size: 14px;

}


.login-modal-actions {

    display: grid;

    grid-template-columns: 1fr 1fr;

    gap: 12px;

}


.login-modal-login,
.login-modal-register {

    min-height: 48px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 12px;

    text-decoration: none;

    font-weight: 700;

    transition:
        transform .2s ease,
        box-shadow .2s ease;

}


.login-modal-login {

    color: #ffffff;

    background:
        linear-gradient(
            135deg,
            #006b99,
            #008fc5
        );

    box-shadow:
        0 8px 20px
        rgba(0, 119, 170, .22);

}


.login-modal-register {

    color: #075985;

    background: #e8f7fc;

}


.login-modal-login:hover,
.login-modal-register:hover {

    transform: translateY(-2px);

}


.login-modal-cancel {

    border: 0;

    background: transparent;

    margin-top: 18px;

    color: #64748b;

    cursor: pointer;

    font-size: 14px;

}


.login-modal-cancel:hover {

    color: #0f172a;

}


.login-modal-close {

    position: absolute;

    top: 15px;

    right: 17px;

    width: 35px;

    height: 35px;

    border: 0;

    border-radius: 50%;

    background: #f1f5f9;

    color: #475569;

    font-size: 24px;

    line-height: 1;

    cursor: pointer;

}


.login-modal-close:hover {

    background: #e2e8f0;

}


body.modal-open {

    overflow: hidden;

}


@media (max-width: 480px) {

    .login-modal-box {

        padding:
            34px 22px 25px;

        border-radius: 18px;

    }


    .login-modal-actions {

        grid-template-columns: 1fr;

    }

}

</style>



<?php

include "includes/footer.php";

?>