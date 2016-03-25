<?php
error_reporting(E_ALL ^ E_NOTICE);
require_once("../include/class.php");
require_once("config.inc.php");
$obj = new admin;
$obj->conn();

if(isset($_REQUEST['id'])) {
    $pid = $_REQUEST['id'];
    $query = "SELECT * FROM products WHERE id='$pid'";
    $row = mysql_fetch_array(mysql_query($query));
    $symbol = $row['symbol'];
    
    $query = "select * from historical_data where symbol='$symbol' order by tradingDay desc limit 1, 23";
    $value = mysql_query($query);
    
    $result = array();
    $i = 0;
    
    while($res = mysql_fetch_array($value)) {
        $tradingDay = $res['tradingDay'];
        $temp = explode("-", $tradingDay);
        
        $dateObj   = DateTime::createFromFormat('!m', $temp[1]);
        $monthName = $dateObj->format('F');
        $day = $temp[2] . " " . $monthName . " " . $temp[0];
        
        $decimal = 0;
        $tmp = explode(".", $res['open']);
        $length = strlen($tmp[1]);
        if($length > $decimal) {
            $decimal = $length;
        }
        $tmp = explode(".", $res['high']);
        $length = strlen($tmp[1]);
        if($length > $decimal) {
            $decimal = $length;
        }
        $tmp = explode(".", $res['close']);
        $length = strlen($tmp[1]);
        if($length > $decimal) {
            $decimal = $length;
        }
        $tmp = explode(".", $res['low']);
        $length = strlen($tmp[1]);
        if($length > $decimal) {
            $decimal = $length;
        }
        
        $exp = 2 / 3;
        $temp = mysql_fetch_array(mysql_query("select * from historical_data where symbol='$symbol' and tradingDay<'$tradingDay' order by tradingDay desc limit 1"));
        $temp2 = mysql_fetch_array(mysql_query("select * from historical_data where symbol='$symbol' and tradingDay<'$tradingDay' order by tradingDay desc limit 1, 1"));
        $temp3 = mysql_fetch_array(mysql_query("select * from historical_data where symbol='$symbol' and tradingDay<'$tradingDay' order by tradingDay desc limit 2, 1"));
        $temp4 = mysql_fetch_array(mysql_query("select * from historical_data where symbol='$symbol' and tradingDay<'$tradingDay' order by tradingDay desc limit 3, 1"));
        $p_high2 = number_format((($temp2['ema_high'] * (1 - $exp)) + ($temp['ema_high'] * $exp)), $decimal, ".", "");
        $p_low2 = number_format((($temp2['ema_low'] * (1 - $exp)) + ($temp['ema_low'] * $exp)), $decimal, ".", "");
        $p_close2 = number_format((($temp2['ema_close'] * (1 - $exp)) + ($temp['ema_close'] * $exp)), $decimal, ".", "");
        $p_trend = number_format((($p_high2 + $p_low2 + $p_close2) / 3 - $temp['sma_typical']), $decimal, ".", "");
        if($p_trend == 0) {
            $p_high2 = number_format((($temp3['ema_high'] * (1 - $exp)) + ($temp2['ema_high'] * $exp)), $decimal, ".", "");
            $p_low2 = number_format((($temp3['ema_low'] * (1 - $exp)) + ($temp2['ema_low'] * $exp)), $decimal, ".", "");
            $p_close2 = number_format((($temp3['ema_close'] * (1 - $exp)) + ($temp2['ema_close'] * $exp)), $decimal, ".", "");
            $p_trend = number_format((($p_high2 + $p_low2 + $p_close2) / 3 - $temp2['sma_typical']), $decimal, ".", "");
            if($p_trend == 0) {
                $p_high2 = number_format((($temp4['ema_high'] * (1 - $exp)) + ($temp3['ema_high'] * $exp)), $decimal, ".", "");
                $p_low2 = number_format((($temp4['ema_low'] * (1 - $exp)) + ($temp3['ema_low'] * $exp)), $decimal, ".", "");
                $p_close2 = number_format((($temp4['ema_close'] * (1 - $exp)) + ($temp3['ema_close'] * $exp)), $decimal, ".", "");
                $p_trend = number_format((($p_high2 + $p_low2 + $p_close2) / 3 - $temp3['sma_typical']), $decimal, ".", "");
            }
        }
        
        // for actual trend
        $p_high2_a = number_format((($temp['ema_high'] * (1 - $exp)) + ($res['ema_high'] * $exp)), $decimal, ".", "");
        $p_low2_a = number_format((($temp['ema_low'] * (1 - $exp)) + ($res['ema_low'] * $exp)), $decimal, ".", "");
        $p_close2_a = number_format((($temp['ema_close'] * (1 - $exp)) + ($res['ema_close'] * $exp)), $decimal, ".", "");
        $p_trend_a = number_format((($p_high2_a + $p_low2_a + $p_close2_a) / 3 - $res['sma_typical']), $decimal, ".", "");
        if($p_trend_a == 0) {
            $p_high2_a = number_format((($temp2['ema_high'] * (1 - $exp)) + ($temp['ema_high'] * $exp)), $decimal, ".", "");
            $p_low2_a = number_format((($temp2['ema_low'] * (1 - $exp)) + ($temp['ema_low'] * $exp)), $decimal, ".", "");
            $p_close2_a = number_format((($temp2['ema_close'] * (1 - $exp)) + ($temp['ema_close'] * $exp)), $decimal, ".", "");
            $p_trend_a = number_format((($p_high2_a + $p_low2_a + $p_close2_a) / 3 - $temp['sma_typical']), $decimal, ".", "");
            if($p_trend_a == 0) {
                $p_high2_a = number_format((($temp3['ema_high'] * (1 - $exp)) + ($temp2['ema_high'] * $exp)), $decimal, ".", "");
                $p_low2_a = number_format((($temp3['ema_low'] * (1 - $exp)) + ($temp2['ema_low'] * $exp)), $decimal, ".", "");
                $p_close2_a = number_format((($temp3['ema_close'] * (1 - $exp)) + ($temp2['ema_close'] * $exp)), $decimal, ".", "");
                $p_trend_a = number_format((($p_high2_a + $p_low2_a + $p_close2_a) / 3 - $temp2['sma_typical']), $decimal, ".", "");
            }
        }
        
        if($p_trend < 0) {
            $p_trend = 0;
        } else {
            $p_trend = 1;
        }
        if($p_trend_a < 0) {
            $p_trend_a = 0;
        } else {
            $p_trend_a = 1;
        }
        
        if($p_trend == 1 && $p_trend_a == 0) {
            $p_trend_a = 0;
        }
        if($p_trend == 0 && $p_trend_a == 1) {
            $p_trend_a = 1;
        }
        $p_trend_a = $p_trend;
        
        $a_high = $res['high'];
        $a_low = $res['low'];
        $p_high = $temp['ema_high'];
        $p_low = $temp['ema_low'];
        
        $performance = 0;
        
        if($p_high <= $a_high && $p_low >= $a_low){
            $performance = 100;
        }
        else if($p_high <= $a_high || $p_low >= $a_low){
            $performance = 75;
        }
        else if(!($p_high <= $a_high || $p_low >= $a_low)){
            $performance = 50;
        }
        
        $result["day"][$i] = $day;
        $result["trend"][$i] = $p_trend;
        $result["actual_trend"][$i] = $p_trend_a;
        $result["predicted_high"][$i] = $p_high;
        $result["predicted_low"][$i] = $p_low;
        $result["actual_high"][$i] = $a_high;
        $result["actual_low"][$i] = $a_low;
        $result["performance"][$i] = $performance;
        
        $i ++;
    }
    
    $reply["predictions"][] = $result;
    $reply['status'] = 1;
    die(json_encode($result));
}

/*include("../include/class.php");
require_once '../excel_reader/excel_reader2.php';
include("custom_functions.php");
$obj=new admin;
$obj->conn();
if(isset($_REQUEST['id']))
{
    $pid=$_REQUEST['id'];
            
    $qry=mysql_query("select cpf from products where id='$pid'");
    if($x=mysql_fetch_array($qry))
    {
    //$gname=$obj->show_group_name($x['group_id']);
    $recent = $x['cpf'];
    $week_prediction=prediction_week($recent);
    $reply["predictions"]=$week_prediction;
    die(json_encode($week_prediction));
    }
}
else
{
    $pid=101;
    $qry=mysql_query("select group_id,app_friendly_name,excel_file_name from products where id='$pid'");
    if($x=mysql_fetch_array($qry))
    {
        $gname=$obj->show_group_name($x['group_id']);
        $excel_file=$x['excel_file_name'];
        $folder="../groups/$gname";
        $recent = findTheRecent($folder,$excel_file);
        $week_prediction=prediction_week($recent);
        $reply["predictions"]=$week_prediction;
        die(json_encode($week_prediction));
    }
}*/
?>