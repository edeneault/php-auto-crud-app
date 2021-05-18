<?php
session_start();
require_once "pdo.php";


// Demand a GET parameter to access
if ( ! isset($_SESSION['pass']) || strlen($_SESSION['email']) < 1  ) {
  header( 'Location: loginportal.php' ) ;
  return;
}


if ( isset($_POST['delete']) && isset($_POST['auto_id']) ) {
    $sql = "DELETE FROM autos WHERE auto_id = :zip";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':zip' => $_POST['auto_id']));
}

$stmt = $pdo->query("SELECT make, model, year, mileage, auto_id FROM autos ORDER BY make");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>

<title>Etienne Deneault's Imaginary Vehicle Database</title>

<?php require_once "bootstrap.php"; ?>


</head>

<body>
  <div class="container">
    <div class="jumbotron bg">
      <?php
          if ( isset($_SESSION["success"]) ) {
              echo('<p style="color:green">'.htmlentities($_SESSION["success"])."</p>\n");
              unset($_SESSION["success"]);
          }
          if ( isset($_SESSION["error"]) ) {
              echo('<p style="color:red">'.$_SESSION["error"]."</p>\n");
              unset($_SESSION["error"]);
          }
      ?>

      
      <h1>Welcome to the Automobiles Database</h1>
      <h2>Vehicles of the Future</h2>
      <table text-align="center" border="2">
        <tr>
          <th>Make</th>
          <th>Model</th>
          <th>Year</th>
          <th>Mileage</th>
          <th>Actions</th>
        </tr>
      <?php

          foreach ( $rows as $row ) {

              echo "<tr><td>";
              echo(htmlentities($row["make"]));
              echo("</td><td>");
              echo(htmlentities($row["model"]));
              echo("</td><td>");
              echo(htmlentities($row["year"]));
              echo("</td><td>");
              echo(htmlentities($row["mileage"]));
              echo("</td><td>");
              echo('<a class="style-1" href="edit.php?auto_id='.$row["auto_id"].'">Edit</a> / ');
              echo('<a class="style-1" href="delete.php?auto_id='.$row["auto_id"].'">Delete</a>');
              echo("</td></tr>\n");
          }
        ?>
        </table>

        <a class="style-1" href="add.php"><strong>Add New Entry</strong></a> |
        <a class="style-1" href="logout.php"><strong>Logout</strong></a>

      </div>
    </div>
</body>
