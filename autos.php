<?php
require_once "pdo.php";

// Demand a GET parameter
if ( ! isset($_GET['name']) || strlen($_GET['name']) < 1  ) {
    die('Name parameter missing');
}

// If the user requested logout go back to index.php
if ( isset($_POST['logout']) ) {
    header('Location: index.php');
    return;
}


$failure = false;  // If we have no POST data

if ( isset($_POST['make']) && isset($_POST['year'])
    && isset($_POST['mileage'])) {
    if (is_numeric($_POST['year']) && is_numeric($_POST['mileage']) && strlen($_POST['make']) > 1) {
      $sql = "INSERT INTO autos (make, year, mileage)
      VALUES (:mk, :yr, :mi)";
      echo("<pre>\n".$sql."\n</pre>\n");
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(
           ':mk' => $_POST['make'],
           ':yr' => $_POST['year'],
           ':mi' => $_POST['mileage']));
      echo '<span style="color:green;text-align:center;">Record Inserted</span>';}
      else {
          // echo ("Mileage and year must be numeric");
          $failure = "Mileage and Year must be numeric, Make is required and can only be letters";

      }
}


if ( isset($_POST['delete']) && isset($_POST['auto_id']) ) {
    $sql = "DELETE FROM autos WHERE auto_id = :zip";
    echo "<pre>\n$sql\n</pre>\n";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':zip' => $_POST['auto_id']));
}

$stmt = $pdo->query("SELECT make, year, mileage, auto_id FROM autos ORDER BY make");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html>
<head>

<title>Etienne Deneault's Automobile Tracker</title>

<?php require_once "bootstrap.php"; ?>


</head>
<body>
<div class="container">
  <div class="jumbotron">
    <h1>Tracking Autos for <a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="6564656e6561756c7440676d61696c2e636f6d">[email&#160;protected]</a></h1>
    <form method="post">
    <p>Make:
    <input type="text" name='make' size="60"/></p>
    <p>Year:
    <input type="text" name='year'/></p>
    <p>Mileage:
    <input type="text" name='mileage'/></p>
    <input type="submit" value='Add'>
    <input type="submit" name='logout' value="Logout">
    </form>
    <?php
    // Note triple not equals and think how badly double
    // not equals would work here...
    if ( $failure !== false ) {
        // Look closely at the use of single and double quotes
        echo('<p style="color: red;">'.htmlentities($failure).'</p>');
    }
    ?>
    <h2>Automobiles</h2>
    <table border="2">
    <?php

    foreach ( $rows as $row ) {
        echo "<tr><td>";
        echo(htmlentities($row["make"]));
        echo("</td><td>");
        echo(htmlentities($row["year"]));
        echo("</td><td>");
        echo(htmlentities($row["mileage"]));
        echo("</td><td>");
        echo('<form method="post"><input type="hidden" ');
        echo('name="auto_id" value="'.$row["auto_id"].'">'."\n");
        echo('<input type="submit" value="Del" name="delete">');
        echo("\n</form>\n");
        echo("</td></tr>\n");
    }
    ?>
    </table>
  </div>
</div>
<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script></body>
</html>
