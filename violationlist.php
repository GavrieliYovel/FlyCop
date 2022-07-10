<?php
include "config.php";
include "urldefine.php";
session_start();

if (!empty($_POST["sort"])) {
  switch ($_POST["sort"]) {
    case "date":
      $query  = "SELECT * FROM tbl_violation_209 ORDER BY dateV, timeV";
      break;
    case "severity":
      $query  = "SELECT * FROM tbl_violation_209 ORDER BY severity DESC";
      break;
    case "type":
      $query = "SELECT * FROM tbl_violation_209 ORDER BY type";
  }
} else {

  $query  = "SELECT * FROM tbl_violation_209";
}

$result = mysqli_query($connection, $query);
if (!$result) {
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css" />
  <title>Violation List</title>
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
      <li><i class="bi bi-caret-right"></i></i><a href="#">Violation List</a></li>
    </ul>
    <div class="wrapper">
      <h1>Violations List</h1>
      <a href="createviolation.php"><i class="fs-2 bi bi-plus-square"></i></a>
      <!-- Violations Detected -->
      <section id="vioDet">
        <h2>Violations Detected: </h2>
        <form action="#" method="post">
          <label>Sort by:</label>
          <input type="submit" name="sort" value="date">
          <input type="submit" name="sort" value="severity">
          <input type="submit" name="sort" value="type">
        </form>
        <ul class="violationList" id="list">
          <?php

          while ($row = mysqli_fetch_assoc($result)) {
            echo '<li class="border-bottom border-dark ">';
            if ($_SESSION["user"] == 2) { // Only Dana can have the link
              echo '<a href="violationpage.php?vId=' . $row["violationId"] . '" class="d-flex justify-content-between align-items-end">';
            } else
              echo '<div class="d-flex justify-content-between align-items-end">';
            switch ($row["severity"]) {
              case 1:
                echo '<p><img  src="images/signGr.png" class ="signIcn"></p>';
                break;
              case 2:
                echo '<p><img  src="images/signYel.png" class ="signIcn"></p>';
                break;
              case 3:
                echo '<p><img  src="images/signRed.png" class ="signIcn"></p>';
                break;
            }
            echo '<p class="startLine">' . $row["type"] . '</p>';
            echo '<p>' . $row["timeV"] . '</p>';
            echo '<p>' . $row["dateV"] . '</p>';
            if ($_SESSION["user"] == 2)
              echo '</a>';
            else
              echo '</div>';
            echo '</li>';
          }
          ?>
        </ul>
      </section>
    </div>

    </div>

  </main>
  <?php
  mysqli_free_result($result);
  ?>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>
<?php
mysqli_close($connection);
?>