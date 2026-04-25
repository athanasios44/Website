<?php

//start session or resume existing session
session_start();
require_once 'config.php';


$login_error = '';


//Check whether the login form was submitted using method POST and if so retrieve the username and password without spaces
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

	//check that username and password are not empty, if empty show error
    if ($username === '' || $password === '') {
        $login_error = 'Please fill in both fields.';	
    } 
	else {
        $sql = 'SELECT user_id, user_name, user_pass FROM tbl_users WHERE user_name = ? LIMIT 1';
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) === 1) {
            mysqli_stmt_bind_result($stmt, $id, $db_username, $db_password_hash);
            mysqli_stmt_fetch($stmt);
			
			//check the hashed password is the same as the submitted password
            if (password_verify($password, $db_password_hash)) {
                // Password correct: log the user in
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $db_username;

				//redirect to welcome.php
                header('Location: welcome.php');
                exit;
            } else {
                $login_error = 'Invalid username or password.';
            }
        } else {
            $login_error = 'Invalid username or password.';
        }

        mysqli_stmt_close($stmt);
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <!-- METADATA FOR ENCODING AND RESPONSIVE DESIGN, TITLE , AND LINKING CSS FILE AND JAVASCRIPT FILE -->
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">   
	<title>Login</title>
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
			<li><a href="Index.php" >Home</a></li>
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

<form method="post" action="login.php" id="login-form">
    <h2>Login</h2>

    <!-- place for error messages -->
<?php if ($login_error !== ''): ?>
    <div class="error-messages">
        <?php echo htmlspecialchars($login_error); ?>
    </div>
<?php endif; ?>


    <label>Username</label>
    <input type="text" name="username" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <button type="submit" name="login">Login</button>

    <p>Don't have an account? <a href="register.php">Register here</a></p>
</form>

</body>
</html>
