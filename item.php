<?php
//start session or resume existing session
session_start();

//if the user is not logged in item.php is not accessible. Redirect the user to register and log in
if (!isset($_SESSION['user_id'])) {
    header("Location: register.php");
    exit();
}

//require file once
require_once 'config.php';

//validate the id of the product inside the URL
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
	die("Product ID does not exist!");	
}

//convert id of product to an integer
$id = intval($_GET['id']);

//database querry that finds from the table product_id the id of the product
$sql = "SELECT * FROM tbl_products WHERE product_id = $id";

//the result of the querry
$result = mysqli_query($conn,$sql);
$product = mysqli_fetch_assoc($result);

//database querry that selects all reviews for the product from table tbl_reviews
$review_sql_query = "SELECT * FROM tbl_reviews WHERE product_id = $id";
$review_result = mysqli_query($conn,$review_sql_query);

//get the average product rating for the product
$avg_sql = "SELECT AVG(review_rating) AS avg_rating FROM tbl_reviews WHERE product_id = $id";
$avg_result = mysqli_query($conn,$avg_sql);
$avg_row = mysqli_fetch_assoc($avg_result);
$avg_rating = round($avg_row['avg_rating'],1);

//if the product id was  not found show error
if(!$product){
	die("Product does exist");	
}

//close databse connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<!-- METADATA FOR ENCODING AND RESPONSIVE DESIGN, TITLE , AND LINKING CSS FILE -->
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Item</title>
	<link rel = "stylesheet" href = "styling.css">
	<script src="javascript.js" defer></script>
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
		<!-- ALL THE LINKS FOR 3 WEBSITES -->
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
	<!-- LOADS HAMBURGER MENU ICON AND CALLS FUNCTION FROM JAVASCRIPT FILE + CREATES A BUTTON FOR THE HAMBURGER MENU -->
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

<!-- CREATES A DIVISION TO LOAD THE INFORMATION FOR THE READ MORE  -->
<div id="more">

<!--Show image of the product -->	
<img class="readmoreimg" src="<?php echo $product['product_src'];?>">

<?php 
	//if the product is out of stock show corresponding message
	if($product['product_stock'] == "out-of-stock"): ?>
		<p class="availability"> OUT OF STOCK </p>
		
<?php 
	//close if statement
	endif; ?>

<h3><?php
	//show title of product
	echo $product['product_title'];
	?></h3>

<p class="prices"><?php 
//show price of the product
echo $product['product_price'];
?></p>

<p><?php 
//show the description of the productt
echo $product['product_desc']; 
?></p>

<br><br><br>

<?php
	//if product has stock show the buy button and the reviews
	if($product['product_stock'] =="good-stock" || $product['product_stock'] == "low-stock"): ?>
		<button class="readmorebutton" id="buyItem">Buy</button>
		<br><br><br>
		<h2>REVIEWS</h2>

		<?php 
			//display all the reviews for the product
			while($review = mysqli_fetch_assoc($review_result)): 
			?>
			<div class="review">
				<h3><?php echo $review['review_title']; ?> (<?php echo $review['review_rating']; ?> /5🌟)</h3>
				<p><?php echo $review['review_desc']; ?></p>
				<small>Posted on: <?php echo $review['review_timestamp']; ?> </small>
				<hr>
			</div>
			
		<?php endwhile; ?>		
		
<?php else: ?>
	<!-- If the product is out of stock disable the buy button -->
	<button class="readmorebutton" disabled> OUT OF STOCK</button>
	<br><br><br>
	<h2>REVIEWS</h2>
	
	<!-- display the reviews -->
	<?php while($review = mysqli_fetch_assoc($review_result)): ?>
			<div class="review">
				<h3><?php echo $review['review_title']; ?> (<?php echo $review['review_rating']; ?> /5🌟)</h3>
				<p><?php echo $review['review_desc']; ?></p>
				<small>Posted on: <?php echo $review['review_timestamp']; ?> </small>
				<hr>
			</div>
						
		<?php endwhile; ?>		
<?php endif; ?>	

<!-- option for user to write review -->

<h2>WRITE REVIEW</h2>
			
			
			<form method="POST" action="submit_review.php">
				<input type="hidden" name="product_id" value="<?php echo $id; ?>">
				
				<label>Title</label>
				<input type="text" name="review_title" required>
			
				<label>Description</label>
				<input type="text" name="review_desc" required>
			
				<label>Rate</label>
				<select name="review_rating" required>
					<option value="5">5 - Excellent</option>
					<option value="4">4 - Great</option>
					<option value="3">3 - Okay</option>
					<option value="2">2 - Poor</option>
					<option value="1">1 - Horrible</option>
				</select>

				<button type="sumbit">Sumbit review</button>
			</form>	
</div>

<script>

	//add product to cart when the buy button is clicked
	document.getElementById("buyItem")?.addEventListener("click", ()=>{
		let cart = JSON.parse(localStorage.getItem("cart")) || [];
		
		cart.push({
			name: "<?php echo $product['product_title']; ?>",
			price: "<?php echo $product['product_price']; ?>",
			img: "<?php echo $product['product_src']; ?>"
		});
		
		//save it to localStorage
		localStorage.setItem("cart", JSON.stringify(cart));
	
		alert("Item Added to cart")
	});
</script>
</body>