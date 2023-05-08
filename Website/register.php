<?php
session_start();
require "dbconfig.php";

if (isset($_GET['dummy_data'])) {
    $dbconn = connectToDb();

    $sql = "SELECT * FROM users WHERE username = 'dum' OR email = 'dum@dum.dum'";
    $result = mysqli_query($dbconn, $sql);

    if (mysqli_num_rows($result) > 0) {
        header('location:signup.php?error=userexist');
    } else {
        $sql = "INSERT INTO users (username, email, password) VALUES ('dum', 'dum@dum.dum', 'dum')";
        $dbconn = connectToDb();
        mysqli_query($dbconn, $sql);
        session_start();
        $_SESSION['userid'] = $username;
        header('location:index.php');
    }
}

if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $dbconn = connectToDb();

    $sql = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
    $result = mysqli_query($dbconn, $sql);

    if (mysqli_num_rows($result) > 0) {
        header('location:signup.php?error=userexist');
    } else {
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
        mysqli_query($dbconn, $sql);
        session_start();
        $_SESSION['userid'] = $username;
        header('location:index.php');
    }
} else
    header('location:signup.php?error=userexist');
?>