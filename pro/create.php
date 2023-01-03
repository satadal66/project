<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$item_name = $item_uom = $item_stock_err = $item_name_err = $item_uom = $item_uom_err ="";
$item_stock=0;
$stat='Y';
// $name_err = $address_err = $salary_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
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
        $address_err = "Please enter an address.";     
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
        // Prepare an insert statement
        $sql = "INSERT INTO item_master (item_description, item_uom, item_stock,item_status) VALUES (:name, :uom, :stock ,:status)";
 
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":name", $param_name);
            $stmt->bindParam(":uom", $param_uom);
            $stmt->bindParam(":stock", $param_stock);
            $stmt->bindParam(":status", $param_status);
            // Set parameters
            $param_name = $name;
            $param_uom  = $uom;
            $param_stock= $stock;
            $param_status=$stat;  
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records created successfully. Redirect to landing page
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
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Item</title>
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
                    <h2 class="mt-5">Add Item</h2>
                    <!-- <p>Please fill this form and submit to add employee record to the database.</p> -->
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Item Name</label>
                            <input type="text" name="item_name" class="form-control <?php echo (!empty($item_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $item_name; ?>">
                            <span class="invalid-feedback"><?php echo $item_name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Unit of Mesurment</label>
                            <input type="text" name="item_uom" class="form-control <?php echo (!empty($item_uom_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $item_uom; ?>">
                            <span class="invalid-feedback"><?php echo $item_uom_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Stock</label>
                            <input type="text" name="item_stock" class="form-control <?php echo (!empty($item_stock_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $item_stock; ?>">
                            <span class="invalid-feedback"><?php echo $item_stock_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="item_list.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>