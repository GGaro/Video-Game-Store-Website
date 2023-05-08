<?php
// Include the database configuration file
include "dbconfig.php";

// Check if the userid and gameid are set in the URL parameters
if (isset($_GET['userid']) && isset($_GET['gameid'])) {

    // Assign the values of userid and gameid from the URL parameters to variables
    $userid = $_GET['userid'];
    $gameid = $_GET['gameid'];

    // Connect to the database
    $dbconn = connectToDb();

    // Query the database to check if the game is already in the user's wishlist
    $sql = "SELECT * FROM wishlist WHERE userid = '$userid' and gameid = '$gameid'";
    $result = mysqli_query($dbconn, $sql);

    // If the game is already in the wishlist, remove it
    if (mysqli_num_rows($result) > 0) {
        $sql = "DELETE FROM wishlist WHERE userid = '$userid' and gameid = '$gameid'";
        $result = mysqli_query($dbconn, $sql);

        // If there was an error removing the game from the wishlist, display an error message
        if (!$result) {
            echo "error deleting product from wishlist: " . mysqli_error($dbconn);
        }
    } 
    // If the game is not already in the wishlist, add it
    else {
        $sql = "insert into wishlist (userid,gameid) values ('$userid', '$gameid')";
        $result = mysqli_query($dbconn, $sql);

        // If there was an error adding the game to the wishlist, display an error message
        if (!$result) {
            echo "error adding product to wishlist: " . mysqli_error($dbconn);
        }
    }
}
?>
