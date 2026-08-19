document.addEventListener(
    "DOMContentLoaded",
    function () {

        const sidebar =
            document.querySelector(
                ".admin-sidebar"
            );

        const mobileMenu =
            document.getElementById(
                "mobileMenu"
            );


        if (
            mobileMenu &&
            sidebar
        ) {

            mobileMenu.addEventListener(
                "click",
                function () {

                    sidebar.classList.toggle(
                        "mobile-open"
                    );

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | CLOSE SIDEBAR WHEN CLICK OUTSIDE
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            "click",
            function (event) {

                if (
                    window.innerWidth <= 900 &&
                    sidebar &&
                    mobileMenu &&
                    !sidebar.contains(event.target) &&
                    !mobileMenu.contains(event.target)
                ) {

                    sidebar.classList.remove(
                        "mobile-open"
                    );

                }

            }
        );

    }
);