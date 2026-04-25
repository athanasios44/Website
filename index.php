<?php
//start session or resume existing session
session_start();
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
	<!--Great Stack (2022)How To Make A Website Header Using HTML And CSS | Create Website Design With HTML & CSS YouTube. Available at: https://www.youtube.com/watch?v=CgxEA9iMMWI (Accessed: 27 November 2025).-->
	<!-- THE HEADER -->
	<div class = "header">
	<nav>
		<!-- IMAGE LOGO OF UCLAN -->
		<img id = "logo" src = "images/logo_reverse.png" alt ="reverse logo">
		<!-- IN HEADER STUDENT SHOP PARAGRAPH -->
		<p>STUDENT SHOP</p>
		<!-- ALL THE LINKS FOR THE 3 WEBSITES -->
		<ul class="items">
			<li><a href="index.php" >Home</a></li>
			<li><a href="products.php" >Products</a></li>
			<li><a href="cart.php" >Cart</a></li>
			<?php 
			//if the user is logged in show logout
			if(isset($_SESSION['user_id'])):?>
				<li><a href="logout.php">Logout</a></li>
			<?php 
				//else show sign up
				else: ?>
				<li><a href="register.php">Sign Up</a></li>
			<?php
				//close if statement
				endif; ?>
		</ul>
	</nav>
	<!-- LOADS HAMBURGER MENU ICON AND CALLS FUNCTION FROM JAVASCRIPT FILE. CREATES A BUTTON FOR THE HAMBURGER MENU -->
	<div class="item" id="menu">
		<button id="ham_menu" onclick="MENUBAR()">
			<!-- LOADS HAMBURGER MENU ICON AND CALLS FUNCTION FROM JAVASCRIPT FILE. CREATES A BUTTON FOR THE HAMBURGER MENU -->
			<!-- List (no date) · Bootstrap Icons. Available at: https://icons.getbootstrap.com/icons/list (Accessed: 2 December 2025). -->
			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
				<path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5"/>
			</svg>
		</button>	
	</div>
	<!-- THE LINKS FOR THE HAMBURGER MENU FOR THE 3 WEBSITES-->
	
		<ul id="menulist">
			<li><a href="index.php" >Home</a></li>
			<li><a href="products.php" >Products</a></li>
			<li><a href="cart.php" >Cart</a></li>
			<?php 
			//if the user is logged in show logout
			if(isset($_SESSION['user_id'])):?>
				<li><a href="logout.php">Logout</a></li>
			<?php 
				//else show sign up
				else: ?>
				<li><a href="register.php">Sign Up</a></li>
			<?php
				//close if statement
				endif; ?>
		</ul>
	
	</div>
	
	
	<?php
		//show current offers
	
		echo '<h2>🏷️ CURRENT OFFERS 🏷️</h2>';
		echo '<br>';

		//connect with the database 
		$connection =mysqli_connect("localhost", "aantoniou16","K7ZHrvCjyW","aantoniou16");
		//select everything from table tbl_offers inside the database
		$myQuery = "SELECT * FROM tbl_offers";
		
		//save the results 
		$result = mysqli_query($connection, $myQuery);	
		
		//loop all rows and show the offers
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
		{
			echo '<div class="homepageOffers">';
			echo '<br>';
			echo '<h3>'.htmlspecialchars($row['offer_title']).'</h3>';
			echo '<p>'.htmlspecialchars($row['offer_desc']).'</p>';
			echo '</div>';
			echo '<br>';
		}		
		
		
		//close the database connection
		mysqli_close($connection);
	?>
	
	<!-- ALL THE WELCOME MESSAGES IN THE HOME PAGE -->
    <h1>Where Opportunity creates success</h1>
	
    <p>
	Every student at The University of Central Lancashire is automatically a member of the Students Union.
	<br>
	We 're here to make life better for students - inspiring you to succeed and achieve your goals.
	</p>
	
	<p>
	Everything you need to know about UCLan Students Union . Your membership starts here.
	</p>
	
	<h2>
	Together
	</h2>
	<!-- 241Coding (2023) How to insert a video using HTML YouTube. Available at: https://www.youtube.com/shorts/h51jaPt5A5s (Accessed: 1 December 2025). -->
	<!-- HTML5 EMBED VIDEO -->
	<video controls src = "images/video.mp4" > </video>
	
	<br>
	
	<h2> Join our global community </h2>
	<!-- IFRAME EMBED VIDEO -->
<iframe title="vimeo-player" src="https://player.vimeo.com/video/1071072056?h=d4263dcc56" referrerpolicy="strict-origin-when-cross-origin" allow="autoplay; fullscreen; picture-in-picture; clipboard-write; encrypted-media; web-share"   allowfullscreen></iframe>	
	<!--Great Stack (2022)How To Make A Website Header Using HTML And CSS | Create Website Design With HTML & CSS YouTube. Available at: https://www.youtube.com/watch?v=CgxEA9iMMWI (Accessed: 27 November 2025).-->
	<!-- FOOTER -->
	<div class="footer">
		<div>
			<!-- LINK TO UCLAN CYPRUS PAGE -->
			<p class="footer-title">Link</p>
			<p><a href="https://www.uclancyprus.ac.cy">UCLan Cyprus</a></p>
		</div>

		<div>
			<!-- CONTACT INFORMATION -->
			<p class="footer-title">Contact</p>
			<p>Email: info@example.uclan.ac.uk</p>
			<p>Phone: +123 456 7890</p>
		</div>

		<div>
			<!-- LOCATION INFORMATION -->
			<p class="footer-title">Location</p>
			<p>Pila , Cyprus</p>
		</div>
	</div>
	
</body>
</html>