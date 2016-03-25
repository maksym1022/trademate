<?php
include("include/class.php");
$obj=new admin;
$obj->conn();
//$obj->start=$_REQUEST['start'];
if(isset($_REQUEST['grpid']))
{
$id=$_REQUEST['grpid'];
$error=$_FILES['groupimg']['error'];

		if(($error>0) && empty($_REQUEST['gname']))
		{
		die("Enter some data!");
		}
		if(!empty($_REQUEST['gname']) )
		{
				$gname=$_REQUEST['gname'];
				if(!file_exists("groups/".$gname))
				{
				$new_icon="groups/$gname/$gname.jpg";
				$value1=mysql_fetch_array(mysql_query("select * from groups where id=$id"));
				rename("groups/".$value1['name'],"groups/".$gname);
				if(file_exists("groups/$gname/".$value1['name'].".jpg"))
				rename("groups/$gname/".$value1['name'].".jpg",$new_icon);
				$value=mysql_query("update groups set name='$gname',img='$new_icon' where id=$id");
				}
				else
				{
				 echo "Folder already exists!!";
				}
		}
		if($error==0)
		{
		$tmp=$_FILES['groupimg']['tmp_name'];
		$value1=mysql_fetch_array(mysql_query("select * from groups where id=$id"));
		$url=$value1['img'];
			if(file_exists($url))
			{
			unlink($url);
			}
		move_uploaded_file($tmp,$url);
		}
	
	echo "Group data updated Successfully";
}

?>