<?php
    include("include/class.php");
    $obj = new admin;
    $obj->conn();
    
    $last_month = date("m") - 1;
    $monthArr = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
    $month = $monthArr[$last_month - 1];

//    $last_month = 9;
    $current_year = date("Y");
    
    if(1 < $last_month && $last_month < 10) {
        $last_month = "0" . $last_month;
    }
    else if($last_month == 0) {
        $last_month = 12;
    }
    
    $date = $current_year . "-" . $last_month . "-";
    
    $value = mysql_query("select * from signup where joined_on like '%" . $date . "%'");
    $count = mysql_num_rows($value);
    
    $to = 'ross@tradersallied.com';
//    $to = 'bond00719900504@gmail.com';
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= "From: info@tradersallied.com";
    $subject = "Monthly Report";
    $mailtext = "Dear Ross,<br />There has been " . $count . " registered users on zumbatrade/tradematese during the month of " . $month . " " . $current_year . ".<br />Regards, TradeMateFB";
    
    $mail = mail($to, $subject, $mailtext, $headers); 
    
    if($mail){
      echo "Thank you for using our mail form";
    } else {
      echo "Mail sending failed."; 
    }
?>
