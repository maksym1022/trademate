<?php 
include("../include/class.php");
include("../webservice/custom_functions.php");
include("../cron/cron_custom_functions.php");
$xml_file="../webservice/xml_data/best.xml";

$obj=new admin;
$obj->conn();

function rawTimeStamp($timestamp)
{
$date=explode(" ",$timestamp);
$time=$date[1];

$day=$date[0];
$day=explode("-",$day);
$time=explode(":",$time);
$raw['raw_timestamp']=$day[0].$day[1].$day[2].$time[0].$time[1].$time[2];
$raw['time']=$time[0].$time[1].$time[2];
return $raw;
}
function memory_timestamp($id)
{
$qry=mysql_query("select timestamp from products where id='$id'");
if($row=mysql_fetch_array($qry))
{
return $row;
}
else { return false;}
}

/* hit to this page will only come when app is online mode so starting from algo step 1.2 */
echo"<br>Android:". $android_timestamp="2014-06-06 22:22:22";
$flag_local=1;
$id=2;
// signifies local data present or not
echo "<br>Server :".$server_timestamp=date('Y-m-d H:i:s');
echo "<br>".date_default_timezone_get();
$memory_data=memory_timestamp($id);
echo "<br>Memory :".$memory_timestamp=$memory_data['timestamp'];
$raw_android_timestamp=rawTimeStamp($android_timestamp);
$raw_server_timestamp=rawTimeStamp($server_timestamp);
$raw_memory_timestamp=rawTimeStamp($memory_timestamp);
echo "<br>Fetch time:".$first_fetch_time=date('Ymd')."010000";


if($flag_local)
{
if($raw_server_timestamp['raw_timestamp']<=$raw_android_timestamp['raw_timestamp'])
{
echo "<br>yo";

if(intval($raw_memory_timestamp)<intval($first_fetch_time))
{
$flag=put_best_opp($xml_file);
if($flag)
{
$qry=mysql_query("update changes set flag='1',timestamp='$current_time' where name='filechanges'");
$subject="timestamp changed";
$txt.=" changed";

mail($to,$subject,$txt,$headers);
echo "timestamp changed";
}
else
{
$subject="Couldn't save changes to file";
$txt.="couldn't update";

mail($to,$subject,$txt,$headers);
echo "Couldn't save changes to file";
}


}
else
{
echo "<br>show from memory";
}



}
else
{
//echo "<br>".$raw_server_timestamp['raw_timestamp']-$raw_android_timestamp['raw_timestamp'];
echo "<br>fetch from memory";
}
}
else {}

?>