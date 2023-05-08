<?php
session_start();
if (isset($_GET['error'])) {
    $errorMessage = '';
    switch ($_GET['error']) {
        case 'userexist':
            $errorMessage = 'Username already exists';
            break;
        case 'success':
            $errorMessage = 'Username successfully changed';
            break;
    }
}

require('dbconfig.php');
$dbconn = connectToDb();

// Get user details from database
$userid = $_SESSION['userid'];
$sql = "SELECT username, password FROM users WHERE (username = '$userid' or email = '$userid')";
$result = mysqli_query($dbconn, $sql);
$user = mysqli_fetch_assoc($result);

// Update user details if form is submitted
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($dbconn, $sql);

    if (mysqli_num_rows($result) > 0) {
        header('location:profile.php?error=userexist');
    } else {
        $sql = "UPDATE users SET username='$username', password='$password' WHERE (username = '$userid' or email = '$userid')";
        $_SESSION['userid'] = $username;
        $result = mysqli_query($dbconn, $sql);
        header('location:profile.php?error=success');
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="icon" href="images/main/icon.svg">
    </link>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    </link>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

</head>

<body style="background-color:black;">
    <nav class="navbar navbar-expand-lg bg-body-tertiary"
        style=" border: 2px dashed white; position: sticky; top: 0; left: 0; width: 100%; z-index: 9999; ">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php"><img src="images/main/logo.svg" title="Home" width="100"
                    height="100" class="d-inline-block align-text-top"></a>
            <a class="navbar-brand" href="browse.php"><img src="images/main/browse.svg" title="Browse" width="100"
                    height="100" class="d-inline-block align-text-top"></a>
            <a class="navbar-brand" href="checkout.php"><img src="images/main/checkout.svg" title="Check Out"
                    width="100" height="100" class="d-inline-block align-text-top"></a>
            <span class="navbar-toggler-icon"></span>
            <?php
            if (isset($_SESSION['userid'])) {
                include 'nav-logged-in.php';
            } else {
                include 'nav-not-logged-in.php';
            }
            ?>
        </div>
    </nav>
    <div
        style="color:white; width: 100%; height: 100%; background-image: url('images/main/games.svg'); background-repeat: no-repeat;  background-size: 100% 70%; height: 80vh">
        <div class=" change_info">
            <h1>Welcome,
                <?php echo $user['username']; ?>!
            </h1>
            <?php if (isset($errorMessage)): ?>
                <div class="error">
                    <?php echo $errorMessage ?>
                </div>
            <?php endif; ?>
            <form method="post">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" value="<?php echo $user['username']; ?>"><br>

                <label for="password">Password:</label>
                <input type="password" name="password" id="password" value="<?php echo $user['password']; ?>"><br>
                <input type="checkbox" onclick="myFunction()">Show Password

                <p><input type="submit" name="submit" value="Save"></p>
            </form>
        </div>
        <label class="wishlist" for="wishlist[]">
            <h1>Wishlist :</h1>
            <div class="row" id="games" style="max-width:100%">

            </div>
        </label><br>


    </div>

    <style>
        input {
            border-radius: 25px;
        }

        .change_info {
            width: 40%;
            float: left;

        }

        .wishlist {
            max-width: 50%;
        }

        .btn-star {
            color: white;
            background-color: black;
            border: none;
            float: right;
        }

        .btn-star.gold {
            color: gold;
            border: none;
        }

        .card-body {
            color: white;
            border: none;
            width: 25%;
        }
    </style>
    <script>
        $().ready(function () {
            $.ajax({
                url: "getgames.php",
                success: function (data) {
                    let games = JSON.parse(data)
                    for (let game of games) {
                        if (game.is_in_wishlist) {
                            $("#games").append(`
    <div class="card-body">
        <img src="${game.image}" class="card-img-top">
        <button class="btn-star gold" onclick="toggleStar(this, ${game.id})" data-gameid="${game.id}">&#9734;</button>
        <h5 class="card-title">${game.name}</h5>
        <p class="card-text">${game.price}</p>
        <a href="#" class="btn btn-primary btn-add-to-cart" onclick="addToCart(this, ${game.id})">Add to cart</a>
    </div>
`);
                        }
                    }
                }
            });
        });
        function toggleStar(btn, gameid) {
            btn.classList.toggle("gold");
            $.ajax({
                url: 'add_to_wishlist.php',
                data: { userid: "<?php echo $userid ?>", gameid: gameid }
            });
        }

        function addToCart(btn, gameid) {
            $.ajax({
                url: 'add_to_cart.php',
                data: { userid: "<?php echo $userid ?>", gameid: gameid }
            });
        }

        function myFunction() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
</body>

</html>