<?php
// Include connection file
require_once "connection.php";
 
// Define variables and initialize with empty values
$username = $sample = $aadhaar = "";
$username_err = $sample_err = $aadhaar_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a Hospital name.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Hospital name can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM internshala_login WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate sample
    if(empty(trim($_POST["sample"]))){
        $password_err = "Please enter the sampe for which you wana request.";     
    } else{
        $sample = trim($_POST["sample"]);
    }

    // Validate aadhaar
    if(empty(trim($_POST["aadhaar"]))){
        $aadhaar_err = "Please enter the Aadhaar No";     
    } elseif(strlen(trim($_POST["aadhaar"])) < 12){
        $aadhaar_err = "Aadhaar No must have atleast 12 characters.";
    } else{
        $aadhaar = trim($_POST["aadhaar"]);
    }
    
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($sample_err) && empty($aadhaar_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO sample (username, sample, aadhaar ) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_sample, $param_aadhaar);
            
            // Set parameters
            $param_username = $username;
            $param_sample = $sample;
            $param_aadhaar = $aadhaar;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: hospital_login.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
<div class="p-5 text-center bg-light">
                <h4 class="mb-3">BLOOD BANK APPLICATION</h4>
</div>
<div class="col-md-4 mx-auto">

                <div class="wrapper">
        <h2>Request Sample</h2>
        <p>Please fill this form .</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>BLood Sample</label>
                <input type="text" name="sample" class="form-control <?php echo (!empty($sample_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $sample; ?>">
                <span class="invalid-feedback"><?php echo $sample_err; ?></span>
            </div>
            <div class="form-group">
                <label>Addhaar No</label>
                <input type="text" name="aadhaar" class="form-control <?php echo (!empty($aadhaar_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $aadhaar; ?>">
                <span class="invalid-feedback"><?php echo $aadhaar_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
            <a class="btn btn-link ml-2" href="user_welcome.php">Cancel</a>

        </form>
    </div>    
</div>
</body>
</html>