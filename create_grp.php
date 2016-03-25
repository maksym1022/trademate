		 <?php		 		 
		 include("include/class.php");
		
		 $obj=new admin;
		 $obj->conn();
		
		/*if(isset($_REQUEST['groupname']))
		{		
		$group_name=$_REQUEST['groupname'];
		$name=$_FILES['grpimg']['name'];
		$tmp_name=$_FILES['grpimg']['tmp_name'];
		
		echo $flag=$obj->check_group_exist($group_name);
		if($flag=='1' || $flag=='2')
		{
		$url="groups/".$group_name."/".$group_name.".jpg";
		if(file_exists($url))
		{
		unlink($url);
		}
		move_uploaded_file($tmp_name,$url);
		}
		
		}
		*/

		
		
		
		
		
		
		
		if(isset($_REQUEST['create']))
{		
		 if(isset($_REQUEST['groupname']))
		 {
		 $group_name=$_REQUEST['groupname'];
		 if(strlen($group_name)>1)
		 {
		 echo $obj->check_group_exist($group_name);
		 }}
}

if(isset($_REQUEST['operation']))
{
$op=$_REQUEST['operation'];
$group_name=$_REQUEST['groupname'];
$url="groups/".$group_name."/".$group_name.".jpg";
$name=$_FILES['grpimg']['name'];
$tmp_name=$_FILES['grpimg']['tmp_name'];
	if($op==3)
{

		if(file_exists($url))
		{
		unlink($url);
		}
		move_uploaded_file($tmp_name,$url);
}	
else if($op==2)
{
$qry="insert into groups(name,img) values('$group_name','$url')";
		 $qry=mysql_query($qry);
$obj->remove_path("groups/".$group_name);
 mkdir("groups/".$group_name);	
 if(file_exists($url))
		{
		unlink($url);
		}
		move_uploaded_file($tmp_name,$url);
echo "replaced group successfully";
}
else if($op==1)
{
$url="groups/".$group_name."/".$group_name.".jpg";

$qry="insert into groups(name,img) values('$group_name','$url')";
		 $qry=mysql_query($qry);
		 
		 
		 if(!file_exists($url))
		{
		move_uploaded_file($tmp_name,$url);
		}
	
echo "merged group successfully";
}

}

		 
		 /* 
		 
		 $qry="insert into groups(name) values('$group_name')";
		 $qry=mysql_query($qry);
		 if($qry)
		 {
		 if(!file_exists("groups/".$group_name))
		 {
		 mkdir("groups/".$group_name);	
		 echo "1";
		 }
		 else
		 {
		 echo "2";	
		 }	
		 }
		 else	
		 {
		 echo "Group could not be created.Try again with another name!";
		 }	
		 */
		 
		
		 ?>