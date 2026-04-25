<?php
//start session or resume existing session
session_start();
require_once 'config.php';

//if not logged in die
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to submit a review.");
}

//make sure product used method POST
if (!isset($_POST['product_id']) || !is_numeric($_POST['product_id'])) {
    die("Invalid product.");
}

$product_id = intval($_POST['product_id']);
$user_id = $_SESSION['user_id'];

$title = mysqli_real_escape_string($conn, $_POST['review_title']);
$desc = mysqli_real_escape_string($conn, $_POST['review_desc']);
$rating = intval($_POST['review_rating']);

$sql = "INSERT INTO tbl_reviews (product_id, user_id, review_title, review_desc, review_rating)
        VALUES ($product_id, $user_id, '$title', '$desc', $rating)";

if (mysqli_query($conn, $sql)) {
    mysqli_close($conn);
    header("Location: item.php?id=" . $product_id);
    exit();
} else {
    echo "Error inserting review: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
