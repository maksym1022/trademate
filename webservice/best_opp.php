<?php 

require_once('../excel_reader/excel_reader2.php');
require_once("../include/class.php");
require_once("../cron/cron_custom_functions.php");
require_once("../webservice/custom_functions.php");
require_once("../cron/check_file_updates.php");



$xmlfile="xml_data/best.xml";
$product = simplexml_load_file($xmlfile);
$j = 0;
$result = array();
$grpname = "";
foreach($product->product as $oneproduct)
{
if($oneproduct->best=='1')
{
$groupname=$oneproduct->groupname;
$gid=$oneproduct->gid;
$id=$oneproduct->id;
$product_name=$oneproduct->product_name;
$predict_high=$oneproduct->predict_high;
$predict_low=$oneproduct->predict_low;
$trend=$oneproduct->trend;
$img_path=$oneproduct->img_path;
if($grpname!="$groupname")
{
$result['groupname'][$j]="$groupname";
$result['gid'][$j]="$gid";
$grpname="$groupname";
}
else
{
$result['groupname'][$j]=null;
$result['gid'][$j]=null;
}


$result['id'][$j]="$id";
$result['product_name'][$j]="$product_name";
$result['predict_high'][$j]="$predict_high";
$result['predict_low'][$j]="$predict_low";
$result['trend'][$j]="$trend";
$result['img_path'][$j]="$web_url/$img_path";

$j++;
}}
$reply['success']=1;
$reply['best']=$result;
$product->asXML($xmlfile);
die(json_encode($result));
?>