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
		<section class="chat-area">
			<header>
				<?php
					include_once "php/config.php";
					$user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
					$sql = $conn->prepare("SELECT * FROM users WHERE unique_id = ?");
					$sql->bind_param("s", $user_id);
					$sql->execute();
					$result = $sql->get_result();
					$row = mysqli_fetch_assoc($result);
				?>
				
				<a href="users.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
				<img src="php/images/<?php echo $row['img'] ?>" alt="">
				<div class="details">
					<span><?php echo $row['fname'] . " " . $row['lname']?></span>
					<p><?php if($row['status']==1){echo "online";}else{echo "offline";} ?></p>
				</div>
			</header>
			<div class="chat-box">
				
			</div>
			<form action="#" class="typing-area" autocomlete="off" enctype="multipart/form-data">
				<input type="text" name="outgoing_id" value="<?php echo $_SESSION['unique_id'] ?>" hidden>
				<input type="text" name="incoming_id" value="<?php echo $user_id ?>" hidden>
				<!-- <button class="paperclip"><i class="fas fa-paperclip"></i></button> -->
				<input type="file" name="inputFile" id="fileInput" name="file" hidden>

				<!-- Paperclip button -->
				<div class="file-btn">
					<label for="fileInput">
						<i class="fas fa-paperclip"></i>
					</label>
					<span class="file-indicator"></span>
				</div>
				<input type="text" name="message" class="input-field" placeholder="Type a message here...">
				
				<button><i class="fab fa-telegram-plane"></i></button>
			</form>
		</section>
	</div>

	<script type="text/javascript" src="javascript/chat.js"></script>
</body>
</html>