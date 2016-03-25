<?php
include("../include/class.php");

include("custom_functions.php");
error_reporting(E_ALL ^ E_NOTICE);
require_once '../excel_reader/excel_reader2.php';
$obj=new admin;
$obj->conn();
?>

<?php 
if(isset($_REQUEST['id']))
{
$pid=$_REQUEST['id'];
$recent="";		
$qry=mysql_query("select cpf from products where id='$pid'");
if($x=mysql_fetch_array($qry))
{
$recent = $x['cpf'];
$reply=array();
$daily_prediction=prediction_day($recent,$pid);
$reply['predictions']=$daily_prediction;
die(json_encode($daily_prediction));
}
}
else
{
$pid=101;
$recent="";		
$qry=mysql_query("select cpf from products where id='$pid'");
if($x=mysql_fetch_array($qry))
{
$recent = $x['cpf'];
$reply=array();
$daily_prediction=prediction_day($recent,$pid);
$reply['predictions']=$daily_prediction;
die(json_encode($daily_prediction));}
}
?>