        </section>

    </main>

</div>


<script>

function toggleSidebar()
{
    const sidebar =
        document.getElementById('sidebar');

    sidebar.classList.toggle('show');
}


document
    .querySelectorAll('.sidebar a')
    .forEach(function(link)
    {
        link.addEventListener(
            'click',
            function()
            {
                document
                    .getElementById('sidebar')
                    .classList
                    .remove('show');
            }
        );
    });

</script>

</body>

</html>