<?php
require "dbconfig.php";

// Connect to the database
$sqlconn = connectToSql();
createDb($sqlconn);
$dbconn = connectToDb();

// Delete all the items in the "games" table
$sql = "DELETE FROM games";
mysqli_query($dbconn, $sql);

// Open the CSV file for reading
$file = fopen("csv/games.csv", "r");

// Loop through each row in the CSV file
while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
    // Insert the data into the "games" table
    $sql = "INSERT INTO games (name, description, image, price) VALUES ('" . $data[0] . "', '" . $data[1] . "', '" . $data[2] . "', '" . $data[3] . "')";
    mysqli_query($dbconn, $sql);
}

// Close the CSV file
fclose($file);

// Redirect back to the homepage
header("Location: index.php");
?>