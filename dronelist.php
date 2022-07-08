<?php
    session_start();
    if (!isset($_SESSION["role"])) {
        header('Location: http://localhost/finalDeployment');
    } 
    elseif($_SESSION["role"] != 1) {
        header('Location: http://localhost/finalDeployment');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" rel="stylesheet">
    <title>Active Drone</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.html"></a>
            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header ">
                    <h5 class="offcanvas-title text-white" id="offcanvasNavbarLabel">Menu</h5>
                    <button type="button" class="btn-close text-reset bg-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link " href="#">New Mission</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Active Drones</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Violations</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div id="person">
                <img id="personImg" src="images/haim.png" alt="">
                <div class="text-white">
                    <h5>Haim</h5>
                    <p>traffic police officer</p>  
                    <div class="d-flex">
                        <a href="#"><i class="bi bi-person-circle"></i></a>
                        <a href="#"><i class="bi bi-gear-fill"></i></a>
                        <a href="#"><i class="bi bi-door-closed-fill"></i></a>
                    </div>
                </div>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

        </div>
      </nav>
    <ul class="breadcrumbs">
        <li><i class="bi bi-caret-right"></i></i><a href="index.html">Home Screen</a></li>
        <li><i class="bi bi-caret-right"></i></i><a href="#">Active Drones</a></li>
    </ul>
    <div id="listWrapper">   
        <div class="d-flex justify-content-between">
            <h1>Active Drones</h1>
            <a href="createobject.php"><i class="fs-2 bi bi-plus-square"></i></a>
        </div>
        <?php 
            include "config.php";
            // get all data from DB
            $query  = "SELECT * FROM tbl_activeDrones_209 INNER JOIN tbl_users_209 using(user_id)";
            $result = mysqli_query($connection, $query);

            if(!$result) {
              die("DB query failed.");
            }
            while($row = mysqli_fetch_assoc($result))
            {
              echo '<div class="droneObject">';
              echo    '<a class="droneObject" href="mainobject.php?mission_id='. $row["missionId"] .'">';
              echo      '<img class="imgStyle" src="images/drone.png" alt="">';
              echo      '<div class="col-9">';
              echo         '<h4>Drone #' .$row["droneId"] .'</h4>';
              echo         '<table class="tableStyle">';
              echo            '<tr>';
              echo               '<th>Mission: </th><td>'.$row["missionType"].'</td>';
              echo               '<th>Violation Detected: </th><td>'.$row["violationDeteced"].'</td>';
              echo            '</tr>';
              echo            '<tr>';
              echo               '<th>Set by: </th><td>'.$row["firstName"].'</td>';
              echo               '<th>Time: </th><td>'.$row["startTime"].' - '.$row["endTime"] .'</td>';
              echo            '</tr>';
              echo         '</table>';
              echo      '</div>';
              echo '</div>';
              echo '<hr class="my-4">';
            }
            
          ?>
    </div>
    <?php
     mysqli_free_result($result);
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>

<?php 
  mysqli_close($connection);
?>