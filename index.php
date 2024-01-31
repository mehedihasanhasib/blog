<?php
session_start();
$_SESSION["login"] = false;
$err_msg = "";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/index.css">
    <title>Log in</title>
</head>

<body>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $email = $_POST["email"];
        $pwd = $_POST["password"];

        include "./pages/dbConnect.php";
        // qureying data from users table
        $sql = "SELECT email, pwd, id, last_name FROM users WHERE email = '$email';";
        $results = $connection->query($sql)->fetch_assoc();

        if (empty($email) || empty($pwd)) {
            // email verification
            $err_msg = "Invalid email or password";
        } else if ($results == null) {
            // check if email or password input is null
            $err_msg = "Email id not found! Enter a valid email";
        } else if ($email == $results["email"] && password_verify($pwd, $results["pwd"])) {
            // password verification
            $_SESSION["login"] = true;
            $_SESSION["user_id"] = $results["id"]; // storing users table id in session variable user_id
            header("Location: ./pages/home.php");
        } else {
            $err_msg = "Invalid email or password";
        }
    }

    ?>

    <div class="container">
        <div>
            <h1>Blog Admin Panel</h1>
            <form action="index.php" method="POST">
                <input type="email" name="email" placeholder="Email">
                <input type="password" name="password" placeholder="Password">
                <div class="login-button">
                    <button type="submit">Log in</button>
                </div>
            </form>

            <div class="links">
                <p style="color: red;">
                    <?php echo $err_msg; ?>
                </p>
                <p>Don't have an account?</p>
                <a href="./pages/signup.php">Create account</a>
            </div>
        </div>
    </div>


</body>

</html>