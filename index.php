<?php

session_start();

require 'database.php';

if( isset($_SESSION['user_id']) ){

	$records = $conn->prepare('SELECT id,email,password FROM users WHERE id = :id');
	$records->bindParam(':id', $_SESSION['user_id']);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);

	$user = NULL;

	if( count($results) > 0){
		$user = $results;
	}
}

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

	<?php if( !empty($user) ): ?>
		
		<br />Welcome <?= $user['email']; ?> 
		<br /><br />You are successfully logged in!
		<br /><br />
        <p>Here's that secret stuff you were promised:</p>
        <a href="http://sfholleufer.com">Secret stuff</a><br><br><br>
		<a href="logout.php">Logout?</a>

	<?php else: ?>

		<h1>What would you like to do?</h1>
		<a href="login.php"><p>Login here</p></a> or
		<a href="register.php"><p>Register for a profile</p></a>
        <p class="p">Pssssst! If you log in, you will be able to view some secret stuff on this very page!</p>

	<?php endif; ?>
    <?php require 'footer.php'; ?>

</body>
</html>