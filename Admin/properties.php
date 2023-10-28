<?php session_start();

if (!isset($_SESSION['id'])) {
  // Redirect to the login form
  header("Location: index.php");
  exit();
}
  // Set the cache control headers
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
?>


<?php
// Include database connection file
include_once('database/conn.php');

// Check if form is submitted for adding a property
if (isset($_POST['add_property'])) {
    $name = $_POST['name'];
    $location = $_POST['location'];
    $price = $_POST['price'];
    $type = $_POST['type'];
    $description = $_POST['description'];
    $options = $_POST['options'];

    // Insert property data into database
    $sql = "INSERT INTO properties (name, location, price, type, description, options) VALUES ('$name', '$location', '$price', '$type', '$description', $options)";
    if ($conn->query($sql) === TRUE) {
        header("Location: properties.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Check if form is submitted for updating a property
if (isset($_POST['update_property'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $location = $_POST['location'];
    $price = $_POST['price'];
    $type = $_POST['type'];
    $description = $_POST['description'];
    $options = $_POST['options'];


    // Update property data in database
    $sql = "UPDATE properties SET name='$name', location='$location', price='$price', type='$type', description='$description', options='$options' WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        header("Location: properties.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Check if a property is to be deleted
if (isset($_GET['delete_property'])) {
    $id = $_GET['delete_property'];

    // Delete property from database
    $sql = "DELETE FROM properties WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        header("Location: properties.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch all properties from database
$sql = "SELECT * FROM properties";
$result = $conn->query($sql);

// Initialize variables for filtering
$filter_location = '';
$filter_min_price = '';
$filter_max_price = '';
$filter_type = '';

// Check if filter form is submitted
if (isset($_GET['submit_filter'])) {
    $filter_location = $_GET['location_filter'];
    $filter_min_price = $_GET['min_price_filter'];
    $filter_max_price = $_GET['max_price_filter'];
    $filter_type = $_GET['type_filter'];

    // Build SQL query for filtering properties
    $sql = "SELECT * FROM properties WHERE 1=1";
    if ($filter_location != '') {
        $sql .= " AND location LIKE '%$filter_location%'";
    }
    if ($filter_min_price != '') {
        $sql .= " AND price >= '$filter_min_price'";
    }
    if ($filter_max_price != '') {
        $sql .= " AND price <= '$filter_max_price'";
    }
    if ($filter_type != '') {
        $sql .= " AND type = '$filter_type'";
    }
    $result = $conn->query($sql);
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Property Management</title>
    <?php include("../include/links.php")?>
</head>
<body>
        <div class="container">
            <h1>Property Management</h1>
            <!-- Add Property Form -->
        <div class="card my-3">
            <div class="card-header">Add Property</div>
            <div class="card-body">
                <form method="post">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Location</label>
                        <input type="text" name="location" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Price</label>
                        <input type="number" name="price" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Type</label>
                        <select name="type" class="form-control" required>
                            <option value="">Select Type</option>
                            <option value="Apartment">Apartment</option>
                            <option value="House">House</option>
                            <option value="Villa">Villa</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                    <label>Options</label>
                    <select name="options" class="form-control" required>
                        <option value="">Select</option>
                        <option value="Sale">For Sale</option>
                        <option value="Rent">For Rent</option>
                    </select>
                    </div>
                    <button type="submit" name="add_property" class="btn btn-primary mt-3">Add Property</button>
                </form>
            </div>
        </div>

        <!-- Filter Properties Form -->
        <div class="card my-3">
            <div class="card-header">Filter Properties</div>
            <div class="card-body">
                <form method="get">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Location</label>
                            <input type="text" name="location_filter" class="form-control" value="<?php echo $filter_location ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Minimum Price</label>
                            <input type="number" name="min_price_filter" class="form-control" value="<?php echo $filter_min_price ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Maximum Price</label>
                            <input type="number" name="max_price_filter" class="form-control" value="<?php echo $filter_max_price ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Type</label>
                        <select name="type_filter" class="form-control">
                            <option value="">Select Type</option>
                            <option value="Apartment" <?php if ($filter_type == 'Apartment') echo 'selected' ?>>Apartment</option>
                            <option value="House" <?php if ($filter_type == 'House') echo 'selected' ?>>House</option>
                            <option value="Villa" <?php if ($filter_type == 'Villa') echo 'selected' ?>>Villa</option>
                        </select>
                    </div>
                    <button type="submit" name="submit_filter" class="btn btn-primary">Filter Properties</button>
                </form>
            </div>
        </div>

        <!-- Property List -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($properties as $property) { ?>
                <tr>
                    <td><?php echo $property['name'] ?></td>
                    <td><?php echo $property['location'] ?></td>
                    <td><?php echo $property['price'] ?></td>
                    <td><?php echo $property['type'] ?></td>
                    <td><?php echo $property['description'] ?></td>
                    <td>
                    <a href="edit_property.php?id=<?php echo $property['id'] ?>" class="btn btn-primary">Edit</a>
                    <a href="delete_property.php?id=<?php echo $property['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this property?')">Delete</a>
                    </td>
                </tr>
             <?php } ?>
            </tbody>
        </table>

    </div>
</body>
</html>
<?php
// Close the database connection
mysqli_close($conn);
?>

