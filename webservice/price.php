<?php

 require("config.inc.php");
 $db_con = mysql_connect($host, $username,$password) or die('could not connect');
 mysql_select_db( $dbname);
 $sql = "SELECT * FROM price WHERE  id = '". $_POST["id"]."'";
 $result = mysql_query($sql);
 while($row=mysql_fetch_assoc($result))
  $output[]=$row;
 print(json_encode($output));
 mysql_close();   
?>

