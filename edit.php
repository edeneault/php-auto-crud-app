<?php
session_start();
require_once "pdo.php";
// Demand a GET parameter
if ( ! isset($_SESSION['email']) || strlen($_SESSION['email']) < 1  ) {
    die('Name parameter missing');
}

if (isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year']) && isset($_POST['mileage'])
    && isset($_POST['auto_id'])) {
      if (strlen($_POST['make']) < 1 && strlen($_POST['model'] < 1) ) {  // if the make and model is empty, has less than 1 character in the string
        $_SESSION["error"] = "Make is required.";
        header( 'Location: index.php' ) ;
        return;

      }
      elseif (!is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])) {  // mileage & year need to be integers

            $_SESSION["error"] = "Mileage and year must be numeric.";
            header( 'Location: index.php' ) ;
            return;
      }
      else {
      $sql = "UPDATE autos SET make = :mk, model = :md, year= :yr, mileage= :mi WHERE auto_id = :auto_id";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(
        ':mk' => $_POST['make'],
        ':md' => $_POST['model'],
        ':yr' => $_POST['year'],
        ':mi' => $_POST['mileage'],
        ':auto_id' => $_POST['auto_id']));
      $_SESSION['success'] = 'Record updated';
      header('Location: index.php');
      return;
  }
}

  $stmt = $pdo->prepare("SELECT * FROM autos where auto_id = :auto_id");
  $stmt->execute(array(':auto_id' => $_GET['auto_id']));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  if ( $row === false) {
    $_SESSION['error'] = 'Bad value for auto_id';
    header('Location: index.php');
    return;
  }
$mk = htmlentities($row['make']);
$md = htmlentities($row['model']);
$yr = htmlentities($row['year']);
$mi = htmlentities($row['mileage']);
$auto_id = $row['auto_id'];
?>

<!DOCTYPE html>
  <html>
  <head>

  <title>Etienne Deneault's Automobile Tracker</title>

  <?php require_once "bootstrap.php"; ?>

  </head>

  <body>

  <div class="container">
    <div class="jumbotron bg1">




      <p>Edit User</p>
      <form method="post">
        <p>Make: <input type="text"  name="make" value="<?=$mk ?>"></p>
        <p>Model: <input type="text"  name="model" value="<?= $md ?>"></p>
        <p>Year: <input type="text"  name="year" value="<?= $yr ?>"></p>
        <p>Mileage: <input type="text"  name="mileage" value="<?= $mi ?>"></p>
        <input type="hidden" name="auto_id" value="<?= $auto_id ?>">
        <p><input type="submit" value="Save"/>
        <a class="style-1" href="index.php">Cancel</a></p>
      </form>

    </div>
  </div>

  </body>
  </html>
