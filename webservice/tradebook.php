<?php 
error_reporting(E_ALL ^ E_NOTICE);
require_once("../include/class.php");
require_once("config.inc.php");
$obj = new admin;
$obj->conn();

$reply=array();

if(isset($_REQUEST['gid']))
{
    $group_id = $_REQUEST['gid'];
    
    $query = "select * from prediction_date where name='prediction_for'";
    $prediction_date = mysql_fetch_array(mysql_query($query));
    $prediction_date = $prediction_date['prediction_date1'];
    
    $query = "select * from products where group_id='$group_id'";
    $val = mysql_query($query);
    
    while($res = mysql_fetch_array($val)) {
        $symbol = $res['symbol'];
        $name = $res['app_friendly_name'];
        $query1 = "select * from predictions where symbol='$symbol' and prediction_date='$prediction_date'";
        $temp = mysql_fetch_array(mysql_query($query1));
        
        $p_trend = $temp['p_trend'];
        if($p_trend < 0) {
            $p_trend = 0;
        } else {
            $p_trend = 1;
        }
        
        $p_high = $temp['p_high'];
        $p_low = $temp['p_low'];
        
        if($p_trend == 1) {
            $dir = "Long";
            $entry_price = ((3 * $p_low) + $p_high) / 4;
            $exit_sell = ($p_high + $p_low) / 2;//exit sell
            $exit_buy = "";//exit buy
        }
        else if($p_trend == "0")
        {    
            $dir = "Short";
            $entry_price = ((3 * $p_high) + $p_low) / 4;
            $exit_sell = "";
            $exit_buy = ($p_high + $p_low) / 2;
        }
        
        $result['gid'][] = "$group_id";
        $result['name'][] = "$name";
        $result['direction'][] = "$p_trend";
        $result['entry_price'][] = "$entry_price";
        $result['exit_buy'][] = "$exit_buy";
        $result['exit_sell'][] = "$exit_sell";
    }

    $reply["trade"] = $result;
    die(json_encode($result));
}
/*require_once('../excel_reader/excel_reader2.php');
require_once("../include/class.php");
require_once("../cron/cron_custom_functions.php");
require_once("../webservice/custom_functions.php");
require_once("../cron/check_file_updates.php");

$xmlfile="xml_data/best.xml";
$product = simplexml_load_file($xmlfile);
$reply=array();
if(isset($_REQUEST['gid']))
{
$group_id=$_REQUEST['gid'];
foreach($product->product as $oneproduct)
{
if($group_id==$oneproduct->gid)
{
$gid=$oneproduct->gid;
$name=$oneproduct->product_name;
$entry_price=$oneproduct->entry_price;
$exit_buy=$oneproduct->exit_buy;
$exit_sell=$oneproduct->exit_sell;
$trend=$oneproduct->trend;
$result['gid'][]="$gid";
$result['name'][]="$name";
$result['direction'][]="$trend";
$result['entry_price'][]="$entry_price";
$result['exit_buy'][]="$exit_buy";
$result['exit_sell'][]="$exit_sell";
}}

$reply["trade"]=$result;
die(json_encode($result));
}
else
foreach($product->product as $oneproduct)
{
$entry_price=$oneproduct->entry_price;
$entry_price="$entry_price";
if(!empty($entry_price) or !$entry_price=="" )
{
$gid=$oneproduct->gid;
$name=$oneproduct->product_name;
$exit_buy=$oneproduct->exit_buy;
$exit_sell=$oneproduct->exit_sell;
$trend=$oneproduct->trend;
$result['gid']="$gid";
$result['name']="$name";
$result['entry_price']="$entry_price";
$result['exit_buy']="$exit_buy";
$result['exit_sell']="$exit_sell";
$result['direction']="$trend";
}
}*/
?>