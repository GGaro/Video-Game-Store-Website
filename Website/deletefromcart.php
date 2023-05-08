<?php
require "dbconfig.php";

if (isset($_GET['userid']) && isset($_GET['gameid'])) {
    $userid = $_GET['userid'];
    $gameid = $_GET['gameid'];
    $dbconn = connectToDb();

    $sql = "delete from cart where userid='$userid' and gameid='$gameid'";
    $result = mysqli_query($dbconn, $sql);

    if (!$result) {
        echo "error removing game with ID $gameid from cart:" . mysqli_error($dbconn);
    }
}
?>
