<?php
// Include the configuration file for the database
require "dbconfig.php";

// Connect to the database server
$sqlconn = connectToSql();

// Create the database if it does not exist
createDb($sqlconn);

// Connect to the desired database
$dbconn = connectToDb();
?>

<!-- Begin the HTML document -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Games</title>
    <link rel="icon" href="images/main/icon.svg">
    </link>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    </link>
    <!-- Include jQuery -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
</head>

<body style="background-color:black;">
    <!-- Navigation bar -->
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

    <!-- Main content of the page -->
    <div
        style="width: 100%; height: 100%; background-image: url('images/main/games.svg'); background-repeat: no-repeat; background-size: 100% 70%; height: 80vh; background-attachment: fixed;">
        <!-- Container for the game cards -->
        <div class="row" id="games" style="max-width:100%"></div>
    </div>


    <!-- Styling for the page -->
    <style>
        .navbar {
            background-color: black;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 9999;
        }

        .card-body {
            color: white;
            border: none;
            max-width: 20%;
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
    </style>
    <script>
        function checkLogin(event) {
            if (!<?php echo json_encode($userid); ?>) {
                event.preventDefault();
                alert("Please login or sign up to checkout.");
            }
        }
        $().ready(function () {
            // When the document is ready, make an AJAX request to get the list of games
            $.ajax({
                url: "getgames.php",
                success: function (data) {
                    // On success, parse the JSON data into an array of game objects
                    let games = JSON.parse(data)
                    // Loop through each game and generate a card for it
                    for (let game of games) {
                        // Determine the appropriate CSS class for the wishlist star button and cart button
                        let starClass = game.is_in_wishlist ? 'btn-star gold' : 'btn-star';
                        let cartClass = game.is_in_cart ? 'btn-danger' : 'btn-primary';
                        // Determine the appropriate text and onclick function for the cart button
                        let cartText = game.is_in_cart ? 'Remove from cart' : 'Add to Cart';
                        let cartAtr = game.is_in_cart ? 'removeFromCart' : 'addToCart';
                        // Append the HTML for the game card to the games div
                        $("#games").append(`
    <div class="card-body">
        <img src="${game.image}" class="card-img-top">
        <button class="${starClass}" onclick="toggleStar(this, ${game.id})" data-gameid="${game.id}">&#9734;</button>
        <h5 class="card-title">${game.name}</h5>
        <p class="card-text">${game.description}</p>
        <p class="card-text">${game.price}$</p>
        <a href="#" class="btn ${cartClass}" onclick="${cartAtr}(this, ${game.id})">${cartText}</a>
    </div>
`);
                    }
                }
            });
        });
        // This function toggles the gold class of a star button when clicked and sends an AJAX request to add or remove the game from the wishlist
        function toggleStar(btn, gameid) {
            var userid = "<?php echo $userid ?>";
            if (!userid) {
                alert("You must login or sign up to add items to your wishlist.");
                return;
            }
            btn.classList.toggle("gold");
            $.ajax({
                url: 'add_to_wishlist.php',
                data: { userid: "<?php echo $userid ?>", gameid: gameid }
            });
        }

        function addToCart(btn, gameid) {
            var userid = "<?php echo $userid ?>";
            if (!userid) {
                alert("You must login or sign up to add items to your cart");
                return;
            }
            $.ajax({
                url: 'add_to_cart.php',
                data: { userid: userid, gameid: gameid },
                success: function () {
                    console.log("Added game with ID " + gameid + " to cart");
                    $(btn).text("Remove from cart").removeClass("btn-primary").addClass("btn-danger").attr("onclick", `removeFromCart(this, ${gameid})`);
                },
                error: function (xhr, status, error) {
                    console.log("Error adding game with ID " + gameid + " to cart: " + error);
                }
            });
        }


        // This function sends an AJAX request to remove a game from the cart and updates the button to show "Add to cart" and change the class to indicate it can now be added again
        function removeFromCart(btn, gameid) {
            $.ajax({
                url: 'deletefromcart.php',
                data: { userid: "<?php echo $userid ?>", gameid: gameid },
                success: function () {
                    console.log("Removed game with ID " + gameid + " to cart");
                    $(btn).text("Add to cart").addClass("btn-primary").removeClass("btn-danger").attr("onclick", `addToCart(this, ${gameid})`);
                },
                error: function (xhr, status, error) {
                    console.log("Error adding game with ID " + gameid + " to cart: " + error);
                }
            });
        }

    </script>
</body>

</html>