<?php
// Establish a connection to the database
$conn = new mysqli("localhost", "root", "", "real_estate");

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the inquiry ID parameter is set
if (isset($_GET['id'])) {
    // Get the inquiry ID from the parameter
    $inquiryID = $_GET['id'];

    // Delete the inquiry from the database
    $query = "DELETE FROM inquiries WHERE id = $inquiryID";
    if ($conn->query($query) === TRUE) {
        echo "Inquiry deleted successfully.";
    } else {
        echo "Error deleting inquiry: " . $conn->error;
    }
} else {
    echo "Invalid inquiry ID.";
}

// Close the database connection
$conn->close();
?>
