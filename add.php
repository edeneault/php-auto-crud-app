<?php
    session_start();
    require_once "pdo.php";

    // Demand a GET parameter to access
    if ( ! isset($_SESSION['pass']) || strlen($_SESSION['email']) < 1  ) {
        die('Name parameter missing');
    }


    // If the user requested cancel go back to view.php
    if ( isset($_POST['cancel']) ) {
        header('Location: index.php');
        return;
    }

    if (isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year']) && isset($_POST['mileage'])) {
        // some input validations
        if (strlen($_POST['make']) < 1 && strlen($_POST['model'] < 1) ) {  // if the make and model is empty, has less than 1 character in the string
          $_SESSION["error"] = "All values are required";
          header( 'Location: add.php' ) ;
          return;

        }
        elseif (!is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])) {  // mileage & year need to be integers

              $_SESSION["error"] = "Mileage and year must be numeric.";
              header( 'Location: index.php' ) ;
              return;
        }
        else {
            // data passes validation, add the automobile to the database
            $stmt = $pdo->prepare('INSERT INTO autos (make, model, year, mileage) VALUES ( :mk, :md, :yr, :mi)');
            $stmt->execute(array(
                    ':mk' => $_POST['make'],
                    ':md' => $_POST['model'],
                    ':yr' => $_POST['year'],
                    ':mi' => $_POST['mileage'])
            );
            // echo '<span style="color:green;text-align:center;">Record Inserted</span>';}
            $_SESSION["success"] = "added";
            header( 'Location: index.php' ) ;
            return;
        }
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
    <?php
    if ( isset($_SESSION["success"]) ) {
        echo('<p style="color:green">'.$_SESSION["success"]."</p>\n");
        unset($_SESSION["success"]);
    }

    if ( isset($_SESSION["error"]) ) {
        echo('<p style="color:red">'.$_SESSION["error"]."</p>\n");
        unset($_SESSION["error"]);
    }
    ?>
    <h1>Tracking Future Vehicles</h1>
    <h3><em>Add a new crazy cool vehicle<em></h3>

    <form method="post">
    <p>Make:
    <input type="text" name='make' size="60"/></p>
    <p>Model:
    <input type="text" name='model' size="60"/></p>
    <p>Year:
    <input type="text" name='year'/></p>
    <p>Mileage:
    <input type="text" name='mileage'/></p>

    <input  type="submit" value='Add'>
    <input href="index.php" type="submit" name="cancel" value="Cancel">
    </form>
  </div>
</div>

</body>

</html>
