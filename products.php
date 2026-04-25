<?php
//start session or resume existing session
session_start();
require_once 'config.php';

//create an empty array to store the products
$products=[];

//database querry that select all products from tbl_products
$sql_querry="SELECT * FROM tbl_products";
$result = mysqli_query($conn,$sql_querry);


while($row = mysqli_fetch_assoc($result)){
	//append all products inside the array
	$products[] = $row;
}

//close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<!-- METADATA FOR ENCODING AND RESPONSIVE DESIGN, TITLE , AND LINKING CSS FILE AND JAVASCRIPT FILE -->
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">   
	<title>Products</title>
	<link rel = "stylesheet" href = "styling.css">
	
	<script>
	//convert the array products to js
	const tshirts = <?php echo json_encode($products);?>;
	</script>
	
	<script>
	//pass PHP status to js to check if the user is logged in to restrict actions if the user is not logged in
	const isLoggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;
	</script>

	
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
	<!-- List (no date) · Bootstrap Icons. Available at: https://icons.getbootstrap.com/icons/list (Accessed: 2 December 2025). -->
		<button id="ham_menu" onclick="MENUBAR()">
			<!-- LOADS HAMBURGER MENU ICON AND CALLS FUNCTION FROM JAVASCRIPT FILE. CREATES A BUTTON FOR THE HAMBURGER MENU -->
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
	
	<!-- CREATES A LABEL FOR FILTERING OUT FROM STOCK  + CREATES A SELECT WITH THE OPTIONS MATCHING THE PRODUCT ARRAY STOCK tshirts[i][3] -->
	<label for="filter">STOCK</label>
	<select id="filter">
		<option value="all">ALL</option>
		<option value="good-stock">GOOD STOCK</option>
		<option value="low-stock">LAST FEW</option>
		<option value="out-of-stock">OUT OF STOCK</option>
	</select>
	<!-- WHERE ALL THE TSHIRTS WILL BE LOADED WITH ALL INFORMATION -->
	<div id="products">
		
	</div>
</body>

</html>