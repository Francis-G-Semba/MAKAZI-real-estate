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
    <link rel="stylesheet" href="CSS/more.css">
    <?php  require('../include/links.php') ?>
    <title>PROPERTY LIST</title>
    <style>

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
          margin-top: 60px;
        }
      }
      .navbar-dark .navbar-toggler-icon {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 1%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e ") !important;
      }

      .dropdown-menu{
        background-color: whitesmoke !important;
      }
      
    </style>
</head>
<body class="bg-light">

    <div class="container-fluid bg-dark text-light p-3 d-flex align-items-center justify-content-between sticky-top">
      <h3 class="mb-0">Admin Dashboard</h3>
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

  

  <div class="container-fluid">
  <div class="row">
    <div class="col-lg-10 ms-auto p-4 overflow-hidden" id="main-content">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-10 col-md-8 col-sm-12 mb-5 px-4">
            <div class="bg-white rounded shadow p-4">
              <h4 class="fw-bold text-center">
                Real Estate Mwanza
              </h4>
              <?php     
                // Establish database connection (replace with your database credentials)
                $host = 'localhost';
                $dbName = 'real_estate';
                $username = 'root';
                $password = '';

                // Create a new MySQLi instance
                $db = new mysqli($host, $username, $password, $dbName);

                // Check the database connection
                if ($db->connect_error) {
                  die("Connection failed: " . $db->connect_error);
                }

                // Fetch properties data from the database
                $query = "SELECT * FROM agents";
                $result = $db->query($query);

                // Check if any properties are found
                if ($result->num_rows > 0) {
                  // Display the properties in a table or list format
                  echo "<div class='table-responsive'>";
                  echo "<table class='table'>";
                  echo "<thead class='thead-dark'>";
                  echo "<tr>
                          <th scope='col'>ID</th>
                          <th scope='col'>username</th>
                          <th scope='col'>email</th>
                          <th scope='col'>telephone</th>
                          <th scope='col'>Registration</th>
                          <th scope='col'>password</th>
                          <th scope='col'>Action</th>
                        </tr>
                        </thead>";

                  while ($row = $result->fetch_assoc()) {
                    echo "<tbody>";
                    echo "<tr>";
                    echo "<td>" . $row['agent_id'] . "</td>";
                    echo "<td>" . $row['agent_name'] . "</td>";
                    echo "<td>" . $row['agent_email'] . "</td>";
                    echo "<td>" . $row['agent_tel'] . "</td>";
                    echo "<td>" . $row['agent_reg_no'] . "</td>";
                    echo "<td>" . $row['agent_password'] . "</td>";
                    echo "<td>
                            <a href='edit_user.php?id=" . $row['agent_id'] . "'>Edit</a>
                            <a href='delete_user.php?id=" . $row['agent_id'] . "'>Delete</a>
                          </td>";
                    echo "</tr>";
                    echo "</tbody>";
                  }

                } else {
                  // Display a message if no properties are found
                  echo "<tr><td colspan='6'>No users found.</td></tr>";
                }
                echo "</table>";
                echo "</div>";
                // Close the database connection
                $db->close();
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>




<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>
