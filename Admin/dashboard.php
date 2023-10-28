<?php session_start();

if (!isset($_SESSION['id'])) {
  // Redirect to the login form
  header("Location: index.php");
  exit();
}
  // Set the cache control headers
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    include("database/conn.php")
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/more.css">
    <title>Admin Dashboard</title>
    <?php include("../include/links.php") ?>
    <style>

      body{
        padding: 0 !important;
      }

      a{
        text-decoration: none;
        color: #32c48d;
      }

      a:hover{
        color: black;
      }

      #dashboard-menu {
        position: fixed;
        height: 100%;
      }

      @media screen and (max-width: 991px){
        #dashboard-menu {
          height: auto;
          width: 100%;
        }

        #main-content{
          flex-wrap: wrap;
          margin-top: 60px;
        }
        
      }
      .navbar-dark .navbar-toggler-icon {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 1%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e ") !important;
      }

      .dropdown-menu{
        background-color: whitesmoke !important;
      }
      
    .border-top{
      border-color: #32c48d !important;
    }
    </style>
</head>
<body class="bg-light" >

    <div class="container-fluid bg-dark text-light p-3 d-flex align-items-center justify-content-between sticky-top">
      <h3 class="mb-0"><a href="dashboard.php">Dashboard</a></h3>
      <a href="logout.php" class="btn btn-light btn-sm">Logout</a>
    </div>

    <div class="col-lg-2 bg-dark border-top border-3 border-secondary" id="dashboard-menu">
    <nav class="navbar navbar-expand-lg navbar-dark">
      <div class="container-fluid flex-lg-column align-items-stretch">
      <h4 class="mt-2 text-light"><a href="dashboard.php">Home</a></h4>
        <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#adminDropdown" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse flex-column align-items-stretch mt-2" id="adminDropdown">
        <ul class="nav nav-pills flex-column">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" >Agents</a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li>
                  <a class="dropdown-item" href="users.php">Agents List</a>
                </li>
                <li>
                  <a class="dropdown-item" href="submitted_properties.php">Submitted Properties</a>
                </li>
              </ul>
            </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" >Properties</a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li>
                  <a class="dropdown-item" href="add_property.php">Add Property</a>
                </li>
                <li>
                  <a class="dropdown-item" href="property_list.php">Property List</a>
                </li>
              </ul>
            </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="inquiries.php" >Inquiries</a>
          </li>
          <li class="nav-item">
              <a class="nav-link text-white" href="report.php">Report</a>
          </li>
        </ul>
       </div>
      </div>
    </nav>
  </div>





<div class="container">
  <div class="row">
    <div class="col-lg-10 ms-auto p-4 overflow-hidden shadow d-flex justify-content-evenly bg-white mt-4" id="main-content">
      <div class="col-lg-4 col-md-6 col-sm-12 shadow me-3 rounded p-4" id="one">
        <div class="d-flex flex-column align-items-center"> 
          <a href="property_list.php" >
            <div class="text-center">
              <i class="bi bi-house-fill fs-2"></i>
            </div>
            <div>
              <h2 class="text-center">
                <?php
                $sql = "SELECT * FROM properties";
                $result = mysqli_query($conn, $sql);
                $rws = mysqli_num_rows($result);
                echo $rws;
                ?>
              </h2>
              <p class="m-b-0">Properties</p>
            </div>
          </a>
        </div>
      </div>

      <div class="col-lg-4 col-md-6 col-sm-12 shadow me-3 rounded p-4" id="two">
        <div class="d-flex flex-column align-items-center">
          <a href="users.php" >
            <div class="">
              <i class="bi bi-people-fill fs-2" aria-hidden="true"></i>
            </div>
            <div>
              <h2 class="text-center">
                <?php
                $sql = "select * from users";
                $result = mysqli_query($conn, $sql);
                $rws = mysqli_num_rows($result);
                echo $rws;
                ?>
              </h2>
              <p class="m-b-0">Users</p>
            </div>
          </a>
        </div>
      </div> 

      <div class="col-lg-4 col-md-6 col-sm-12 shadow me-3 rounded p-4" id="three">
        <div class="d-flex flex-column align-items-center">
          <a href="inquiries.php" >
            <div class="text-center">
              <i class="bi bi-chat-text-fill fs-2" aria-hidden="true"></i>
            </div>
            <div>
              <h2 class="text-center">
                <?php
                $sql = "select * from inquiries";
                $result = mysqli_query($conn, $sql);
                $rws = mysqli_num_rows($result);
                echo $rws;
                ?>
              </h2>
              <p class="m-b-0">Inquiries</p>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>




<?php include("scripts.php") ?>
</body>
</html>

