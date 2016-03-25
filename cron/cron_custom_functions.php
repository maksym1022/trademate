<?php
 

/*-------------------------------------------------------------------------------------*/

function check_folder_changed($filepath)
{
$total=filemtime($filepath);
//echo "<br>Name:$filepath<br>";
//echo "<br>total:$total<br>";
$folder=glob("$filepath/*");
foreach($folder as $files)
{
if(is_dir($files))
{
$total+=filemtime($files);
//echo "<br>SUbName:$files<br>";
//echo "<br>total:$total<br>";
}
}
return $total;
}

/*-------------------------------------------------------------------------------------*/

function put_best_opp($xml_file)
{
ini_set('max_execution_time', 500);
$i=0;
$j=0;
$check_date_flag=true;
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
$id=$row1['id'];
$newtimestamp=date('Y-m-d H:i:s');
$excel_file=$row1['excel_file_name'];
$folder = "../groups/$groupname";

$recent = findTheRecent($folder,$excel_file);


$qry3=mysql_query("update products set cpf='$recent',timestamp='$newtimestamp' where id='$id'");
$check=check_best($recent);


$img_path=$row1['img'];
$basic_prediction=show_basic_predictions($recent);


if($check_date_flag)
{

$tradebook_predictions=show_basic_tradebook($recent,"sdfsd");
$check_date_flag=false;
}
else
{
$tradebook_predictions=show_basic_tradebook($recent);
}
$pname=$row1['app_friendly_name'];
$phigh=$basic_prediction['predict_high'];
$plow=$basic_prediction['predict_low'];
$trend=$basic_prediction['trend'];

$entry_price=$tradebook_predictions['entry_price'];
$exit_buy=$tradebook_predictions['exit_buy'];
$exit_sell=$tradebook_predictions['exit_sell'];


$newproduct = $best->addChild('product');


$newproduct-> addChild("groupname", $groupname);

$newproduct-> addChild("gid", $gid);

$newproduct-> addChild("id", $id);
$newproduct -> addChild("product_name", $pname);
$newproduct -> addChild("predict_high", $phigh);
$newproduct -> addChild("predict_low", $plow);
$newproduct -> addChild("trend", $trend);
$newproduct -> addChild("img_path", $img_path);

$newproduct -> addChild("entry_price", $entry_price);
$newproduct -> addChild("exit_buy", $exit_buy);
$newproduct -> addChild("exit_sell", $exit_sell);

if($check)
{
$newproduct -> addChild("best",'1');
}
else {$newproduct -> addChild("best",'0');}
}
$i++;
}
if(file_put_contents($xml_file,$best->asXML()))
{
return true;
}
else
{
return false;
}
}
function check_fetch_time($time)
{
$first_min_time=intval(date('Ymd')."010000");
$first_max_time=intval(date('Ymd')."030000");

$sec_min_time=intval(date('Ymd')."040000");
$sec_max_time=intval(date('Ymd')."060000");

$third_min_time=intval(date('Ymd')."070000");
$third_max_time=intval(date('Ymd')."090000");

if($time<$first_min_time || $time>$third_max_time)
{return false;}
else if($time>=$first_min_time && $time<=$first_max_time )
{return 1;}
else if($time>=$sec_min_time && $time<=$sec_max_time )
{return 2;}
else if($time>=$third_min_time && $time<=$third_max_time )
{return 3;}

}


?>