<?php 
    require_once("../include/class.php");
    require_once("config.inc.php");
    $obj = new admin;
    $obj->conn();
    
    $qry = mysql_query("select prediction_date, prediction_date1 from prediction_date where name='prediction_for'");
    $prediction_date = "";
    $prediction_date1 = "";
    $result = array();
    
    if($x = mysql_fetch_array($qry))
    {
        $prediction_date = $x['prediction_date'];
        $prediction_date1 = $x['prediction_date1'];
    }
    
    $reply = array();
    $i = 0;
    $grpname = "";
    
    $val = mysql_query("select * from predictions where prediction_date='$prediction_date1'");
    while($row  = mysql_fetch_array($val)) {
        $symbol = $row['symbol'];
        $products = mysql_fetch_array(mysql_query("SELECT a.name, b.* FROM groups AS a, products AS b WHERE b.symbol = '$symbol' AND b.group_id = a.id"));
        $groupname = $products['name'];
        $gid = $products['group_id'];
        $id = $products['id'];
        $product_name = $products['app_friendly_name'];
        $p_high = $row['p_high'];
        $p_low = $row['p_low'];
        $p_trend = $row['p_trend'];
        if($p_trend <= 0)
            $p_trend = 0;
        else
            $p_trend = 1;
        $flag = $products['img'];
        
        if($grpname != "$groupname") {
            $result['groupname'][] = "$groupname";
            $result['showLabel'][] = true;
            $grpname = "$groupname";
        }
        else
        {
            $result['showLabel'][] = false;
            $result['groupname'][] = null;
        }
        
        $result['best'][] = false;
        $result['gid'][] = "$gid";
        $result['id'][] = "$id";
        $result['name'][] = "$product_name";
        $result['predict_high'][] = "$p_high";
        $result['predict_low'][] = "$p_low";
        $result['trend'][]="$p_trend";
        $result['flag'][] = $web_url . "/$flag";
    }
    
    $reply["predictions"][] = $result;
    $reply['status'] = 1;
    die(json_encode($result));

/*require_once('../excel_reader/excel_reader2.php');
require_once("../include/class.php");
require_once("../cron/cron_custom_functions.php");
require_once("../webservice/custom_functions.php");
require_once("../cron/check_file_updates.php");

$qry=mysql_query("select prediction_date from prediction_date where name='prediction_for'");
$prediction_date="";$result=array();
if($x=mysql_fetch_array($qry))
{
$prediction_date=$x['prediction_date'];
}

$reply=array();
$i=0;
$z=0;

$xmlfile="xml_data/best.xml";
$product = simplexml_load_file($xmlfile);
$j=0;

$grpname="";

$result=array();
foreach($product->product as $oneproduct)
{

if($oneproduct->best=='1')
{
$best=true;
}
else
{
$best=false;
}
$predict_high=$oneproduct->predict_high;
$predict_low=$oneproduct->predict_low;
$predict_high="$predict_high";
$predict_low="$predict_low";


if(!empty($predict_high) or !empty($predict_low))
{
$gid=$oneproduct->gid;
$id=$oneproduct->id;
$name=$oneproduct->product_name;
$groupname=$oneproduct->groupname;
$trend=$oneproduct->trend;
$flag=$oneproduct->img_path;
if($grpname!="$groupname")
{
$result['groupname'][]="$groupname";
$result['showLabel'][]=true;
$grpname="$groupname";
}
else
{
$result['showLabel'][]=false;
$result['groupname'][]=null;
}

$result['best'][]=$best;
$result['gid'][]="$gid";
$result['id'][]="$id";
$result['name'][]="$name";
$result['predict_high'][]="$predict_high";
$result['predict_low'][]="$predict_low";
$result['trend'][]="$trend";
$result['flag'][]=$web_url."/$flag";
//$result['prediction_date']=$prediction_date;
$reply["predictions"][]=$result;
}


$i++;
}
$reply['status']=1;
die(json_encode($result));*/




/*$qry=mysql_query("select id,name from groups");/8
while($row=mysql_fetch_array($qry))
{
//$result[]['groupname']=$row['name'];
//$result[]['groupid']=$row['id'];
$groupname=$row['name'];
$gid=$row['id'];
$folder="../groups/$groupname";
$qry1=mysql_query("select id,app_friendly_name,excel_file_name,img from products where group_id='$gid'");
$j=0;
$result2=array();
while($row1=mysql_fetch_array($qry1))
{
$excel_file=$row1['excel_file_name'];
$recent = findTheRecent($folder,$excel_file);
$basic_prediction=show_basic_predictions($recent);
$result["groupname"]=$groupname;
$result["gid"]=$gid;
$result["name"]=$row1['app_friendly_name'];
$result["flag"]="$web_url/".$row1['img'];
$result["id"]=$row1['id'];
$result["predict_high"]=$basic_prediction['predict_high'];
$result["predict_low"]=$basic_prediction['predict_low'];
$result["trend"]=$basic_prediction['trend'];
$j++;
$z++;
$reply["predictions"][]=$result;
}
$i++;
}
*/



?>