<?php
    session_start();

    // Check if user is logged in
    if (!isset($_SESSION['user'])) {
        // Redirect to login page
        header('Location: login.php');
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">

<!-- head  -->   
<?php include ('utils/head.php') ?>
<!-- head  -->

<body class="container-fluid p-0 font-custom">
    <main class="m-0 d-none d-lg-flex">


        <?php require_once (__DIR__.'/components/sidebar.php') ?>


        <div id="content-area" class="flex-grow-1 p-4">
            <!-- Page content will be loaded here -->
        </div>

        
    </main>

    <main class="d-flex align-items-center justify-content-center d-lg-none">
        <h1>Not Found</h1>
    </main>

</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        
        $('#collapseBtn').on('click', function() {
            // toggle content visibility
            $('.content').toggleClass('d-none d-block');

            $(this).find('.arrow-icon').toggleClass('rotate');
        });

        $('#collapseBtnAdmin').on('click', function() {
            // toggle content visibility
            $('.content').toggleClass('d-none d-block');
            $(this).find('.arrow-icon').toggleClass('rotate');
        });

        function loadPage(url) {
            $("#content-area").load(url);
        }

        // Load default page
        loadPage("pages/admin/categories.php");

        // Handle sidebar link clicks
        $(document).on("click", ".nav-link-ajax", function (e) {
            e.preventDefault();
            const url = $(this).attr("href");
            loadPage(url);

            // Optional: highlight active link
            $(".nav-link-ajax").removeClass("active");
            $(this).addClass("active");
        });
    });
</script>
</html>