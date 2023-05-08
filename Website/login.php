<?php
session_start();
if (isset($_GET['login_failed'])) {
  $errorMessage = 'Username or password incorrect';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="icon" href="images/main/icon.svg">
  </link>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  </link>
</head>

<body style="background-color:black;">
  <nav class="navbar navbar-expand-lg bg-body-tertiary"
    style="border: 2px dashed white; position: sticky; top: 0; left: 0; width: 100%; z-index: 9999;">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php"><img src="images/main/logo.svg" title="Home" width="100" height="100"
          class="d-inline-block align-text-top"></a>
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

  <div class="login-form">
    <h1>Login (Dummy: dum dum)</h1>
    <?php if (isset($errorMessage)): ?>
      <div class="error">
        <?php echo $errorMessage ?>
      </div>
    <?php endif; ?>

    <form action="authenticate.php" method="post">
      <label for="username">Username / Email:</label>
      <input type="text" id="username" name="username" required autocomplete="off"
        placeholder="Enter your username or email"><br><br>

      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required autocomplete="off"
        placeholder="Enter your password"><br><br>

      <input type="submit" value="Login">
    </form>
  </div>
  <footer style="color:white">
    To access admin page log in with username and password admin.
  </footer>
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

    .login-form {
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

    .login-form h1 {
      margin-bottom: 20px;
    }

    .login-form form {
      width: 400px;
      padding: 30px;

    }

    .login-form input[type="text"],
    .login-form input[type="email"],
    .login-form input[type="password"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      box-sizing: border-box;
      border-radius: 25px;
    }

    .login-form input[type="submit"] {
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
  </script>
</body>

</html>