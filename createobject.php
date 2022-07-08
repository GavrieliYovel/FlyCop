<?php 
  include "config.php";
  
  if(isset($_POST["mission"])) {
    $mis = $_POST["mission"];
    $dis = $_POST["distance"];
    $alt = $_POST["altitude"];
    $tm = $_POST["time"];
    $date = date("m.d.y");
    $time = date('H:i:s');
    $query  = "INSERT INTO tbl_activeDrones_209(missionType, maxAltitude, maxDistance, 'date', startTime, endTime, 'user_id', droneId) 
                VALUES('$mis', $alt, $dis,$date,  )" ;
    mysqli_query($connection, $query);
    header('Location: http://localhost/finalDeployment/dronelist.php');
  }

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" rel="stylesheet">


    <title>Create Mission</title>
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
                            <a class="nav-link active" href="dronelist.html">Active Drones</a>
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
            <li><i class="bi bi-caret-right"></i><a href="index.html">Home Screen</a></li>
            <li><i class="bi bi-caret-right"></i><a href="dronelist.html">Active Drones</a></li>
            <li><i class="bi bi-caret-right"></i><a href="#">Create Mission</a></li>
        </ul>
        <?php echo date('H:i:s');
            echo '<br>';
            $time = time() + (7 * 24 * 60 * 60);
            echo $time;
            ?>
        <h1>Create Mission</h1>

        <form class="editForm" action="#" method="post">
          <div>
            <button id="resetBtn" class="grayBtn" type="button"><i class="bi bi-x-octagon"></i></button>
            <p class="fw-bold">Mission:</p>
            <div class="form-group d-flex align-items-center">
                
                <input class="form-check-input align-self-center" type="radio" name="mission" value="patrol" checked id="patrol">
                <label class="form-check-label" for="inlineRadio1">Patrol</label>
        
                <input class="form-check-input align-self-center" type="radio" name="mission" value="standstill" id="standStill">
                <label class="form-check-label" for="inlineRadio2">Stand still</label>
            </div>
          </div>
        
          <div class="form-group">
            <div class="d-flex">
              <label class="form-label">Duration: </label>
              <div class="badge bg-dark d-flex justify-content-center">
                <output>125</output> <span>mins</span>
            </div>
            </div>    
            <div class="d-flex align-items-center">
              <p>20 mins </p><input type="range" name="time" class="form-range"  min="20" max="300" value="125" step="5" oninput="func(0, this.value);"><p> 300 mins</p>
            </div>  
          </div>

          <div class="form-group">
            <div class="d-flex">
              <label  class="form-label">Avg. Altitude: </label>
              <div class="badge bg-dark d-flex justify-content-center">
                <output>5.2</output> <span>m</span>
              </div>
            </div>   
            <div class="d-flex align-items-center">
              <p>3 m </p><input type="range" name="altitude" class="form-range align-self-end"  min="3" max="10" value="5.2" step="0.2" oninput="func(1, this.value);"><p> 10 m</p>
            </div> 
          </div>

          <div class="form-group">
            <div class="d-flex">
              <label  class="form-label">Max distance: </label>
              <div class="badge bg-dark d-flex justify-content-center">
                <output>500</output> <span>m</span>
              </div>
            </div>
            <div class="d-flex align-items-center">
              <p>25 m </p><input type="range" name="distance" class="form-range align-self-end"  min="25" max="2500" value="500" step="1" oninput="func(2, this.value);"  id="maxDistance"><p> 2500 m</p>
            </div>    
          </div> 
        
          <div class="buttonGroup d-flex justify-content-end">
            <button type="submit" value="Submit" class="btn btn-success btn-md"><i class="bi bi-check-lg"></i>Submit</button>
          </div>
        </form>
    

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="scripts/editscript.js"></script>
    


    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  </body>
</html>
