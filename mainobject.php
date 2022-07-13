<?php
  include "config.php";
  include "urldefine.php";
  session_start();

  if(isset($_POST['delete'])) {
    $queryDeleteDrone  = "DELETE FROM tbl_activeDrones_209 where missionId= " . $_POST["mission"] ;
    mysqli_query($connection, $queryDeleteDrone);
    $queryUpdateAssignedDrone = "UPDATE tbl_drones_209 SET isAssign = 0 WHERE droneId =" . $_POST["drone"];
    mysqli_query($connection, $queryUpdateAssignedDrone);
    header('Location: '. URL .'dronelist.php');
  }

  $missId = $_GET["mission_id"];
  $query1  = "SELECT * FROM tbl_activeDrones_209 INNER JOIN tbl_users_209 using(user_id) where missionId=" . $missId;
  $result1 = mysqli_query($connection, $query1);
  if($result1) {
      $row1 = mysqli_fetch_assoc($result1);
  }
  else die("DB query failed.");

  $query2  = "SELECT * FROM tbl_activeDrones_209 INNER JOIN tbl_violation_209 using(missionId) where missionId=" . $missId;
  $result2 = mysqli_query($connection, $query2);
  if(!$result2) {
    die("DB query failed.");
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css" />
    <title>Drone #<?php echo $row1["droneId"]?></title>
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php"></a>
      <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header ">
            <h5 class="offcanvas-title text-white" id="offcanvasNavbarLabel">Menu</h5>
            <button type="button" class="btn-close text-reset bg-white" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="navbar-nav flex-grow-1 pe-3" <?php   if (!isset($_SESSION["user"])) echo 'style="display: none;"';
                                                            else echo 'style:"display: flex"'; ?>>
              <li class="nav-item">
                <?php   if ($_SESSION["role"] == 1)
                            echo '<a class="nav-link" href="createobject.php">New Mission</a>';
                        elseif ($_SESSION["role"] == 2)
                            echo '<a class="nav-link" href="createviolation.php">New Violation</a>'; 
                ?>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="dronelist.php">Active Drones</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="violationlist.php">Violations</a>
              </li>
            </ul>
        </div>
      </div>
      <!-- User Details in Navbar -->
      <div id="person" <?php  if (!isset($_SESSION["user"])) echo 'style="display: none;"';
                              else echo 'style:"display: flex"'; ?>>
          <?php
            echo '<img id="personImg" src="' . $_SESSION["img"] . '" alt="">';
            echo '<div class="text-white">';
            echo '<h5>' . $_SESSION["fName"] . ' ' . $_SESSION["lName"] . '</h5>';
            echo '<p>' . $_SESSION["rName"] . '</p>';
          ?>
          <div>
            <a href="logout.php" title="Logout"><i class="bi bi-door-closed-fill"></i></a>
          </div>
      </div>
    </div>
    <!-- End of user details -->
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar"
        <?php if (!isset($_SESSION["user"])) echo 'style="display: none;"';
              else echo 'style:"display: flex"'; ?>>
        <span class="navbar-toggler-icon"></span>
    </button>
  </nav>
  <!-- End of navbar -->

  <main>
      <!-- breadcrumbs -->
      <ul class="breadcrumbs">
          <li><i class="bi bi-caret-right"></i></i><a href="index.php">Home Screen</a></li>
          <li><i class="bi bi-caret-right"></i></i><a href="dronelist.php">Active Drones</a></li>
          <li><i class="bi bi-caret-right"></i></i><a href="#">Drone #<?php echo $row1["droneId"]?></a></li>
      </ul>
      <div id="mainObjContent">
          <h1>Drone #<?php echo $row1["droneId"]?></h1>
          <table id="missionProperties">
              <tr>
                  <th>Mission:</th>
                  <td><?php echo $row1["missionType"]; ?></td>
                  <th>Start Time:</th>
                  <td><?php echo $row1["startTime"]; ?></td>
              </tr>
              <tr>
                  <th>Set by:</th>
                  <td><?php echo $row1["firstName"]; ?></td>
                  <th>End time:</th>
                  <td><?php echo $row1["endTime"]; ?></td>
              </tr>
          </table>
          <!-- Mission Settings  -->
          <section id="missSet">
              <h2>Mission Settings</h2>
              <table id="missonSetTbl">
                  <tr>
                      <th>Flight mode:</th>
                      <td><?php echo $row1["missionType"]; ?></td>
                  </tr>
                  <tr>
                      <th>Avg. Altitude:</th>
                      <td><?php echo $row1["maxAltitude"]; ?>m</td>
                  </tr>
                  <tr>
                      <th>Max. Distance:</th>
                      <td> <?php echo $row1["maxDistance"]; ?>m</td>
                  </tr>
              </table>
              <div class="d-flex justify-content-center">
                  <div class="buttonGroup d-flex justify-content-center">
                      <form action="#" method="POST">
                          <input type=hidden name=mission value=" <?php echo $missId ?>">
                          <input type=hidden name=drone value=" <?php echo $row1["droneId"] ?>">
                          <input class="btn btn-danger btn-md" type=submit value=Delete name=delete id="check">
                      </form>
                      <form action="editobject.php" method="POST">
                          <input type=hidden name=mission value=" <?php echo $missId ?>">
                          <input class="btn btn-primary btn-md" type=submit value="Edit">
                      </form>
                  </div>
              </div>
          </section>
          <!-- Violations Detected -->
          <section id="vioDet">
              <h2>Violations Detected: </h2>
              <table class="d-flex flex-column">
                  <?php
                    while($row2 = mysqli_fetch_assoc($result2))
                    {
                      echo '<tr class="border-bottom border-dark d-flex justify-content-between align-items-end">';
                      switch($row2["severity"]) {
                        case 1: 
                          echo '<td><img  src="images/signGr.png" class ="signIcn"></td>';
                          break;
                        case 2: 
                          echo '<td><img  src="images/signYel.png" class ="signIcn"></td>';
                          break;
                        case 3: 
                          echo '<td><img  src="images/signRed.png" class ="signIcn"></td>';
                          break;  
                      }
                      echo '<td class="startLine">'.$row2["type"].'</td>';
                      echo '<td>'.$row2["timeV"].'</td>';
                      echo '<td>'.$row2["date"].'</td>';
                      echo '</tr>';
                    }
              ?>
              </table>
          </section>
      </div>
  </main>
  <?php
   mysqli_free_result($result1);
   mysqli_free_result($result2);
  ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
  </script>
  <script src="scripts/mainobjscript.js"></script>
</body>

</html>
<?php 
  mysqli_close($connection);
?>