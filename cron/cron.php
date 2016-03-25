<?php

include("../include/class.php");
$obj=new admin;
$obj->conn();
mysql_connect($server,$user,$password) or die ('Connection Error!');
$value=mysql_select_db("oneingvq_trademate");
$qry = "select * from signup where status='0'";
$result= mysql_query($qry);
while($row= mysql_fetch_array($result)){
	$expireDate =$row['expiring_on'];
	$expireDate = explode(" ",$expireDate);
	$expireDate= date_create($expireDate[0]);
 $interval = date_diff(date_create(date("Y-m-d")),$expireDate);
 $check = intval($interval->format('%R%a days'));
	if($check<0){
		$qry = "update signup set status='1' where id=".$row['id'];
		if(mysql_query($qry)){ 
			echo "done";
		}
		else{
		echo "problems";
			$to = "ross.e@live.com";
			$subject = "user check error";
			$txt = mysql_error();
			$headers = "From: Info@TradersAllied.com" . "\r\n";

			mail($to,$subject,$txt,$headers);
			
		}
	}
	
}	
?>