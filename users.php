<?php
	session_start();
	include_once "header.php";
	if(!isset($_SESSION['unique_id'])){
		header("location: login.php");
		exit();
	}
?>
<body>
	<div class="wrapper">
		<section class="users">
			<header>
				<?php
					include_once "php/config.php";
					$sql = $conn->query("SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']}");
					if(mysqli_num_rows($sql) > 0){
						$row = mysqli_fetch_assoc($sql);
					}
				?>
				<div class="content">
					<img src="php/images/<?php echo $row['img'] ?>" alt="">
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


	<script src="javascript/users.js" type="text/javascript"></script>

</body>
</html>