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
						<label>Անուն</label>
						<input type="text" name="fName" placeholder="Անուն" required>
					</div>
					<div class="field">
						<label>Ազգանուն</label>
						<input type="text" name="lName" placeholder="Ազգանուն" required>
					</div>
				</div>
					<div class="field">
						<label>Email հասցե</label>
						<input type="text" name="email" placeholder="Մուտքագրեք ձեր Email հասցեն" required>
					</div>
					<div class="field">
						<label>Գաղտնաբառ</label>
						<input type="password" name="password" placeholder="Գաղտնաբառ մուտքագրեք" required>
						<i class="fas fa-eye"></i>
					</div>
					<div class="field image">
						<label>Ընտրել նկար</label>
						<input type="file" name="image">
					</div>
					<div class="field button">
						<input type="submit" value="Գրանցվել">
					</div>
			</form>
			<div class="link">Արդեն գրանցվա՞ծ եք <a href="login.php">Մուտք գործել</a></div>
		</section>
	</div>

	<script type="text/javascript" src="javascript/pass-show-hide.js"></script>
	<script type="text/javascript" src="javascript/signup.js"></script>

</body>
</html>