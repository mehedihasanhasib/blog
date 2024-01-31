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

</head>

<body>

	<?php include "header.php"; ?>

	<div class="main-wrapper">

		<section class="cta-section theme-bg-light py-5">
			<div class="container text-center">
				<h2 class="heading">Welcome To My Blog</h2>
			</div><!--//container-->
		</section>

		<section class="blog-list px-3 py-5 p-md-5">
			<div class="container">

				<?php

				include "../pages/dbConnect.php";

				// querying to get data from blogs table of logged in user
				$query = "SELECT * from blogs WHERE user_id = '$usr_id';";

				$result = $connection->query($query);

				while ($row = $result->fetch_assoc()) {

					$words = str_split($row["content"], 190);
					echo "
                <div class='item mb-5'>
					<div class='media'>
						<img class='mr-3 img-fluid post-thumb d-none d-md-flex' src='{$row['images']}' alt='image'>

						<div class='media-body'>
							<h3 class='title mb-1'>
								<a href='blog-post.php?post_id={$row["id"]}'>{$row['title']}</a>
							</h3>

							<div class='intro'>
								{$words[0]}.....
								<a class='more-link' href='blog-post.php?post_id={$row["id"]}'>Read more &rarr;</a>
							</div>
							<input type='hidden'>
						</div>
					</div>
            	</div>";
				}

				?>


				<!-- <nav class="blog-nav nav nav-justified my-5">
					<a class="nav-link-prev nav-item nav-link d-none rounded-left" href="#">Previous<i class="arrow-prev fas fa-long-arrow-alt-left"></i></a>
					<a class="nav-link-next nav-item nav-link rounded" href="blog-list.php">Next<i class="arrow-next fas fa-long-arrow-alt-right"></i></a>
				</nav> -->

			</div>
		</section>

	</div><!--//main-wrapper-->

	<!-- Javascript -->
	<script src="assets/plugins/jquery-3.3.1.min.js"></script>
	<script src="assets/plugins/popper.min.js"></script>
	<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>

</body>

</html>