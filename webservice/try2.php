<?php
include("../include/class.php");
include("custom_functions.php");
error_reporting(E_ALL ^ E_NOTICE);
require_once '../excel_reader/excel_reader2.php';

$obj=new admin;
$obj->conn();
$reply=array();
$i=0;
$z=0;
$qry=mysql_query("select id,name from groups");
while($row=mysql_fetch_array($qry))
{
//$result[$i]['groupname']=$row['name'];
//$result[$i]['groupid']=$row['id'];
$groupname=$row['name'];
$gid=$row['id'];
$folder="../groups/$groupname";
$qry1=mysql_query("select id,app_friendly_name,excel_file_name from products where group_id='$gid'");
$j=0;
$result=array();
while($row1=mysql_fetch_array($qry1))
{
$result1=array();

$excel_file=$row1['excel_file_name'];
$recent = findTheRecent($folder,$excel_file);
$basic_prediction=show_basic_predictions($recent);
$result1["name"]=$row1['app_friendly_name'];
$result1["id"]=$row1['id'];
$result1["predict_high"]=$basic_prediction['predict_high'];
$result1["predict_low"]=$basic_prediction['predict_low'];
$result1["trend"]=$basic_prediction['trend'];
$result[]=$result1;
$j++;
$z++;
}
$reply["predictions"][$groupname]["product"]=$result;

$i++;
}
die(json_encode($reply));
?>