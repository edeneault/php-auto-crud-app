<?php
session_start();
require_once "pdo.php";

// Demand a GET parameter to access
if ( ! isset($_SESSION['pass']) || strlen($_SESSION['email']) < 1  ) {
  header( 'Location: loginportal.php' ) ;
  return;
}


// Incoming parameter is a GET so nothing isset in POST, this section is skipped during the first load

if ( isset($_POST['delete']) && isset($_POST['auto_id']) ) {
    $sql = "DELETE FROM autos WHERE auto_id = :zip";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':zip' => $_POST['auto_id']));
    $_SESSION['success'] = 'Record deleted';
    header('Location: index.php');
    return;
}

// Guardian:  Check if auto_id is present

if ( ! isset($_GET['auto_id']) ) {
  $_SESSION['error'] = 'Missing auto_id';
  header('Location: index.php');
  return;
}

$stmt = $pdo->prepare("SELECT make, model, year, mileage, auto_id FROM autos where auto_id = :zip");
$stmt->execute(array(':zip' => $_GET['auto_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false) {
  $_SESSION['error'] = 'Bad value for auto_id';
  header('Location: index.php');
  return;
}
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
    <p>Confirm Deleting: <?= htmlentities($row['make'])." ".htmlentities($row['model'])." ".htmlentities($row['year']." ".htmlentities($row['mileage'])) ?></p>
    <form method="post"><input type="hidden"
      name="auto_id" value="<?=$row['auto_id']?>">
      <input type="submit" value="Delete" name="delete">
      <a class="style-1" href="index.php">Cancel</a>
    </form>

  </div>
</div>

</body>
</html>
