<?php 
session_start();
include("include/class.php");

function add_days($date, $days) {
    $date = explode(" ", $date);
    $date = $date[0];
    $date1 = explode("-", $date);
    $year = intval($date1[0]);
    $month = intval($date1[1]);
    $day = intval($date1[2]);
    $eday = 0;
    $emonth = 0;
    $eyear = 0;
    $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $day);
    if(($month != 12) || ($month == 12 && $day <= $days_in_month - $days))
    {
        if($day <= ($days_in_month - $days))
        {
            $eday = $day + $days;
            $emonth = $month;
            $eyear = $year;
        }
        else
        {
            $eyear = $year;
            $emonth = $month + 1;
            $eday = $day + $days - $days_in_month;
        }
    }
    else
    {
        $eyear = $year + 1;
        $emonth = 1;
        $eday = $day + $days - $days_in_month;
    }
    if($emonth < 10)
    {
        $emonth = "0" . $emonth;
    }
    if($eday < 10)
    {
        $eday = "0" . $eday;
    }
    $edate = "$eyear-$emonth-$eday";
    return $edate;
}

$obj = new admin;
//global $start;
$obj->conn();

if(isset($_REQUEST['edit_password'])) {
    $id = $_REQUEST['userid'];
    $pwd = $_REQUEST['pwd'];
    $status = $_REQUEST['status'];
    $old_date = date('Y-m-d');
    $old_date = "$old_date";
    $new_date = "";
    if($status == '0')
    {
        $new_date = add_days($old_date, 7);
    }
    else if($status == '1')
    {
        $new_date = $old_date;
    }
    else if($status == '2')
    {
        $new_date = add_days($old_date, 30);
    }
    else if($status == '3')
    {
        $new_date = $old_date;
    }

    $value = mysql_query("update signup set password='$pwd',status='$status',expiring_on='$new_date' where id='$id'");
    if($value)
    {
        $obj->search_users($uname, $email, $status3);
    }
    else
    {
        echo "Password Change Not Successful !" . mysql_error();
    }
} 
?>