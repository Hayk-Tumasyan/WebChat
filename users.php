<?php
	session_start();
	require_once __DIR__ . "/php/csrf.php";
	include_once __DIR__ . "/includes/header.php";
	if(!isset($_SESSION['unique_id'])){
		header("location: login.php");
		exit();
	}
?>
<body>
	<div id="page-config" data-csrf="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>" hidden></div>
	<div class="wrapper">
		<section class="users">
			<header>
				<?php
					require_once __DIR__ . "/php/config.php";
					// get current user
					$sql = $conn->query("SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']}");
					if(mysqli_num_rows($sql) > 0){
						$row = mysqli_fetch_assoc($sql);
					}
				?>
				<!-- display current user -->
				<div class="content">
					<img src="php/images/<?php echo $row['img'] ?>">
					<div class="details">
						<span><?php echo $row['fname'] . " " . $row['lname'] ?></span>
						<p><?php if($row['status'] == 1){
							echo "Առցանց";
						} else{
							echo "Անցանց";
						} ?></p>
					</div>
				</div>
				<a href="php/logout.php" class="logout">Դուրս գալ</a>
			</header>
			<div class="search">
				<span class="text">Ընտրեք օգտատեր՝ չատ սկսելու համար</span>
				<input type="text" placeholder="Մուտքագրեք անուն՝ որոնելու համար...">
				<button><i class="fas fa-search"></i></button>
			</div>
			<div class="users-list"></div>
		</section>
	</div>

	<script src="assets/js/users.js" type="text/javascript"></script>

</body>
</html>