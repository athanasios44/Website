<?php
require_once 'config.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
	$address =trim($_POST['user_address']??'');

    //Basic validation
    if ($username === '') {
        $errors[] = 'Username is required.';
    }

    if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'A valid email is required.';
    }

    if (strlen($password) < 6) {
        $errors[] = 'Password must be at least 6 characters.';
    }

    if ($password !== $confirm_password) {
        $errors[] = 'Passwords do not match.';
    }

    //Check if username or email already exists
    if (empty($errors)) {
        $sql = 'SELECT user_id FROM tbl_users WHERE user_name = ? OR user_email = ? LIMIT 1';
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'ss', $username, $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $errors[] = 'Username or email is already taken.';
        }

        mysqli_stmt_close($stmt);
    }

    //Insert new user if no errors
    if (empty($errors)) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $insert_sql = 'INSERT INTO tbl_users (user_name, user_email,user_pass ,user_address) VALUES (?, ?, ?, ?)';
        $insert_stmt = mysqli_prepare($conn, $insert_sql);
        mysqli_stmt_bind_param($insert_stmt, 'ssss', $username, $email, $password_hash, $address);

        if (mysqli_stmt_execute($insert_stmt)) {
            //Successful registration: redirect to login page
            header('Location: login.php');
            exit;
        } else {
            $errors[] = 'Something went wrong. Please try again.';
        }

        mysqli_stmt_close($insert_stmt);
    }
}



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


<form method="post" action="register.php" id="register-form">
    <h2>Register</h2>

    <!-- error messages -->
<?php if (! empty($errors)): ?>
    <div class="error-messages">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>


<div> 
<h3> PASSWORD SHOULD BE MINIMUM 6 CHARACTERS LONG AND USERNAME AND EMAIL MUST BE UNIQUE </h3>
</div>

    <label>Username</label>
    <input type="text" name="username" required>

    <label>Email</label>
    <input type="email" name="email" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <label>Confirm Password</label>
    <input type="password" name="confirm_password" required>

	<label>Address</label>
	<input type="text" name="user_address" required>

    <button type="submit" name="register">Create Account</button>

    <p>Already have an account? <a href="login.php">Login here</a></p>
</form>

</body>
</html>
