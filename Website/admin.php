<?php
require "dbconfig.php";
$sqlconn = connectToSql();
createDb($sqlconn);
$dbconn = connectToDb();
createTables($dbconn);
addgames($dbconn);
addadmin($dbconn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Garo Games</title>
    <link rel="icon" href="images/main/icon.svg">
    </link>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    </link>
</head>

<body style="background-color:black;">
    <nav class="navbar navbar-expand-lg bg-body-tertiary"
        style="border: 2px dashed white; position: sticky; top: 0; left: 0; width: 100%; z-index: 9999;">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php"><img src="images/main/logo.svg" title="Home" width="100"
                    height="100" class="d-inline-block align-text-top"></a>
            <a class="navbar-brand" href="browse.php"><img src="images/main/browse.svg" title="Browse" width="100"
                    height="100" class="d-inline-block align-text-top"></a>
            <a class="navbar-brand" href="checkout.php" onclick="checkLogin(event)"><img src="images/main/checkout.svg"
                    title="Check Out" width="100" height="100" class="d-inline-block align-text-top"></a>
            <span class="navbar-toggler-icon"></span>
            <?php
            session_start();
            $userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : null;
            if ($userid !== null) {
                include 'nav-logged-in.php';
            } else {
                include 'nav-not-logged-in.php';
            }
            ?>
        </div>
    </nav>
    <div
        style="display:flex; justify-content:center; align-items:center; width:100%; height:80vh; background-image:url('images/main/games.svg'); background-repeat:no-repeat; background-size:100% 70%;">
        <div
            style="border:4px solid black; border-radius:25px; padding:20px; background-color:black; margin-top: -350px;">
            <button
                style="font-size:24px; color:gold; background-color:black; border:2px solid gold; border-radius:10px; padding:10px 20px;"
                onclick="updateGames()">Update games</button>
            <br><br>
            <button
                style="font-size:24px; color:black; background-color:white; border:2px solid gold; border-radius:10px; padding:10px 20px; display:block; margin:0 auto;"
                onclick="window.location.href='easteregg.php'">Easter Egg</button>
        </div>
    </div>







    <style>
        .navbar {
            background-color: black ;
            ;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 9999;
        }
    </style>
    <script>
        function updateGames() {
            if (confirm('Are you sure you want to update the games? This action will delete all current games.')) {
                fetch('update-games.php')
                    .then(response => {
                        if (response.ok) {
                            alert('Games updated successfully');
                        } else {
                            alert('Failed to update games');
                        }
                    })
                    .catch(error => {
                        alert('Failed to update games');
                    });
            }
        }
    </script>
</body>

</html>