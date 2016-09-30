<?php

/* This needs to be here in order for sessions to work */
session_start();

/* If the user is logged in, they get redirected to the homepage */
if( isset($_SESSION['user_id']) ){
	header("Location: /");
}

require 'database.php';

if(!empty($_POST['email']) && !empty($_POST['password'])):

	/* Stores records that we get from the database. Selects information from specific user with the correct email */
	$records = $conn->prepare('SELECT id,email,password FROM users WHERE email = :email');
	
	/* bindParam binds the :email with the actual email posted using POST - safety measure */
	$records->bindParam(':email', $_POST['email']);
	
	/* Exectuces the $records */ 
	$records->execute();
	
	/* Fetches the email where email matches the typed in email */
	$results = $records->fetch(PDO::FETCH_ASSOC);

	$message = '';

	/* If theres a record and theres a result and the passwords match, do this */
	if(count($results) > 0 && password_verify($_POST['password'], $results['password']) ){
		
		/* Creates the session, so when the user changes page, he is still logged in */
		$_SESSION['user_id'] = $results['id'];
		
		/* Redirects the user to the homepage, if he succesfully logs in */
		header("Location: /");
		
		/* If he doesn't succesfully log in, this message is displayed */
	} else {
		$message = 'Sorry, those credentials do not match';
	}

	/* This whole process checks the database for the user, if the email and passwords are the same, and excutes the orders depending if the username and password matches or not */
	
endif;

?>

<!DOCTYPE html>
<html>
<head>
	<title>Login Below</title>
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

	<h1>Login</h1>
	<span>or <a href="register.php">register here</a></span>

	<!-- Form is using POST to post the content of the form to the page, login.php (refreshing) -->
    <form action="login.php" method="POST">
		
        <!-- different form inputs -->
		<input type="email" placeholder="email" name="email">
		<input type="password" placeholder="password" name="password">
		<input type="submit">

	</form>
    <?php require 'footer.php'; ?>

</body>
</html>