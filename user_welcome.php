<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: user_login.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center;
      background-image: url('https://mdbootstrap.com/img/Photos/Others/images/76.webp');
      height: 100vh;}
    </style>
</head>
<body>
    <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>.<br> This is Blood Bank Application.<br> you are logged in as a User Account</h1>
    <p>
        <a href="user_resetpass.php" class="btn btn-warning">Reset Your Password</a>
        <a href="user_logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
        <a href="request_sample.php" class="btn btn-danger ml-3">Request Sample</a>
    </p>
</body>
</html>