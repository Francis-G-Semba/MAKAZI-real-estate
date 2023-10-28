
<?php
    session_start();
    include("database/conn.php");
    
    if (isset($_POST['login'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        // Hash the password before comparing it to the stored hash
       // $password = hash('sha256', $password);

       $sql = "SELECT * FROM admin WHERE admin_email='$email' AND admin_password='$password'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 1) {
            // Admin is authenticated
            $admin = mysqli_fetch_assoc($result);

            // Store the admin's ID in the session
            $_SESSION['id'] = $admin['ID'];


            // Set the cache control headers
            header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");

            // Redirect to the dashboard
            header("Location:dashboard.php");
            exit();
        } else {
            // Invalid email or password
            $_SESSION['login_error'] = "Invalid email or password";
            header("Location: index.php");
            exit();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <?php include("../include/links.php"); ?>
    <style>
        div.login-form{
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
            width: 400px;
            
        }
        h4{
            background-color: #009E66 !important;
        }

        button{
            background-color: #009E66 !important;
        }
    </style>
</head>
<body class="bg-light">
    
    <div class="login-form  text-center rounded bg-white shadow overflow-hidden">
        <form method="POST" action="">
            <h4 class="text-white py-3">ADMIN LOGIN</h4>
            <div class="p-4">
                <?php 
                    if(isset($_SESSION['login_error'])){
                        echo "<p class='text-danger'>".$_SESSION['login_error']."</p>";
                        unset($_SESSION['login_error']);
                    }
                ?>
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input name="email" required type="email" class="form-control shadow-none">
                </div>
                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <input  name="password" required type="password" class="form-control shadow-none">
                </div>
                <button name="login" type="submit" class="btn text-white shadow-none w-50  ">LOGIN</button>
            </div>
        </form>
