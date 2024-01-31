<header class="header text-center">
    <h1 class="blog-name pt-lg-4 mb-0">
        <a href="profile.php">
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
                    <a class="nav-link" href="create_post.php"><i class="fas fa-pen fa-fw mr-2"></i>Write Post</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="manage_post.php">
                        <i class="fa-solid fa-pen-to-square fa-fw mr-2"></i>Manage Posts
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="profile.php">
                        <i class="fa-solid fa-pen-to-square fa-fw mr-2"></i>Edit Profile
                    </a>
                </li>
            </ul> <!--- navigation-section ---->

            <div class="my-2 my-md-3">
                <a class="btn btn-primary" href="../pages/logout.php">Log out</a>
            </div>
        </div>
    </nav>
</header>