<?php
if (session_status() === PHP_SESSION_NONE)
     session_start();
 // Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$user_name = $user_login = $user_stock_err = $user_name_err = $user_login = $user_login_err ="";
$user_stock=0;
$user_pass1=$user_pass2=$utype=$ustatus=$flag="";
$stat='Y';
// $name_err = $address_err = $salary_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_name = trim($_POST["user_name"]);
    if(empty($input_name)){
        $name_err = "Please enter a user name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid user name.";
    } else{
        $name = $input_name;
    }
    
    $user_loginp = trim($_POST["user_login"]);
    if(empty($user_loginp)){
        $login_err = "Please enter an address.";     
    } else{
        $login = $user_loginp;
    }
    
    $user_pass1 = trim($_POST["user_pass1"]);
    if(empty($user_pass1)){
        $pass1_err = "Please enter the password.";     
    } else{
        $pass1 = $user_pass1;
    }
    
    $user_pass2 = trim($_POST["user_pass2"]);
    if(empty($user_pass2)){
        $pass2_err = "Please enter the confirm password.";     
    }
    else
    {
        $pass2 = $user_pass2;
    }
    

    if($pass1 == $pass2)
        $flag=1;
    else
        $flag=0;

    $input_utype = trim($_POST["utype"]);
    if(empty($input_utype)){
        $utype_err = "Please enter an address.";     
    } else
    {
      $utype = $input_utype;
    }  
       if($utype =="A")
         {
          $readp='Y';
          $editp='Y';
          $viswp='Y';
          $deletp='Y';  
         }
      else if($utype=="S")
         {
          $readp='Y';
          $editp='Y';
          $viswp='Y';
          $deletp='N';  
         }
       else
          {
          $readp='N';
          $editp='N';
          $viswp='N';
          $deletp='N';  
         }

    
    $input_status = trim($_POST["ustatus"]);
    if(empty($input_status)){
         $ustat_err = "Please enter an address.";     
    }
    else{
       $status = $input_status;
    }
    

    // Check input errors before inserting in database
    if(empty($name_err) && empty($login_err) && empty($utype_err) && empty($ustat_err)&& $flag==1){
        // Prepare an insert statement
        $sql = "INSERT INTO user_master (user_name,user_login,user_pass,user_type,user_status,read_permission,view_permission,edit_permission,delet_permission) VALUES (:name,:login,:pass,:type,:status,:read_p,:view_p,:edit_p,:delete_p)";
 
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":name", $param_name);
            $stmt->bindParam(":login", $param_login);
            $stmt->bindParam(":pass", $param_pass);
            $stmt->bindParam(":type", $param_type);
            $stmt->bindParam(":status", $param_status);
            $stmt->bindParam(":read_p", $param_readp);
            $stmt->bindParam(":view_p", $param_viewp);
            $stmt->bindParam(":edit_p", $param_editp);
            $stmt->bindParam(":delete_p", $param_deletp);
            
            // Set parameters
            $param_name   = $name;
            $param_login  = $login;
            $param_pass   = $pass1;
            $param_type   = $utype;
            $param_status = $status;
            $param_readp = $readp;
            $param_viewp = $viswp;
            $param_editp = $editp;
            $param_deletp = $deletp;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records created successfully. Redirect to landing page
                header("location: dashboard.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        unset($stmt);
    }
    
    // Close connection
    unset($pdo);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add user</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-10">Add user</h2>
                    <!-- <p>Please fill this form and submit to add employee record to the database.</p> -->
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>User Name</label>
                            <input type="text" name="user_name" class="form-control <?php echo (!empty($user_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $user_name; ?>">
                            <span class="invalid-feedback"><?php echo $user_name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>User Login Name</label>
                            <input type="text" name="user_login" class="form-control <?php echo (!empty($user_login_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $user_login; ?>">
                            <span class="invalid-feedback"><?php echo $user_login_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Login Password</label>
                            <input type="text" name="user_pass1" class="form-control" value="">
                        </div>
                        <div class="form-group">
                            <label>Confirmation Password</label>
                            <input type="text" name="user_pass2" class="form-control" value="">
                        </div>
                        <div class="form-group">
                            <label>User Type</label>
                               <select name="utype"class="form-control">
                                   <option value="">Select Type</option>
                                   <option value="A">Admin</option>
                                   <option value="S">Sub_Admin</option>
                                   <option value="M">Marketing</option>
                               </select>
                            <span class="invalid-feedback"><?php echo $user_login_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                               <select name="ustatus" class="form-control" >
                                   <option value="">Select Status</option>
                                   <option value="Y">Active</option>
                                   <option value="N">Inactive</option>                           
                               </select>
                            <span class="invalid-feedback"><?php echo $user_stock_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="dashboard.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>