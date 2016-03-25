<?php 
require_once("/home/oneingvq/public_html/trademate/include/class.php");
require_once("/home/oneingvq/public_html/trademate/webservice/custom_functions.php");
$obj=new admin;
$obj->conn();


if(isset($_REQUEST['payment']) and !empty($_REQUEST['user']))
{
$status=$_REQUEST['payment'];
if($status=="success")
{

$user=$_REQUEST['user'];
$qry=mysql_query("select email from signup where username='$user'");	
	if($x=mysql_fetch_array($qry))
	{
	$to=$x['email'];
	$old_date=date('Y-m-d');
	$old_date="$old_date";
	$new_date=add_days($old_date,30);
	$value=mysql_query("update signup set status='2',expiring_on='$new_date' where username='$user'");



	$subject="TradeMate Subscribtion Extended upto $new_date!";
	$txt="Hello User! Your Password has been successfully updated to :".$newpassword." . ThankYou!";
	$txt="Dear subscriber, 
Thank you for re-subscribing our services with us . We have recieved your payment for the next one month.You will be able to access our predictions across a wide range of markets, check out our best trading opportunities, including our trade entry and exist suggestions.
Sincerely,
Trade Mate Master
";
	
	$headers = "From: oneingvq@oneinfonet.com" . "\r\n" .
			"CC: oneingvq@oneinfonet.com";



	if (mail($to,$subject,$txt,$headers)){
	$response["success"] = 1;
    $response["message"] = "Payment Received Successfully";
    die(json_encode($response));
	
	
	
	
											}
else{
	
$response["success"] = 0;
    $response["message"] = "INTERNAL ERROR.......";
    die(json_encode($response));
	}
	}
	



}




}
?>