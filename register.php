<?php

session_start();

if( isset($_SESSION['user_id']) ){
	header("Location: /");
}

/* requires that database.php file, so you don't have to include in here. Like an external stylesheet */
require 'database.php';

$message = '';

/* If it's not empty, excecute all of this */
if(!empty($_POST['email']) && !empty($_POST['password'])):
	
	/* Enter the new user in the database
	   :email :password protects against SQL injections. 
	   They are inserted in the paramter below it.*/
	$sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
	$stmt = $conn->prepare($sql);

	$stmt->bindParam(':email', $_POST['email']);
	
	/* using the password_hash which is a predefined function and PASSWORD_BRCRYPT to safely store the password in the database */
	$stmt->bindParam(':password', password_hash($_POST['password'], PASSWORD_BCRYPT));

	/* if statement is excecuted correctly and the data is inserted into the database, do this, otherwise, do that */
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
    
	<!-- If it's not empty, we have this message for you. The "succes" or "failure" text. -->
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