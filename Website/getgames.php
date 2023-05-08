<?php
session_start();
require "dbconfig.php";
$dbconn = connectToDb();

// Initialize wishlist and cart to empty arrays
$wishlist = array();
$cart = array();

// Check if the user is logged in and get their wishlist and cart
if (isset($_SESSION['userid']) && !empty($_SESSION['userid'])) {
    $userid = $_SESSION['userid'];

    // Get the user's wishlist for the current session
    $stmt = $dbconn->prepare("SELECT gameid FROM wishlist WHERE userid = ?");
    $stmt->bind_param("i", $userid);
    $stmt->execute();
    $wishlistResult = $stmt->get_result();

    while ($row = mysqli_fetch_array($wishlistResult)) {
        $wishlist[] = $row['gameid'];
    }

    // Get the user's cart for the current session
    $stmt = $dbconn->prepare("SELECT gameid FROM cart WHERE userid = ?");
    $stmt->bind_param("i", $userid);
    $stmt->execute();
    $cartResult = $stmt->get_result();

    while ($row = mysqli_fetch_array($cartResult)) {
        $cart[] = $row['gameid'];
    }
}

// Get all the games and add the wishlist and cart information to each game
$stmt = $dbconn->prepare("SELECT * FROM games");
$stmt->execute();
$result = $stmt->get_result();
$games = array();
while ($row = mysqli_fetch_array($result)) {
    $is_in_wishlist = in_array($row['id'], $wishlist);
    $row['is_in_wishlist'] = $is_in_wishlist;
    $is_in_cart = in_array($row['id'], $cart);
    $row['is_in_cart'] = $is_in_cart;
    $games[] = $row;
}

echo json_encode($games);

?>