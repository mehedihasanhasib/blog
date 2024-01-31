<?php
session_start();
if (!$_SESSION["login"]) {
    header("Location: ../index.php");
}
$usr_id = $_SESSION["user_id"];
include "dbConnect.php";
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
    <link id="theme-style" rel="stylesheet" href="../assets/css/styles.css">

</head>

<body>

    <?php include "header.php"; ?>

    <div class="main-wrapper">

        <section class="cta-section theme-bg-light py-5">
            <div class="text-center">
                <h2 class="heading">Write a new post</h2>
            </div><!--//container-->
        </section>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            include "dbConnect.php";

            // preparing profile picture's path
            $target_file = "../assets/images/blog/" . basename($_FILES["image"]["name"]);

            move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

            // preparing statment to insert user info into database
            $statment = $connection->prepare("INSERT INTO blogs (title, content, user_id, images) VALUES(?, ?, ?, ?)");

            $title = $_POST["title"];
            $content = $_POST["content"];
            $user_id = $_SESSION["user_id"];
            $images = $target_file;

            $statment->bind_param("ssss", $title, $content, $user_id, $images);

            if ($statment->execute()) {
                header("Location: home.php");
            } else {
                echo $connection->error;
            }
        }
        ?>


        <div class="container">

            <form action="create_post.php" method="post" enctype="multipart/form-data">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required>

                <label for="image"></label>
                <input type="file" name="image">

                <label for="content">Content:</label>
                <textarea id="content" name="content" rows="8" required></textarea>

                <input type="submit" value="Post">
            </form>


        </div>


    </div><!--//main-wrapper-->

    <!-- Javascript -->
    <script src="assets/plugins/jquery-3.3.1.min.js"></script>
    <script src="assets/plugins/popper.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>

</body>

</html>