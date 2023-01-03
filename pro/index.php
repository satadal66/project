<?php
// Check existence of id parameter before processing further
 
if (session_status() === PHP_SESSION_NONE)
     session_start();

$stat='Y';
if(isset($_POST["name"]) && !empty($_POST["name"]))
{
    $name = $_POST["name"];
    $pass = $_POST['password'];
    
    require_once "config.php";
    
    // Prepare a select statement
    $sql = "SELECT * FROM user_master WHERE user_status =:status AND user_login = :name AND user_pass =:pass ";
     
    if($stmt = $pdo->prepare($sql))
        {
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":status", $param_status);
        $stmt->bindParam(":name", $param_name);
        $stmt->bindParam(":pass", $param_pass);
        // Set parameters
        $param_status =$stat;
        $param_name = $name;
        $param_pass = $pass;
       
       $stmt->execute();
       if($stmt->rowCount() == 1)
               {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                 $_SESSION['flag'] = 1;
                 $_SESSION['u_name'] =$row["user_name"];
                 $_SESSION['u_type'] = $row["user_type"];
                 $_SESSION['u_status'] =$row["user_status"];
                 if($_SESSION['u_type']=="M")
                    header("location: item_list.php");
                 else      
                    header("location: dashboard.php");
                }
               else 
                { 
               // URL doesn't contain valid id parameter. Redirect to error page
                header("location: login.php");
                exit();
                }
           
     //    }
     // else
     // {
     //        echo "Oops! Something went wrong. Please try again later.";
      }
    
     
    // Close statement
    unset($stmt);
    
    // Close connection
    unset($pdo);
   } 
// } else{
//     // URL doesn't contain id parameter. Redirect to error page
//     header("location: login.php");
//     exit();
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
<div class="container mt-5">

    <div class="row d-flex justify-content-center">
        
        <div class="col-md-6">
            <h2>Login</h2>
  <form name="login"action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
            <div class="card px-5 py-5" id="form1">
                <div class="form-data" >
                    <div class="forms-inputs mb-4"> <span>User name</span> 
                        <input type="text" name="name" required >
                    </div>
                    <div class="forms-inputs mb-4"> <span>Password</span> 
                        <input  type="password" name="password" required>
                    </div>
                    <div class="forms-inputs mb-4">
                        <input type="submit" name="submit" value="Login">   
                    </div>
                </div>
            </div>
        
                <!-- <div class="success-data" v-else>
                    <div class="text-center d-flex flex-column"> <i class='bx bxs-badge-check'></i> <span class="text-center fs-1">You have been logged in <br> Successfully</span> </div>
                </div> -->
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>    