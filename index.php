<?php
	session_start();
	if(isset($_SESSION['unique_id'])){
		header("location: users.php");
	}
	include_once "header.php";
?>
<body>
	<div class="wrapper">
		<section class="form signup">
			<header>Realtime Chat App</header>
			<form action="#">
				<div class="error-txt"></div>
				<div class="name-details">
					<div class="field">
						<label>First Name</label>
						<input type="text" name="fName" placeholder="First Name" required>
					</div>
					<div class="field">
						<label>Last Name</label>
						<input type="text" name="lName" placeholder="Last Name" required>
					</div>
				</div>
					<div class="field">
						<label>Email Address</label>
						<input type="text" name="email" placeholder="Enter your email address" required>
					</div>
					<div class="field">
						<label>Password</label>
						<input type="password" name="password" placeholder="Enter a new password" required>
						<i class="fas fa-eye"></i>
					</div>
					<div class="field image">
						<label>Select Image</label>
						<input type="file" name="image">
					</div>
					<div class="field button">
						<input type="submit" value="Continue to Chat">
					</div>
			</form>
			<div class="link">Already signed up? <a href="login.php">Login now</a></div>
		</section>
	</div>

	<script type="text/javascript" src="javascript/pass-show-hide.js"></script>
	<script type="text/javascript" src="javascript/signup.js"></script>

</body>
</html>