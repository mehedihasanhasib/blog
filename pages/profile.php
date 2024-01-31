<?php
session_start();
if (!$_SESSION["login"]) {
    header("Location: ../index.php");
}
$usr_id = $_SESSION["user_id"];
include "dbConnect.php";
$query = "SELECT * from users WHERE id = '$usr_id';";
$result = $connection->query($query)->fetch_assoc();
$err_message = "";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Profile | Blog Website</title>

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

    <?php
    // checking name update
    if (isset($_POST["first_name"]) && isset($_POST["last_name"])) {


        // query to update name
        $update_query = "UPDATE users SET first_name='{$_POST["first_name"]}', last_name='{$_POST["last_name"]}' WHERE id='$usr_id';";

        // querying ...
        if ($connection->query($update_query)) {
            $err_message = "";
            header("Location: home.php");
        } else {
            $err_message = "Profile update unsuccessfull";
            header("Location: profile.php");
        }
    }


    // checking password update
    if (isset($_POST["password"])) {

        if (strlen($_POST["password"]) < 4) {
            $err_message = "Password is too short, must have 4 characters";
        } else {

            // hashing passwords
            $options = [
                'cost' => 12,
            ];
            $pwd = password_hash($_POST["password"], PASSWORD_BCRYPT, $options);

            $update_query = "UPDATE users SET pwd='$pwd' WHERE id='$usr_id';";

            // querying ...
            if ($connection->query($update_query)) {
                $err_message = "";
                header("Location: home.php");
            } else {
                $err_message = "Password update unsuccessfull";
            }
        }
    }

    // checking email
    if (isset($_POST["email"])) {

        $update_query = "UPDATE users SET email='{$_POST["email"]}' WHERE id='$usr_id';";

        // querying ...
        if ($connection->query($update_query)) {
            $err_message = "";
            header("Location: home.php");
        } else {
            $err_message = "Email update unsuccessfull";
            header("Location: profile.php");
        }
    }


    // checking profile picture update
    if (isset($_POST["profile_picture_update"])) {

        $target_file = "../assets/images/profile_picture/" . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $uploadOK = 1;

        if ($imageFileType !== "jpg" && $imageFileType !== "jpeg" && $imageFileType !== "png") {
            $err_message = ' * Only jpg, jpeg and png file is allowed to upload';
            $uploadOK = 0;
        }

        // check image size
        else if ($_FILES["image"]["size"] > 2024000) {
            $err_message = " * File is too large, maximum 2 MB file is allowed";
            $uploadOK = 0;
        }

        // uploading image
        if ($uploadOK) {
            move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
            $update_query = "UPDATE users SET profile_picture='{$target_file}' WHERE id='$usr_id';";

            if ($connection->query($update_query)) {
                $err_message = "";
                header("Location: home.php");
            } else {
                $err_message = "Profile picture update unsuccessfull";
            }
        }
    }
    ?>


    <div class="main-wrapper">

        <section class="cta-section theme-bg-light py-5">
            <div class="text-center">
                <h2 class="heading">Edit Profile</h2>
            </div><!--//container-->
        </section>


        <div class="container">

            <!-- showing error message -->
            <h5 style="color: red; text-align:center;"><?php echo $err_message; ?></h5>

            <!-- name update -->
            <form action="profile.php" method="POST">
                <div>
                    <label for="first_name">First Name:</label>
                    <input type="text" name="first_name" value="<?php echo $result["first_name"]; ?>">
                </div>
                <div>
                    <label for="last_name">Last Name:</label>
                    <input type="text" name="last_name" value="<?php echo $result["last_name"]; ?>">
                </div>

                <input type="submit" value="Update">
            </form>

            <!-- email update -->
            <form action="profile.php" method="post">
                <div>
                    <label for="password">New Email:</label>
                    <input type="email" name="email" value="<?php echo $result["email"] ?>">
                </div>
                <input type="submit" value="Update">
            </form>


            <!-- password update -->
            <form action="profile.php" method="post">
                <div>
                    <label for="password">New Password:</label>
                    <input type="password" name="password" value="<?php echo str_split($result["pwd"], 6)[0] ?>">
                </div>
                <input type="submit" value="Update">
            </form>


            <!-- displaying profile picture -->
            <div style="padding-left: 190px;">
                <img src="<?php echo $result["profile_picture"]; ?>" width="240" style="border-radius: 5px;">
            </div>


            <!-- profile picture update -->
            <form action="profile.php" method="post" enctype="multipart/form-data">
                <div>
                    <label for="image">Choose New Profile Picture:</label>
                    <input type="file" name="image" ?>
                </div>
                <input type="submit" value="Update" name="profile_picture_update">
            </form>

        </div>





    </div><!--//main-wrapper-->

    <!-- Javascript -->
    <script src="assets/plugins/jquery-3.3.1.min.js"></script>
    <script src="assets/plugins/popper.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>

</body>

</html>