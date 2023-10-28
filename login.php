<?php
// Database connection details
$host = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$database = 'real_estate';

// Establish a connection to the database
$conn = new mysqli($host, $dbUsername, $dbPassword, $database);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the entered username and password from the login form
if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query the agents table
    $query_agents = "SELECT * FROM agents WHERE agent_email = '$email' AND agent_password = '$password'";
    $result_agents = $conn->query($query_agents);

    // Query the admin table
    $query_admin = "SELECT * FROM admin WHERE admin_email = '$email' AND admin_password = '$password'";
    $result_admin = $conn->query($query_admin);

    // Check if the user is an agent
    if ($result_agents->num_rows > 0) {
        // Fetch the agent details
        $agent = $result_agents->fetch_assoc();

        // Get the agent ID
        $agentId = $agent['agent_id'];

        // Perform actions for agent

        // Redirect to the agents.php page with the agent ID as a parameter
        header("Location: agents.php?agent_id=$agentId");
        exit();
    }
    // Check if the user is an admin
    elseif ($result_admin->num_rows > 0) {
        // Fetch the admin details
        $admin = $result_admin->fetch_assoc();

        // Get the admin ID
        $adminId = $admin['ID'];

        // Perform actions for admin

        // Redirect to the admin.php page with the admin ID as a parameter
        header("Location: Admin/dashboard.php?admin_id=$adminId");
        exit();
    }
    // Invalid credentials
    else {
        echo "Invalid email or password";
    }
}

// Close the database connection
$conn->close();
?>
