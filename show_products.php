<?php
include("include/class.php");		
$obj = new admin;
$obj->conn();
if(isset($_REQUEST['product_name']) && isset($_REQUEST['gid']) )
{
    $name = $_REQUEST['product_name'];
    $gid = $_REQUEST['gid'];
    if(!empty($name) && !empty($gid))
    {
        $obj->show_products($name, $gid);
    }
    else if(!empty($name))
    {
        $obj->show_products($name, false);
    }
    else if(!empty($gid))
    {
        $obj->show_products(false, $gid);
    }
    else
    {
        $obj->show_products();
    }
}
else 
{
    $obj->show_products();
}
?>