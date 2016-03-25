<?php 
error_reporting(E_ALL ^ E_NOTICE);
require_once('../excel_reader/excel_reader2.php');
require_once("../include/class.php");
require_once("../cron/cron_custom_functions.php");
require_once("../webservice/custom_functions.php");
date_default_timezone_set('America/Chicago');
$current_time = 0;
$filepath = "../groups";
$xml_file = "../webservice/xml_data/best.xml";
/*
$hit_time=date('Ymd')."040606";
*/
$hit_time = date('Ymdhis');
$obj = new admin;
$obj->conn();
$qry = mysql_query("select timestamp,last_fetch from changes where name='filechanges'") or die('nope');
if($row = mysql_fetch_array($qry))
{
    $current_time=check_folder_changed($filepath);
    //put_best_opp($xml_file);
    if($row['timestamp'] != intval($current_time))
	{
		$flag = put_best_opp($xml_file);

		if($flag)
		{
		    $qry = mysql_query("update changes set timestamp='$current_time' where name='filechanges'") or die('nope');
		}
    }
}
?>