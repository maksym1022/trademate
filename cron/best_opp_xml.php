<?php
error_reporting(E_ALL ^ E_NOTICE);
require_once '../excel_reader/excel_reader2.php';
include("../include/class.php");
include("../webservice/custom_functions.php");
$obj=new admin;
$obj->conn();
$i=0;
$j=0;
$result=array();
$x='<?xml version="1.0" encoding="utf-8"?>
			<best>
</best>';
file_put_contents($xml_file,$x);

$best=simplexml_load_file($xml_file);

$qry=mysql_query("select id,name from groups");
while($row=mysql_fetch_array($qry))
{
$groupname=$row['name'];
$gid=$row['id'];
$qry1=mysql_query("select id,app_friendly_name,excel_file_name,img from products where group_id='$gid'");
while($row1=mysql_fetch_array($qry1))
{
$excel_file=$row1['excel_file_name'];
$folder = "../groups/$groupname";
$recent = findTheRecent($folder,$excel_file);
$check=check_best($recent);

if($check)
{
$img_path=$web_url."/".$row1['img'];
$basic_prediction=show_basic_predictions($recent);
$pid=$row1['id'];
$pname=$row1['app_friendly_name'];
$phigh=$basic_prediction['predict_high'];
$plow=$basic_prediction['predict_low'];
$trend=$basic_prediction['trend'];


/*
$result[$j]['id']=$pid;
$result[$j]['product_name']=$pname;
$result[$j]['predict_high']=$phigh;
$result[$j]['predict_low']=$plow;
$result[$j]['trend']=$trend;
*/
$newproduct = $best->addChild('product');
$newproduct-> addChild("id", $pid);
$newproduct -> addChild("product_name", $pname);
$newproduct -> addChild("predict_high", $phigh);
$newproduct -> addChild("predict_low", $plow);
$newproduct -> addChild("trend", $trend);
$newproduct -> addChild("img_path", $img_path);
$j++;
}
}
$i++;
}

if(file_put_contents($xml_file,$best->asXML()))
{
echo "updated successfully";

}









/*
$groups=glob("../groups/Forex");
foreach($groups as $group)
{
$products=glob("../groups/".$group."/*.XLS");
foreach($products as $excel)
{
echo "$excel:";
$check=check_best($excel);
if($check)
{
echo "yo";
}
else
{
echo "no";
}
echo "<br>";
}
}
*/
?>