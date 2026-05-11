<?php
	session_start();
	require_once __DIR__ . "/php/csrf.php";
	if(isset($_SESSION['unique_id'])){
		header("location: users.php");
	}
	include_once __DIR__ . "/includes/header.php";
?>
<body>
	<div class="wrapper">
		<section class="form login">
			<header>Realtime Chat App</header>
			<form action="#">
				<input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
				<div class="error-txt"></div>
					<div class="field">
						<label>Email հասցե</label>
						<input type="text" name="email" placeholder="Մուտքագրեք ձեր Email հասցեն" required>
					</div>
					<div class="field">
						<label>Գաղտնաբառ</label>
						<input type="password" name="password" placeholder="Մուտքագրեք ձեր գաղտնաբառը" required>
						<i class="fas fa-eye"></i>
					</div>
					<div class="field button">
						<input type="submit" value="Մուտք գործել">
					</div>
			</form>
			<div class="link">Դեռ գրանցված չե՞ք <a href="index.php">Գրանցվել</a></div>
		</section>
	</div>

	<script type="text/javascript" src="assets/js/pass-show-hide.js"></script>
	<script type="text/javascript" src="assets/js/login.js"></script>

</body>
</html>