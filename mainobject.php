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
    <title>Drone #235</title>
  </head>
  <body>
  <?php 
    include "config.php";
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

    <main>
        <!-- breadcrumbs -->
      <ul class="breadcrumbs">
        <li><i class="bi bi-caret-right"></i></i><a href="index.html">Home Screen</a></li>
        <li><i class="bi bi-caret-right"></i></i><a href="dronelist.html">Active Drones</a></li>
        <li><i class="bi bi-caret-right"></i></i><a href="#">Drone #235</a></li>
      </ul>
    
      <div id="mainObjContent">
        <?php
           
        
          echo '<h1>Drone #'.$row1["droneId"].'</h1>';
        ?>
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
        <div class="d-flex justify-content-end">
        <a href="editobject.html" class = "grayBtn"><i class="bi bi-pencil-fill"></i></a>
         </div>
          
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
            <button class="btn btn-danger btn-sm"> <img src="images/stopIcn.png"> Stop Misision</button>
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

<!--               
               
                <tr class="border-bottom border-dark d-flex justify-content-between align-items-end">
                  <div>
                    <td>
                      <img  src="images/signRed.png" class ="signIcn">
                    </td>
                    <td class="startLine">
                      Passing Red Light
                    </td>
                    <td>
                      09:23
                    </td>
                    <td>
                      2/1/22
                    </td>
                  </div>
                  <td>
                    <div>
                      <button class="grayBtn"><i class="bi bi-play-fill"></i></button>
                      <button class="grayBtn"> <img src="images/carIcn.png"></button>
                      <button class="grayBtn"><img src="images/ticketIcn.png"></button>
                    </div>
                  </td>
                </tr>
                <tr class="border-bottom border-dark d-flex justify-content-between align-items-end">
                  <td>
                    <img  src="images/signGr.png" class ="signIcn">
                  </td>
                  <td class="startLine">
                    Illegal bypassing
                  </td>
                  <td>
                    09:50
                  </td>
                  <td>
                    2/1/22
                  </td>
                  <td>
                    <div>
                      <button class="grayBtn"><i class="bi bi-play-fill"></i></button>
                      <button class="grayBtn"> <img src="images/carIcn.png"></button>
                      <button class="grayBtn"><img src="images/ticketIcn.png"></button>
                    </div>
                  </td>
                </tr> -->
              </table>
          </section>
  
      </div>

  </main>    
    <?php
     mysqli_free_result($result1);
     mysqli_free_result($result2);
    ?>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
<?php 
  mysqli_close($connection);
?>