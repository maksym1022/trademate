<?php
error_reporting(E_ALL ^ E_NOTICE);
require_once '../excel_reader/excel_reader2.php';
$data = new Spreadsheet_Excel_Reader("../excel_files/Data File for selected product.xls");
?>

<?php 
//echo $data->dump(true,true);
$result=array();
for($i=2;$i<10;$i++)
{

$y=$i+1;//previous row
$date=$data->val($i,'A');//date
$date=explode('/',$date);
$day=$date[2];
$month=$date[1];
$year=$date[0];


$prediction_c=$data->val($i,'F');//trend current
$predict_high=$data->val($i,'H');//predicted high
$predict_low=$data->val($i,'I');//predicted low
$strength_c=$data->val($i,'G');//strength current
$strength_p=$data->val($y,'G');//strength previous
$prediction_p=$data->val($y,'F');//trend previous

$conviction_c=0;// conviction current
$conviction_p=0;// conviction previous
$response['message']='';
if($prediction_c=='1')
{
$conviction_c=$strength_c-$strength_p;
}
else
{
$conviction_c=$strength_p-$strength_c;
}
if($prediction_p=='1')
{
$conviction_p=$strength_c-$strength_p;
}
else
{
$conviction_p=$strength_p-$strength_c;
}
$result[$i-2]["day"]=$day;
$result[$i-2]["month"]=$month;
$result[$i-2]["year"]=$year;
$result[$i-2]["trend"]=$prediction_c;
$result[$i-2]["predicted_high"]=$predict_high;
$result[$i-2]["predicted_low"]=$predict_low;
$result[$i-2]["conviction_c"]=$conviction_c;
$result[$i-2]["conviction_p"]=$conviction_p;
}
$reply["predictions"]=$result;
$reply["success"]=1;
die(json_encode($reply));
?>
