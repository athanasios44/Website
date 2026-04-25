<!DOCTYPE html>
<html lang="en">
<head>
	<!-- METADATA FOR ENCODING AND RESPONSIVE DESIGN, TITLE , AND LINKING CSS FILE -->
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Item</title>
	<link rel = "stylesheet" href = "styling.css">
	<script src="javascript.js" defer></script>
</head>

<body>

<?php

//database password and username
$host = 'localhost';
$db_user = 'aantoniou16';      
$db_pass = 'K7ZHrvCjyW';          
$db_name = 'aantoniou16'; 

//connect to database
$conn = mysqli_connect($host, $db_user, $db_pass, $db_name);

//if cannot be connected die 
if (!$conn) {
    die('Database connection failed: ' . mysqli_connect_error());
}
?>
</body>