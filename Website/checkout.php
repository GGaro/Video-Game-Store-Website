<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="icon" href="images/main/icon.svg">
    </link>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    </link>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
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
        style="width: 100%; height: 100%; background-image: url('images/main/games.svg'); background-repeat: no-repeat; background-size: 100% 70%; height: 80vh; background-attachment: fixed;">
        <h1 style="color:white;">Cart:</h1>
        <div class="row" id="games" style="max-width:70%; color:white;">

        </div>

    </div>
    </label>

    </div>
    <div class="cart-summary"
        style="position: fixed; top: 150px; right: 50px; background-color: #fff; padding: 20px; border-radius: 10px;">
        <h2>Cart Summary</h2>
        <hr>
        <div class="cart-total">
            Total: $0.00
        </div>
        <button class="btn btn-lg btn-primary checkout-btn" style="display: none;">Purchase</button>
    </div>




    <style>
        .navbar {
            background-color: black ;
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

        .checkout-btn {
            display: block;
            margin: 20px auto 0;
            background-color: black;
            color: gold;
            border: none;
            border-radius: 20px;
            padding: 10px 20px;
            font-size: 20px;
        }

        .checkout-btn:hover {
            background-color: gold;
            color: black;
        }
    </style>
    <script>
        $().ready(function () {
            $.ajax({
                url: "getcart.php",
                success: function (data) {
                    let cart = JSON.parse(data);
                    for (let game of cart) {
                        $("#games").append(`
                        <div class="card-body">
        <img src="${game.image}" class="card-img-top">
        <h5 class="card-title">${game.name}</h5>
        <p class="card-text">${game.description}</p>
        <p class="card-text">${game.price}$</p>
                <button class="btn btn-danger btn-remove-from-cart" onclick="removeFromCart(this, ${game.id})">Remove from cart</button>
            </div>
        `);
                    }
                }
            });
            updateCartSummary();
        });

        function checkLogin(event) {
            if (!<?php echo json_encode($userid); ?>) {
                event.preventDefault();
                alert("Please login or sign up to checkout.");
            }
        }

        function updateCartSummary() {
            $.ajax({
                url: "getcart.php",
                success: function (data) {
                    let cart = JSON.parse(data);
                    let total = 0;
                    for (let game of cart) {
                        total += parseFloat(game.price);
                    }
                    $(".cart-total").text("Total: $" + total.toFixed(2));
                    // Check if total is greater than 0
                    if (total > 0) {
                        // Show checkout button
                        $(".checkout-btn").show();
                    } else {
                        // Hide checkout button
                        $(".checkout-btn").hide();
                        $("#games").append(`<h2 style="margin-left:50px;">Your cart is empty.</h2>`);
                    }
                }
            });
        }


        function removeFromCart(button, gameid) {
            // Make an AJAX request to remove the product from the cart
            $.ajax({
                url: "deletefromcart.php",
                data: { userid: "<?php echo $userid ?>", gameid: gameid },
                success: function () {
                    console.log("Removed game with ID " + gameid);
                    // Remove the parent element of the button (i.e. the card-body div)
                    $(button).parent().remove();
                    updateCartSummary(); // Move this call inside the success callback
                },
                error: function (xhr, status, error) {
                    console.log("Error removing game with ID " + gameid + ": " + error);
                }
            });
        }

        $('.checkout-btn').on('click', function () {
            let estimatedTime = new Date(Date.now() + 7 * 24 * 60 * 60 * 1000)
                .toLocaleString([], { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric' });

            alert('Thank you for your purchase! The estimated time for arrival is ' + estimatedTime);
        });

    </script>
</body>

</html>