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
  <title>Flycop HomePage</title>
</head>

<body>
  <?php
  include "config.php";
  include "urldefine.php";
  session_start();
  if (!isset($_SESSION["user"])) {
    if (!empty($_POST["loginMail"])) {

      $query  = "SELECT * FROM tbl_users_209 INNER JOIN tbl_roles_209 USING (roleId) where email ='" . $_POST["loginMail"] . "' and password = '" . $_POST["loginPass"] . "'";

      $result = mysqli_query($connection, $query);

      if (!$result) {
        die("DB query failed.");
      }

      $row = mysqli_fetch_assoc($result);
      if (is_array($row)) {
        $_SESSION["user"] = $row["user_id"];
        $_SESSION["role"] = $row["roleId"];
        $_SESSION["img"] = $row["img"];
        $_SESSION["lName"] = $row["lastName"];
        $_SESSION["fName"] = $row["firstName"];
        $_SESSION["rName"] = $row["roleName"];
      } else
        $message = "Invalid username or password!";
    }
  } 
  
    if(isset($_SESSION["role"])){ 
      $missionQuery = "SELECT * FROM tbl_activeDrones_209 LIMIT 3";
      $result = mysqli_query($connection, $missionQuery);
      if (!$result) {
        die("DB query failed.");
      }
    }
  

  ?>
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
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" <?php if (!isset($_SESSION["user"])) echo 'style="display: none;"';
                          else echo 'style:"display: flex"'; ?>>
        <span class="navbar-toggler-icon"></span>
      </button>
    </nav>

  <main>
    <!-- breadcrumbs -->
    <ul class="breadcrumbs">
      <li><i class="bi bi-caret-right"></i></i><a href="#">Home Screen</a></li>
    </ul>
    <div id="mainObjContent">
      <h1>Welcome To FlyCop <?php if (isset($_SESSION["user"])) echo ', ' . $_SESSION["fName"]; ?> </h1>
      <div class="homeDiv grayBack" <?php if (isset($_SESSION["user"])) echo 'style="display: none;"'; ?>>
        <h1>Login</h1>
        <form action="#" method="post" id="frm">
          <div class="form-group">
            <label for="loginMail">Email: </label>
            <input type="email" class="form-control" name="loginMail" id="loginMail" aria-describedby="emailHelp" placeholder="Enter email">
          </div>
          <div class="form-group">
            <label for="loginPass">Password: </label>
            <input type="password" class="form-control" name="loginPass" id="loginPass" placeholder="Enter Password">
          </div>
         
          <button type="submit" class="btn btn-secondary loginButton">Log Me In</button>
          
          <div class="error-message"><?php if (isset($message)) {
              echo $message;
            } ?>
          </div>
        </form>
      </div>

      <div class="homeDiv grayBack" <?php if (!isset($_SESSION["role"])) {
                                echo 'style = "display:none;"';
                              } else {
                                if ($_SESSION["role"] == 1) {
                                  echo 'style="display: block;"';
                                } else echo 'style = "display:none;"';
                              }
                              ?>>
        <button class="grayBtn align-self-start"><i class="bi bi-arrow-left-right"></i></button>
        <h4 class="row align-self-end justify-content-center">Quick Actions</h4>
        <div class="d-flex justify-content-evenly">
          <div class="d-flex flex-column justify-content-center align-items-center ">
            <img src="images/drone1.png" class="quickIcn">
            <h6>New</h6>
            <h6>patrol</h6>
          </div>

          <div class="d-flex flex-column justify-content-center align-items-center ">
            <img src="images/car.png" class="quickIcn">
            <h6>Locate</h6>
            <h6>vehicle</h6>
          </div>


          <div class="d-flex flex-column justify-content-center align-items-center ">
            <img src="images/police.png" class="quickIcn">
            <h6>Issue</h6>
            <h6>report</h6>
          </div>
        </div>

      </div>

      <div class="grayBack homeDiv" <?php if (!isset($_SESSION["role"])) {
                                echo 'style = "display:none;"';
                              } else {
                                if ($_SESSION["role"] == 2) {
                                  echo 'style="display: flex;"';
                                } else echo 'style = "display:none;"';
                              }
                              ?>>
        <?php 
          if(isset($_SESSION["role"]) && $_SESSION["role"] == 2){
            while($row = mysqli_fetch_assoc($result))
            {
              echo '<div class="d-flex flex-column justify-content-center align-items-center ">';
              echo   '<img class="quickIcn" src="images/drone.png" alt="">';
              echo   '<h4>Mission#' .$row["missionId"] .'</h4>';
              echo   '<p>Drone#'. $row["droneId"].'</p>';
              echo '</div>';
            }
          }
        ?>

      </div>


      <div class="grayBack recentViolations" <?php if (!isset($_SESSION["user"])) echo 'style="display: none;"';
                                              else echo 'style:"display: block"'; ?>>
        <h4 class="row align-self-end justify-content-center">Recent Violations</h4>

        <div class="violations">
          <table class="w-100 ">

            <?php
            $queryViolations  = "SELECT * FROM tbl_violation_209 ORDER BY violationId DESC LIMIT 5";
            $Violations = mysqli_query($connection, $queryViolations);
            if (!$Violations) {
              die("DB query failed.");
            }

            while ($violation = mysqli_fetch_assoc($Violations)) {
              echo '<tr class="border-bottom border-dark align-items-end d-flex justify-content-between">';
              echo ' <td class="startLine">';
              switch ($violation["severity"]) {
                case 1:
                  echo '<img  src="images/signGr.png" class ="signIcn">' . $violation["type"] . '</td>';
                  break;
                case 2:
                  echo '<img  src="images/signYel.png" class ="signIcn">' . $violation["type"] . '</td>';
                  break;
                case 3:
                  echo '<img  src="images/signRed.png" class ="signIcn">' . $violation["type"] . '</td>';
                  break;
              }

              echo '<td>' . $violation["timeV"] . '</td>';
              echo '<td>' . $violation["dateV"] . '</td>';
              echo '</tr> ';
            }
            ?>
          </table>
        </div>

      </div>

    </div>
  </main>
  <?php
  if (isset($result))
    mysqli_free_result($result);
  ?>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCXsotvk0TYy-TxHJw7DZe5e-prFbtvLbs&callback=initMap">
  </script>
</body>

</html>

<?php
mysqli_close($connection);
?>