<?php 
//    require_once('../excel_reader/excel_reader2.php');
    require_once("../include/class.php");
    require_once("config.inc.php");
//    require_once("../cron/cron_custom_functions.php");
//    require_once("../webservice/custom_functions.php");
//    require_once("../cron/check_file_updates.php");
    
    $obj = new admin;
    $obj->conn();
    $qry = mysql_query("select id,name,img from groups order by id");
    $result = array();
    $i = 0;
    while($row = mysql_fetch_array($qry))
    {
        $result["gid"][$i] = $row['id'];
        $result["name"][$i] = $row['name'];
        $result["img"][$i] = "$web_url/" . $row['img'];
        $i++;
    }
    $reply['groups'] = $result;
    die(json_encode($result));
?>