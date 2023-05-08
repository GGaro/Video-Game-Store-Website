<?php
// Include the file that contains the database connection information
include "dbconfig.php";

// Check if the 'userid' and 'gameid' parameters are set in the URL
if (isset($_GET['userid']) && isset($_GET['gameid'])) {
    // Get the values of 'userid' and 'gameid' from the URL parameters
    $userid = $_GET['userid'];
    $gameid = $_GET['gameid'];

    // Call the function to connect to the database
    $dbconn = connectToDb();

    // Construct the SQL query to insert the data into the 'cart' table
    $sql = "insert into cart (userid,gameid) values ('$userid', '$gameid')";

    // Execute the SQL query using the database connection
    $result = mysqli_query($dbconn, $sql);

    // If the query failed, output an error message
    if (!$result) {
        echo "error adding product to cart: " . mysqli_error($dbconn);
    }
}
?>