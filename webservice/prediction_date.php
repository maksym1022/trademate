<?php 
/*require_once("../include/class.php");
$obj = new admin;
$obj->conn();

$qry = mysql_query("select prediction_date from prediction_date where name='prediction_for'");
$prediction_date = "";
if($x = mysql_fetch_array($qry))
{
    $prediction_date = $x['prediction_date'];
}*/

require_once("../include/class.php");
$obj = new admin;
$obj->conn();

date_default_timezone_set('America/Chicago');

$hour = date(H);
    
if($hour < 17) {
    $prediction_date = date("j") . " " . date("F") . " " . date("Y");
    $prediction_date1 = date("Y") . "-" . date("m") . "-" . date("d");
} else {
    $prediction_date = date("j", time() + 86400) . " " . date("F", time() + 86400) . " " . date("Y", time() + 86400);
    $prediction_date1 = date('Y', time() + 86400) . date('m', time() + 86400) . date('d', time() + 86400);
}

$query = "update prediction_date set prediction_date='$prediction_date', prediction_date1='$prediction_date1'";
mysql_query($query);

$reply[]['prediction_date'] = $prediction_date;
die(json_encode($reply));
?>
