<?php
if(isset($_REQUEST['updateprofile']))
{
	include('include/class.php');
	$obj=new admin;
	$obj->conn();
	$name=$_REQUEST['name'];
	$email=$_REQUEST['email'];
	$address=$_REQUEST['address'];
	$phone=$_REQUEST['phone'];
    $manusername = $_REQUEST['manusername'];
    $manuserpw = $_REQUEST['manuserpw'];
	
	$qry="update company_profile set name='$name',address='$address',
	phone='$phone',email='$email', manusername='$manusername', manuserpw='$manuserpw' where id=1";
    
    $qr=mysql_query($qry);
	if($qr)
	{
		echo "Website Info Updated Successfully";
	}
    else
    {
	    echo "Some error occured during updating data";
	}	
}
?>