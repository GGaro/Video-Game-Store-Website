<?php
session_start();
require "dbconfig.php";

$userid = $_SESSION['userid'];
$gameid = $_GET['gameid'];

// Connect to the database
$dbconn = connectToDb();

// Check if the game is already in the cart
$query = "SELECT * FROM cart WHERE user_id=$userid AND game_id=$gameid";
$result = mysqli_query($dbconn, $query);
if (mysqli_num_rows($result) > 0) {
    $response = array('status' => 'success', 'message' => 'Game is in cart');
} else {
    $response = array('status' => 'error', 'message' => 'Game is not in cart');
}

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
