<?php // Do not put any HTML above this line
session_start();
require_once "pdo.php";

$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';

if ( isset($_POST['cancel'] ) ) {
    // Redirect the browser to game.php
    header("Location: index.php");
    return;
}

if ( isset($_POST["email"]) && isset($_POST["pass"]) ) {
    unset($_SESSION["email"]);  // Logout current user
    if ( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1 ) {
        $_SESSION["error"] = "User name and password are required";
        header( 'Location: login.php' ) ;
        return;
    }
    elseif (strpos($_POST ['email'], "@") < 1) {
        $_SESSION["error"] = "Email requires to contain @";
        header( 'Location: login.php' ) ;
        return;
    }
    else {
        $check = hash('md5', $salt.$_POST['pass']);
        if ( $check == $stored_hash ) {
            // Redirect the browser to view.php
            $_SESSION["email"] = $_POST['email'];
            $_SESSION["pass"] = hash('md5', $salt.$_POST['pass']);
            $_SESSION["success"] = "Logged in.";
            header("Location: index.php");
            error_log("Login success ");
            return;

        } else {
          $_SESSION["pass"] = hash('md5', $salt.$_POST['pass']);
          $_SESSION["error"] = "Incorrect password.";
          header( 'Location: login.php' ) ;
          error_log("Login fail - incorrect password: ".$_SESSION['pass']);
          return;
        }
    }
}

// Fall through into the View
?>
<!DOCTYPE html>
<html>
<head>
<?php require_once "bootstrap.php"; ?>
<title>Etienne Deneault</title>
</head>
<body>
<div class="container">
  <div class="jumbotron bg">
    <h1>Please Log In</h1>

        <?php
            if ( isset($_SESSION["error"]) ) {
                echo('<p style="color:red">'.$_SESSION["error"]."</p>\n");
                unset($_SESSION["error"]);
            }
        ?>

    <form method="POST">
    <label for="email">Account</label>
    <input type="text" name="email"><br/>
    <label for="id_1723">Password</label>
    <input type="text" name="pass"><br/>
    <input type="submit" value="Log In">
    <input type="submit" name="cancel" value="Cancel">
    <?php

        if ( isset($_POST['cancel'] ) ) {
            $_SESSION["cancel"] = $_POST["cancel"];
            unset($_SESSION["cancel"]);  // flash cancel
            header("Location: index.php");
            return;
        }
    ?>
    </form>
    <p>
    For a password hint, view source and find a password hint
    in the HTML comments.
    <!-- Hint: The password is the three charater programing langua
    makes (all lower case) followed by 123. -->
    </p>
  </div>
</div>
</body>
