<?php
session_start();
require "dbconfig.php";
$dbconn = connectToDb();

// Get the user's cart for the current session
$userid = $_SESSION['userid'];
$stmt = $dbconn->prepare("SELECT gameid FROM cart WHERE userid = ?");
$stmt->bind_param("i", $userid);
$stmt->execute();
$cartResult = $stmt->get_result();
$cart = array();
while ($row = mysqli_fetch_array($cartResult)) {
    $cart[] = $row['gameid'];
}

if (empty($cart)) {
    // Return an empty array if the cart is empty
    echo json_encode(array());
} else {
// Get all the games that are in the cart and add the cart information to each game
$stmt = $dbconn->prepare("SELECT * FROM games WHERE id IN (".implode(',',$cart).")");
$stmt->execute();
$result = $stmt->get_result();
$games = array();
while ($row = mysqli_fetch_assoc($result)) {
    $games[] = array_merge($row, array('in_cart' => true));
}
echo json_encode($games);

}
?>
