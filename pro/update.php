<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$item_name = $item_uom = $item_stock_err = $item_name_err = $item_uom = $item_uom_err ="";
$item_stock=0;
$stat='Y';
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate name
    $input_name = trim($_POST["item_name"]);
    if(empty($input_name)){
        $name_err = "Please enter a item name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid item name.";
    } else{
        $name = $input_name;
    }
    
    // Validate address
    $item_uomp = trim($_POST["item_uom"]);
    if(empty($item_uomp)){
        $item_uom_err = "Please enter an unit of measurment.";     
    } else{
        $uom = $item_uomp;
    }
    
    $input_stock = trim($_POST["item_stock"]);
    if(empty($input_stock)){
        $item_stock_err = "Please enter the item stock.";     
    } elseif(!ctype_digit($input_stock)){
        $item_stock_err = "Please enter a positive integer .";
    } else{
        $stock = $input_stock;
    }
    
    // Check input errors before inserting in database
    if(empty($item_name_err) && empty($item_uom_err) && empty($item_stock_err)){
        // Prepare an update statement
        $sql = "UPDATE item_master SET item_description=:name, item_uom=:uom, item_stock=:stock,item_status=:status  WHERE item_id=:id";
 
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":name", $param_name);
            $stmt->bindParam(":uom", $param_uom);
            $stmt->bindParam(":stock", $param_stock);
            $stmt->bindParam(":id", $param_id);
            $stmt->bindParam(":status", $param_status);
            
            // Set parameters
            $param_name = $name;
            $param_uom  = $uom;
            $param_stock= $stock;
            $param_status=$stat;  
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records updated successfully. Redirect to landing page
                header("location: item_list.php");
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
else
{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM item_master WHERE item_id = :id";
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":id", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                    // Retrieve individual field value
                    $item_p_name  = $row["item_description"];
                    $item_p_uom   = $row["item_uom"];
                    $item_p_stock = $row["item_stock"];
                } 
                else
                {
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        unset($stmt);
        
        // Close connection
        unset($pdo);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
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
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the values if required and submit to update the item list.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Description</label>
                            <input type="text" name="item_name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $item_p_name; ?>">
                            <span class="invalid-feedback"><?php echo $item_name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Unit of Meserment</label>
                            <input type="text" name="item_uom" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $item_p_uom; ?>">
                            <span class="invalid-feedback"><?php echo $item_uom_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Stock</label>
                            <input type="text" name="item_stock" class="form-control <?php echo (!empty($item_stock_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $item_p_stock; ?>">
                            <span class="invalid-feedback"><?php echo $item_stock_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="item_list.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>