<?php

//start session or resume existing session
session_start();

if (! isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$username = $_SESSION['username'] ?? 'User';
?>


<!DOCTYPE html>
<html lang="en">
<head>
   	<!-- METADATA FOR ENCODING AND RESPONSIVE DESIGN, TITLE , AND LINKING CSS FILE AND JAVASCRIPT FILE -->
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">   
	<title>Index</title>
	<link rel = "stylesheet" href = "styling.css">
	<script src="javascript.js"></script>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
    <p>You are now logged in.</p>
	<div id="welcomeSection">
		<button onclick="window.location='logout.php'">LOGOUT</button>
		<button onclick="window.location='index.php'">BACK TO HOME</button>
	</div>
</body>
</html>
