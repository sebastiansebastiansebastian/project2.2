<?php

session_start();

if( isset($_SESSION['user_id']) ){
	header("Location: /");
}

require 'database.php';

$message = '';

if(!empty($_POST['email']) && !empty($_POST['password'])):
	
	// Enter the new user in the database
	$sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
	$stmt = $conn->prepare($sql);

	$stmt->bindParam(':email', $_POST['email']);
	$stmt->bindParam(':password', password_hash($_POST['password'], PASSWORD_BCRYPT));

	if( $stmt->execute() ):
		$message = 'Successfully created new user';
	else:
		$message = 'Sorry there must have been an issue creating your account';
	endif;

endif;

?>

<!DOCTYPE html>
<html>
<head>
	<title>Project 2.2 - PHP Login System</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="https://use.typekit.net/zvd5vgl.js"></script>
	<script>try{Typekit.load({ async: true });}catch(e){}</script>
</head>
<body>

	<div class="header">
		<?php require 'menu.php'; ?>
	</div>

	<?php if(!empty($message)): ?>
		<p><?= $message ?></p>
	<?php endif; ?>

	<h1>Register</h1>
	<span>or <a href="login.php">login here</a></span>

	<form action="register.php" method="POST">
		
		<input type="email" placeholder="email" name="email">
		<input type="password" placeholder="password" name="password">
		<input type="password" placeholder="confirm password" name="confirm_password">
		<input type="submit">

	</form>
     <?php require 'footer.php'; ?>

</body>
</html>