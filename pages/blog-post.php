<?php
session_start();
if (!$_SESSION["login"]) {
    header("Location: ../index.php");
}
$usr_id = $_SESSION["user_id"];
include "dbConnect.php";
// querying to get data from blogs table of logged in user
$query = "SELECT * from blogs WHERE id = {$_GET["post_id"]};";
$result = $connection->query($query);
$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo $row["title"]; ?></title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Blog Template">
    <meta name="author" content="Xiaoying Riley at 3rd Wave Media">

    <!-- FontAwesome JS-->
    <script defer src="https://use.fontawesome.com/releases/v5.7.1/js/all.js" integrity="sha384-eVEQC9zshBn0rFj4+TU78eNA19HMNigMviK/PU/FFjLXqa/GKPgX58rvt5Z8PLs7" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/aa842bad0a.js" crossorigin="anonymous"></script>


    <!-- Plugin CSS -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.14.2/styles/monokai-sublime.min.css">

    <!-- Theme CSS -->
    <link id="theme-style" rel="stylesheet" href="../assets/css/theme-1.css">


</head>

<body>
    <header class="header text-center">
        <h1 class="blog-name pt-lg-4 mb-0">
            <a href="index.php">
                <!--- php scripts to show username here --->
                <?php
                // querying names from users table of logged in user; 
                $name_query = "SELECT first_name, last_name, profile_picture FROM users WHERE id = '$usr_id';";
                $name_result = $connection->query($name_query)->fetch_assoc();

                echo $name_result["first_name"] . "<br>" . $name_result["last_name"];
                ?>
            </a>
        </h1>

        <nav class="navbar navbar-expand-lg navbar-dark">

            <div id="navigation" class="collapse navbar-collapse flex-column">
                <div class="profile-section pt-3 pt-lg-0">
                    <!---- php scripts to fetch profile pic --->
                    <img class="profile-image mb-3 rounded mx-auto" src="<?php echo $name_result["profile_picture"]; ?>" alt="image">
                    <hr>
                </div><!--//profile-section-->

                <ul class="navbar-nav flex-column text-left">
                    <li class="nav-item">
                        <a class="nav-link" href="home.php"><i class="fas fa-home fa-fw mr-2"></i>Home <span class="sr-only"></span></a>
                    </li>
                    <!-- <li class="nav-item">
                    <a class="nav-link" href="blog-post.php"><i class="fas fa-bookmark fa-fw mr-2"></i>Post</a>
                </li> -->
                    <li class="nav-item">
                        <a class="nav-link" href="create_post.php"><i class="fas fa-pen fa-fw mr-2"></i>Create Post</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_post.php">
                            <i class="fa-solid fa-pen-to-square fa-fw mr-2"></i>Manage Posts
                        </a>
                    </li>
                </ul> <!--- navigation-section ---->

                <div class="my-2 my-md-3">
                    <a class="btn btn-primary" href="../pages/logout.php" target="_blank">Log out</a>
                </div>
            </div>
        </nav>
    </header>

    <div class="main-wrapper">

        <article class="blog-post px-3 py-5 p-md-5">
            <div class="container">
                <header class="blog-post-header">
                    <h2 class="title mb-2"><?php echo $row["title"]; ?></h2>
                </header>

                <div class="blog-post-body">
                    <figure class="blog-banner">
                        <a href="https://made4dev.com">
                            <img class="img-fluid" src="<?php echo $row["images"]; ?>" alt="image">
                        </a>
                    </figure>
                    <p><?php echo $row["content"]; ?></p>
                </div><!--//container-->
        </article>




    </div><!--//main-wrapper-->






    <!-- Javascript -->
    <script src="assets/plugins/jquery-3.3.1.min.js"></script>
    <script src="assets/plugins/popper.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>

    <!-- Page Specific JS -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.14.2/highlight.min.js"></script>

    <!-- Custom JS -->
    <script src="assets/js/blog.js"></script>

    <!-- Style Switcher (REMOVE ON YOUR PRODUCTION SITE) -->
    <script src="assets/js/demo/style-switcher.js"></script>


</body>

</html>