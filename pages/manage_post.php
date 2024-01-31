<?php
session_start();
if (!$_SESSION["login"]) {
    header("Location: ../index.php");
}
$usr_id = $_SESSION["user_id"];
include "dbConnect.php";
$query = "SELECT * from blogs WHERE user_id = '$usr_id';";
$result = $connection->query($query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Home | Blog Website</title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Blog Template">
    <meta name="author" content="Xiaoying Riley at 3rd Wave Media">

    <!-- FontAwesome JS-->
    <script defer src="https://use.fontawesome.com/releases/v5.7.1/js/all.js" integrity="sha384-eVEQC9zshBn0rFj4+TU78eNA19HMNigMviK/PU/FFjLXqa/GKPgX58rvt5Z8PLs7" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/aa842bad0a.js" crossorigin="anonymous"></script>

    <!-- Theme CSS -->
    <link id="theme-style" rel="stylesheet" href="../assets/css/theme-1.css">

</head>

<body>

    <?php include "header.php"; ?>

    <div class="main-wrapper">

        <section class="cta-section theme-bg-light py-5">
            <div class="container text-center">
                <h2 class="heading">Manage Posts</h2>
            </div><!--//container-->
        </section>

        <section class="blog-list px-3 py-5 p-md-5">
            <div class="row">

                <?php
                while ($row = $result->fetch_assoc()) {
                    $words = str_split($row["content"], 100);
                    echo "
                    <div class='m-auto pb-4'>
                        <div class='card' style='width: 18rem; height:27rem;'>
                            <img src='{$row['images']}' class='card-img-top h-50' alt='image'>
                            <div class='card-body'>
                                <h5 class='card-title bold'>{$row['title']}</h5>
                                <p class='card-text'>$words[0] ...</p>
                            </div>
                            <a href='#' class='btn btn-primary'>Edit</a>
                        </div>
                    </div>";
                }
                ?>

            </div>
        </section>


    </div><!--//main-wrapper-->

    <!-- Javascript -->
    <script src="assets/plugins/jquery-3.3.1.min.js"></script>
    <script src="assets/plugins/popper.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>

</body>

</html>