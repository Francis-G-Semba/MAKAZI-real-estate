<?php session_start();

if (!isset($_SESSION['id'])) {
  // Redirect to the login form
  header("Location: index.php");
  exit();
}
  // Set the cache control headers
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
   

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


// Check if the property ID and form data are submitted
if (isset($_POST['agent_id']) && isset($_POST['agent_name']) && isset($_POST['agent_email']) && isset($_POST['agent_tel']) && isset($_POST['agent_reg_no']) && isset($_POST['agent_password'])) {
    $agent_id = $_POST['agent_id'];
    $agent_name = $_POST['agent_name'];
    $agent_email= $_POST['agent_email'];
    $agent_tel = $_POST['agent_tel'];
    $agent_reg_no = $_POST['agent_reg_no'];
    $agent_password = $_POST['agent_password'];

    // Update the property details in the database
    $query = "UPDATE agents SET agent_name = ?, agent_email= ?, agent_tel = ?, agent_reg_no = ?, agent_password = ? WHERE agent_id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("ssissi", $agent_name, $agent_email, $agent_tel, $agent_reg_no, $agent_password, $agent_id);
    $stmt->execute();


    // Check if the update was successful
    if ($stmt->affected_rows > 0) {
        echo "user updated successfully.";
    } else {
        echo "Failed to update user." . $stmt->error;
    }

    // Close the statement and database connection
    $stmt->close();
    $db->close();
} else {
    echo "Invalid request.";
}
?>
