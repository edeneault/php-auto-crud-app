<?php
session_start();
require_once "pdo.php";


// Demand a GET parameter to access
if ( ! isset($_SESSION['pass']) || strlen($_SESSION['email']) < 1  ) {
    die('Name parameter missing');
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
      ?>
      <h1>Welcome to the Automobiles Database</h1>
      <h2>Vehicles of the Future</h2>
      <table border="2">
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
              echo('<form method="post"><input type="hidden" ');
              echo('name="auto_id" value="'.htmlentities($row["auto_id"]).'">'."\n");
              echo('<input type="submit" value="Del" name="delete">');
              echo("\n</form>\n");
              echo("</td></tr>\n");
          }
        ?>
        </table>

        <a href="add.php">Add New</a> |
        <a href="logout.php">Logout</a>

      </div>
    </div>
</body>
