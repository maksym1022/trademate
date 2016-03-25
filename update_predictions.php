<?php
    include("include/class.php");
    $obj = new admin;
    $obj->conn();
    
    $id = $_REQUEST['id'];
    $desc = $_REQUEST['desc'];
    $product_app_name = $_REQUEST['product_app_name'];
    $product_xl_name = $_REQUEST['product_xl_name'];
    $product_symbol = $_REQUEST['product_symbol'];
    
    $value = mysql_fetch_array(mysql_query("select * from products where id='$id'"));
    
    $old_symbol = $value['symbol'];
    
    $query = "update historical_data set symbol='$product_symbol' where symbol='$old_symbol'";
    mysql_query($query);
    
    $query1 = "update predictions set symbol='$product_symbol' where symbol='$old_symbol'";
    mysql_query($query1);
    
    $query2 = "update products set symbol='$product_symbol' where id='$id'";
    mysql_query($query2);
    
    echo "Updated Predictions Successfully.";
?>
