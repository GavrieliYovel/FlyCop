<?php
include "config.php";
include "urldefine.php";
session_start();

if(isset($_POST['delete'])) {
    $query2  = "DELETE FROM tbl_violation_209 WHERE violationId= " . $_POST["vioId"] ;
    mysqli_query($connection, $query2);
    header('Location: '. URL .'violationlist.php');
}

if(isset($_POST["confirm"])) {
    $query1 = "UPDATE tbl_violation_209 SET 
                                        details= '" . $_POST["vDetails"] . "', 
                                        type ='" . $_POST["vType"] . "', 
                                        severity= " . $_POST["vSeverity"] . ",  
                                        carNumber= " . $_POST["vCarNumber"] . ", 
                                        timeV= '" . $_POST["vTime"] . "',
                                        dateV= '" . $_POST["vDate"] . "' WHERE violationId= ". $_POST["vioId"];

    mysqli_query($connection, $query1);
}

//   if(isset($_POST['delete'])) {
//     $query3  = "DELETE FROM tbl_activeDrones_209 where missionId= " . $_POST["mission"] ;
//     mysqli_query($connection, $query3);
//     $query4 = "UPDATE tbl_drones_209 SET isAssign = 0 WHERE droneId =" . $_POST["drone"];
//     mysqli_query($connection, $query4);
//     header('Location: '. URL .'dronelist.php');
//   }


$vioId = $_GET["vId"];
$query  = "SELECT * FROM tbl_violation_209  WHERE violationId=" . $vioId;
$result = mysqli_query($connection, $query);
if ($result) {
    $violation = mysqli_fetch_assoc($result);
} else die("DB query failed.");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css" />
    <title>Violation #<?php echo $violation["violationId"] ?></title>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php"></a>
            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header ">
                    <h5 class="offcanvas-title text-white" id="offcanvasNavbarLabel">Menu</h5>
                    <button type="button" class="btn-close text-reset bg-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav flex-grow-1 pe-3" <?php if (!isset($_SESSION["user"])) echo 'style="display: none;"';
                                                            else echo 'style:"display: flex"'; ?>>
                        <li class="nav-item">
                            <a class="nav-link " href="createobject.php">New Mission</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="dronelist.php">Active Drones</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Violations</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div id="person" <?php if (!isset($_SESSION["user"])) echo 'style="display: none;"';
                                else echo 'style:"display: flex"'; ?>>
                <?php
                echo '<img id="personImg" src="' . $_SESSION["img"] . '" alt="">';
                echo '<div class="text-white">';
                echo '<h5>' . $_SESSION["fName"] . ' ' . $_SESSION["lName"] . '</h5>';
                echo '<p>' . $_SESSION["rName"] . '</p>';
                ?>
                <div class="d-flex">
                    <!-- <a href="#"><i class="bi bi-person-circle"></i></a>
                    <a href="#"><i class="bi bi-gear-fill"></i></a> -->
                    <a href="logout.php"><i class="bi bi-door-closed-fill"></i></a>
                </div>
            </div>
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>

    <main>
        <!-- breadcrumbs -->
        <ul class="breadcrumbs">
            <li><i class="bi bi-caret-right"></i></i><a href="index.php">Home Screen</a></li>
            <li><i class="bi bi-caret-right"></i></i><a href="violationlist.php">Active Drones</a></li>
            <li><i class="bi bi-caret-right"></i></i><a href="#">Violation #<?php echo $vioId ?></a></li>
        </ul>

        <div id="mainObjContent">
            <h1>Violation #<?php echo $vioId ?></h1>
            <form action="#" method="POST">
                <div class="d-flex justify-content-between grayBack flex-wrap" id="missSet">
                    <div>
                        <p><b>Drone Id:</b>
                            #<?php echo $violation["droneId"]; ?>
                        </p>
                        <p><b>Time:</b>
                            <?php if (!isset($_POST["edit"]))
                                echo ' ' .  $violation["timeV"];
                            else {
                                echo '<input type="time" name="vTime"';
                                echo 'value="' . $violation["timeV"] . '">';
                            }
                            ?>
                        </p>
                        <div class="d-flex">
                            <p><b>Severity:</b> </p>

                            <?php
                            if (!isset($_POST["edit"])) {
                                switch ($violation["severity"]) {
                                    case 1:
                                        echo '<img  src="images/signGr.png" class ="signIcn"> <p> Low</p>';
                                        break;
                                    case 2:
                                        echo '<img  src="images/signYel.png" class ="signIcn"> <p>Medium</p>';
                                        break;
                                    case 3:
                                        echo '<img  src="images/signRed.png" class ="signIcn"> <p>High</p>';
                                        break;
                                }
                            } else {
                                echo '<select name="vSeverity">';
                                echo '<option value="1"';
                                if ($violation["severity"] == 1) {
                                    echo 'selected';
                                }
                                echo '>Low</option>';
                                echo '<option value="2"';
                                if ($violation["severity"] == 2) {
                                    echo 'selected';
                                }
                                echo '>Medium</option>';
                                echo '<option value="3"';
                                if ($violation["severity"] == 3) {
                                    echo 'selected';
                                }
                                echo '>High</option>';
                                echo '</select>';
                            }

                            ?>
                        </div>
                    </div>
                    <div>
                        <p>
                            <b>Car Number: </b>
                            <?php if (!isset($_POST["edit"])) {
                                echo $violation["carNumber"];
                            } else
                                echo '<input type="number" name="vCarNumber" value="' . $violation["carNumber"] . '">'; ?>
                        </p>
                        <p>
                            <b>Date:</b>
                            <?php if (!isset($_POST["edit"])) {
                                echo ' ' . $violation["dateV"];
                            } else {
                                echo '<input type="date" name="vDate" value="' . $violation["dateV"] . '">';
                            } ?>
                        </p>
                        <p><b> Violation Type: </b>
                            <?php
                            if (!isset($_POST["edit"])) {
                                echo  ' ' . $violation["type"];
                            } else {
                                echo '<input type="text" name="vType" value="' . $violation["type"] . '">';
                            } ?></p>

                    </div>
                    <div class="w-25"></div>
                </div>


                <h5><b>Violation Description:</b> </h5>
                <div class="grayBack w-100 h-100">
                    <?php if (!isset($_POST["edit"])) {
                        echo '<p>' . $violation["details"] . '</p>';
                    } else {
                        // echo '<input class="w-100" name= "vDetails" type="text" value="' . $violation["details"] . '">';
                        echo '<textarea name="vDetails" rows="4" cols="50">'.$violation["details"].'</textarea>';
                    }

                    ?>
                </div>
                <input type=hidden name="vioId" value=" <?php echo $violation["violationId"] ?>">
        </div>

        <div class="buttonGroup d-flex justify-content-center">
            <?php
            if (!isset($_POST["edit"]))
                echo '<button class="btn btn-primary btn-md" name="edit">Edit</button>';
            else {
                echo '<button class="btn btn-success btn-md" type="submit" name= "confirm">Confirm</button>';
                echo '<button class="btn btn-warning btn-md" type="submit" name ="cancel">Cancel</button>';
                echo '<button class="btn btn-danger btn-md" type="submit" name="delete" id="check">Delete</button>';
            }
            ?>
        </div>
        </form>

    </main>
    <?php
    mysqli_free_result($result);

    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="scripts/mainobjscript.js"></script>
</body>

</html>
<?php
mysqli_close($connection);
?>