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
    <title>Admin Report</title>
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
<body>
<body class="bg-light" >

<div class="container-fluid bg-dark text-light p-3 d-flex align-items-center justify-content-between sticky-top">
  <h3 class="mb-0"><a href="dashboard.php">Dashboard</a></h3>
  <a href="logout.php" class="btn btn-light btn-sm">Logout</a>
</div>

<div class="col-lg-2 bg-dark border-top border-3 " id="dashboard-menu">
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid flex-lg-column align-items-stretch">
        <h4 class="mt-2 text-light"><a href="dashboard.php">Home</a></h4>
        <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#adminDropdown" aria-controls="adminDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse flex-column align-items-stretch mt-2" id="adminDropdown">
            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a class="nav-link text-white" href="users.php">Users</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Properties</a>
                    <ul class="dropdown-menu " aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item" href="add_property.php">Add Property</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="property_list.php">Property List</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a class="nav-link text-white" href="inquiries.php">Inquiries</a>
                </li>
            </ul>
            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a class="nav-link text-white" href="report.php">Report</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
</div>


<div class="container-fluid">
  <div class="row">
    <div class="col-lg-10 ms-auto p-4 overflow-hidden" id="main-content">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-10 col-md-8 col-sm-12 mb-5 px-4">
            <div class="bg-white rounded shadow p-4">
    
<?php
// Step 1: Database Connection
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'real_estate';

$conn = mysqli_connect($host, $user, $password, $database);

// Check connection
if (!$conn) {
  die("Database connection failed: " . mysqli_connect_error());
}

//Step 2: Define the Report Generation Functions

// Property Type Report
// function generatePropertyTypeReport() {
//   global $conn;

//   // Step 3: Retrieve Data from the Database
//   $query = "SELECT 
//               property_type,
//               COUNT(*) AS total_properties,
//               AVG(price) AS average_price
//             FROM 
//               properties
//             GROUP BY 
//               property_type";

//   $result = mysqli_query($conn, $query);

//   // Step 5: Format and Display the Report
//   echo "<h2 class='text-center';>Real Estate Website Report</h2>";
//   echo "<br>";
//   echo "<h3>Property Type Report</h3>";
//   echo '<div class="table-responsive">';
//   echo '<table class="table table-striped">';
//   echo '<thead class="thead-dark">';
//   echo '<tr>';
//   echo '<th class="text-center";>Property Type</th>';
//   echo '<th class="text-center";>Total Properties</th>';
//   echo '<th class="text-center";>Average Price</th>';
//   echo '</tr>';
//   echo '</thead>';
//   echo '<tbody>';

//   while ($row = mysqli_fetch_assoc($result)) {
//     echo '<tr>';
//     echo '<td class="text-center";>' . $row['property_type'] . '</td>';
//     echo '<td class="text-center";>' . $row['total_properties'] . '</td>';
//     echo '<td class="text-center";>' . number_format($row['average_price'], 2) . '</td>';
//     echo '</tr>';
//   }

//   echo '</tbody>';
//   echo '</table>';
//   echo '</div>';
// }

// Location Report
function generateLocationReport() {
  global $conn;

  // Step 3: Retrieve Data from the Database
  $query = "SELECT 
              location,
              COUNT(*) AS total_properties,
              SUM(CASE WHEN property_status = 'For Sale' THEN 1 ELSE 0 END) AS total_for_sale,
              SUM(CASE WHEN property_status = 'For Rent' THEN 1 ELSE 0 END) AS total_for_rent
            FROM 
              properties
            GROUP BY 
              location";

  $result = mysqli_query($conn, $query);

  // Step 5: Format and Display the Report
  echo "<h3>Location Report</h3>";
  echo '<div class="table-responsive">';
  echo '<table class="table table-striped">';
  echo '<thead class="thead-dark">';
  echo '<tr>';
  echo '<th class="text-center";>Location</th>';
  echo '<th class="text-center";>Total Properties</th>';
  echo '<th class="text-center";>Number of Listings (For Sale)</th>';
  echo '<th class="text-center";>Number of Listings (For Rent)</th>';
  echo '</tr>';
  echo '</thead>';
  echo '<tbody>';

  while ($row = mysqli_fetch_assoc($result)) {
    echo '<tr>';
    echo '<td class="text-center";>' . $row['location'] . '</td>';
    echo '<td class="text-center";>' . $row['total_properties'] . '</td>';
    echo '<td class="text-center";>' . $row['total_for_sale'] . '</td>';
    echo '<td class="text-center";>' . $row['total_for_rent'] . '</td>';
    echo '</tr>';
  }

  echo '</tbody>';
  echo '</table>';

  echo '<button class="btn btn-primary" onclick="window.print()">Print</button>';

  echo '</div>';
}

// Step 6: Generate the Reports
// generatePropertyTypeReport();
generateLocationReport();

// Step 7: Close the Database Connection
mysqli_close($conn);
?>

                         </div>
                	</div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include("scripts.php") ?>
</body>
</html>
