<?php
function connectToSql()
{
    $conn = mysqli_connect("localhost", "root", "");
    if (!$conn) {
        echo mysqli_connect_error();
    }
    return $conn;
}

function createDb($sqlconn)
{
    $sql = "create database if not exists garogames";
    $result = mysqli_query($sqlconn, $sql);
    if (!$result) {
        echo mysqli_error($result);
    }
}

function connectToDb()
{
    $conn = mysqli_connect("localhost", "root", "", "garogames");
    if (!$conn) {
        echo mysqli_connect_error();
    }
    return $conn;
}
function createTables($dbconn)
{
    $sql = "CREATE TABLE IF NOT EXISTS users (
        userid INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL,
        email VARCHAR(50) NOT NULL,
        password VARCHAR(50) NOT NULL
    )";
    $result = mysqli_query($dbconn, $sql);
    if (!$result) {
        echo "Error creating users table: " . mysqli_error($dbconn);
    }
    $sql = "CREATE TABLE IF NOT EXISTS games (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        description VARCHAR(255) NOT NULL,
        image VARCHAR(255) NOT NULL,
        price  int(6)
    )";
    $result = mysqli_query($dbconn, $sql);
    if (!$result) {
        echo "Error creating users table: " . mysqli_error($dbconn);
    }
    $sql = "CREATE TABLE IF NOT EXISTS cart (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        userid VARCHAR(50) NOT NULL,
        gameid VARCHAR(50) NOT NULL
    )";
    $result = mysqli_query($dbconn, $sql);
    if (!$result) {
        echo "Error creating users table: " . mysqli_error($dbconn);
    }
    $sql = "CREATE TABLE IF NOT EXISTS wishlist (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        userid VARCHAR(50) NOT NULL,
        gameid VARCHAR(50) NOT NULL
    )";
    $result = mysqli_query($dbconn, $sql);
    if (!$result) {
        echo "Error creating users table: " . mysqli_error($dbconn);
    }
}

function addgames($sqlconn)
{
    $sql = "SELECT COUNT(*) FROM games";
    $result = mysqli_query($sqlconn, $sql);
    $row = mysqli_fetch_row($result);
    if ($row[0] == 0) {
        // Table is empty, so we can add data from the CSV file 
        // Open the CSV file for reading
        $file = fopen("csv/games.csv", "r");

        // Loop through each row in the CSV file
        while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
            // Insert the data into the "games" table
            $sql = "INSERT INTO games (name, description, image, price) VALUES ('" . $data[0] . "', '" . $data[1] . "', '" . $data[2] . "', '" . $data[3] . "')";
            mysqli_query($sqlconn, $sql);
        }

        // Close the CSV file
        fclose($file);
    }
}

function addadmin($sqlconn) {
    $sql = "SELECT COUNT(*) FROM users WHERE username = 'admin'";
    $result = mysqli_query($sqlconn, $sql);
    $row = mysqli_fetch_row($result);
    if ($row[0] == 0) {
        $sql = "INSERT INTO users (username, email, password) VALUES ('admin', 'admin@admin.admin', 'admin')";
        mysqli_query($sqlconn, $sql);
    }
}

?>