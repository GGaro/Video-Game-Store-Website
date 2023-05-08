<?php
session_start();
if (isset($_GET['error'])) {
    $errorMessage = '';
    switch ($_GET['error']) {
        case 'userexist':
            $errorMessage = 'Username or email already exists';
            break;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign-Up</title>
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
            $userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : null;
            if ($userid !== null) {
                include 'nav-logged-in.php';
            } else {
                include 'nav-not-logged-in.php';
            }
            ?>
        </div>
    </nav>

    <div class="signup-form">
        <h1>Sign Up</h1>
        <?php if (isset($errorMessage)): ?>
            <div class="error">
                <?php echo $errorMessage ?>
            </div>
        <?php endif; ?>

        <form action="register.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required autocomplete="off"><br><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required autocomplete="off"><br><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required autocomplete="off"><br><br>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required autocomplete="off"><br><br>

            <input type="submit" value="Sign Up">
            <input type="button" value="Dummy Data" onclick="addDummyUsers()">
        </form>
    </div>

    <style>
        .error {
            color: red;
        }

        .navbar {
            position: sticky;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 9999;
        }

        .signup-form {
            background-image: url('');
            background-repeat: no-repeat;
            background-size: 100% 70%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 80vh;
            color: white;
        }

        .signup-form h1 {
            margin-bottom: 20px;
        }

        .signup-form form {
            width: 400px;
            padding: 30px;
        }

        .signup-form input[type="text"],
        .signup-form input[type="email"],
        .signup-form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            box-sizing: border-box;
            border-radius: 25px;
        }

        .signup-form input[type="submit"] {
            margin: 0 auto;
            display: block;
            border-radius: 25px;
        }

        .signup-form input[type="button"] {
            margin: 0 auto;
            display: block;
            border-radius: 25px;
        }
    </style>

    <script>
        function checkLogin(event) {
            if (!<?php echo json_encode($userid); ?>) {
                event.preventDefault();
                alert("Please login or sign up to checkout.");
            }
        }
        const passwordField = document.getElementById('password');
        const confirmPasswordField = document.getElementById('confirm_password');
        const submitButton = document.getElementById('signup_button');

        function checkPassword() {
            if (passwordField.value != confirmPasswordField.value) {
                confirmPasswordField.setCustomValidity('Passwords do not match.');
                submitButton.disabled = true;
            } else {
                confirmPasswordField.setCustomValidity('');
                submitButton.disabled = false;
            }
        }

        confirmPasswordField.addEventListener('input', checkPassword);

        function addDummyUsers() {
            window.location.href = "register.php?dummy_data=true";
        }
    </script>
</body>

</html>