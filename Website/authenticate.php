<?php
// Include the database configuration file
require "dbconfig.php";

// Check if the username and password have been submitted via POST method
if(isset($_POST['username']) && isset($_POST['password'])){

    // Retrieve the username and password from the POST data
    $username=$_POST['username'];
    $password=$_POST['password'];

    // Connect to the database
    $dbconn=connectToDb();

    // Query the database for the user with the provided username/email and password
    $sql="select * from users where (username = '$username' or email = '$username') and password = '$password'";
    $result=mysqli_query($dbconn,$sql);

    // If the query returns at least one row, set the user ID in the session and redirect to the index page
    if(mysqli_num_rows($result)>0){
        $row=mysqli_fetch_array($result);
        session_start();
        $_SESSION['userid'] = $username;
        header('location:index.php');
    }
    // If the query returns no rows, redirect back to the login page with a parameter indicating the login failed
    else header('location:login.php?login_failed=true');
}
// If the username and password were not submitted via POST method, redirect back to the login page with a parameter indicating the login failed
else header('location:login.php?login_failed=true');
?>
