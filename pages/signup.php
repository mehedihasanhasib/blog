<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/signup.css">
    <title>Sign up</title>
</head>

<body>

    <?php

    // error messages
    $firtName_err_msg = $lastName_err_msg = $email_err_msg = $password_err_msg = $image_err_msg = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {


        include "dbConnect.php";

        // preparing profile picture's path
        $target_file = "../assets/images/profile_picture/" . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $uploadOK = 1;
        // preparing statment to insert user info into database
        $statment = $connection->prepare("INSERT INTO users (first_name, last_name, email, profile_picture, pwd) VALUES(?, ?, ?, ?, ?)");
        $email_query = "SELECT email FROM users WHERE email = '{$_POST["email"]}';";
        $email = isset($connection->query($email_query)->fetch_assoc()["email"]) ? true : false;

        //checking if first_name is empty
        if (empty($_POST["first_name"])) {
            $firtName_err_msg = " * First Name must not empty";
            $uploadOK = 0;
        }

        // checking if last_name is empty
        else if (empty($_POST["last_name"])) {
            $lastName_err_msg = " * Last Name must not empty";
            $uploadOK = 0;
        }

        // checking if email is empty
        else if (empty($_POST["email"])) {
            $email_err_msg = "Email can not empty";
            $uploadOK = 0;
        }

        // checking email validity
        else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $email_err_msg = " * Enter a valid email address";
            $uploadOK = 0;
        }

        // cheching if email is already used
        else if ($email) {
            $email_err_msg = " * Email id is already used";
            $uploadOK = 0;
        }

        // checking if password is empty
        else if (empty($_POST["password"])) {
            $password_err_msg = "Password must not empty";
            $uploadOK = 0;
        }

        // checking password lenght
        else if (strlen($_POST["password"]) < 4) {
            $password_err_msg = " * Password must contain at least 4 characters";
            $uploadOK = 0;
        }

        // checking the profile picture image type
        else if ($imageFileType !== "jpg" && $imageFileType !== "jpeg" && $imageFileType !== "png") {
            $image_err_msg = ' * Only jpg, jpeg and png file is allowed to upload';
            $uploadOK = 0;
        }

        // check image size
        else if ($_FILES["image"]["size"] > 2024000) {
            $image_err_msg = " * File is too large, maximum 2 MB file is allowed";
            $uploadOK = 0;
        }

        // if all the verification is ok then do the following
        else {
            echo $_FILES["image"];
            if ($uploadOK) {
                move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

                $first_name = $_POST["first_name"];
                $last_name = $_POST["last_name"];
                $email = $_POST["email"];
                $profile_picture = $target_file;
                $options = [
                    'cost' => 12,
                ];
                $pwd = password_hash($_POST["password"], PASSWORD_BCRYPT, $options);

                $statment->bind_param("sssss", $first_name, $last_name, $email, $profile_picture, $pwd);

                if ($statment->execute()) {
                    header("Location: ../index.php");
                } else {
                    echo $connection->error;
                }
            }
        }
    }
    ?>

    <div class="container">
        <div>
            <h1>Sign up</h1>
            <form action="signup.php" method="POST" enctype="multipart/form-data">

                <input type="text" name="first_name" placeholder="First Name" value="<?= $_POST['first_name'] ?? ''; ?>">
                <span class="err-msg"><?php echo $firtName_err_msg; ?></span>

                <input type="text" name="last_name" placeholder="Last Name" value="<?= $_POST['last_name'] ?? ''; ?>">
                <span class="err-msg"><?php echo $lastName_err_msg; ?></span>

                <input type="text" name="email" placeholder="Email" value="<?= $_POST['email'] ?? ''; ?>">
                <span class="err-msg"><?php echo $email_err_msg; ?></span>

                <input type="password" name="password" placeholder="Password">
                <span class="err-msg"><?php echo $password_err_msg; ?></span>

                <div style="display:flex; flex-direction:column; margin-top: 10px; padding:0;">
                    <label for="image">Profile Picture:</label>
                    <input style="border: none; padding:0;" type="file" name="image" value="<?= $_FILES['image'] ?? null; ?>">
                </div>
                <span class="err-msg"><?php echo $image_err_msg; ?></span>
                <button type="submit">Sign up</button>

                <div class="links">
                    <p>Have an account?</p>
                    <a href="../index.php">Log in</a>
                </div>
            </form>
        </div>
    </div>

</body>

</html>