<?php 
include("include/class.php");
$obj=new admin;$obj->conn();	

if(isset($_REQUEST['operation']))
{
		$group_id=$_REQUEST['group_id'];
		$group_name=$obj->show_group_name($group_id);
		$product_app_name=$_REQUEST['product_app_name'];
//		$image_name = date('YmdHis');
        $image_name = str_replace(' ', '', $product_app_name);
		$desc=$_REQUEST['desc'];
		$excel_file_name = $_REQUEST['product_xl_name'];
		$uname=$group_name."_".$image_name;
		$op=$_REQUEST['operation'];
		$url="groups/".$group_name;
		$image_url=$url."/".$image_name.".jpg";
		$tmp_name=$_FILES['product_icon']['tmp_name'];
	if($op==3)
	{
		if(file_exists($image_url))
		{
		unlink($image_url);
		}
		move_uploaded_file($tmp_name,$image_url);
	}	
	else if($op==2)
	{
	$qry1="insert into products(group_id,app_friendly_name,description,excel_file_name,uid,img) values('$group_id','$product_app_name','$desc','$excel_file_name','$uname','$image_url')";
	 $qry2=mysql_query($qry1);
	 if(file_exists($image_url))
		{
		unlink($image_url);
		}
		move_uploaded_file($tmp_name,$image_url);
echo "replaced product successfully";
}
else if($op==1)
{

$qry1="insert into products(group_id,app_friendly_name,description,excel_file_name,uid,img) values('$group_id','$product_app_name','$desc','$excel_file_name','$uname','$image_url')";
		 $qry2=mysql_query($qry1);

		 if(!file_exists($image_url))
		{
		move_uploaded_file($tmp_name,$image_url);
		}
		
		 
echo "merged product successfully";
}

}
		 
		 if(isset($_REQUEST['create']))		
		 {				
	         $group_id = $_REQUEST['group_id'];
	         $product_app_name = $_REQUEST['product_app_name'];
	         $desc = $_REQUEST['desc'];
             $excel_file_name = $_REQUEST['product_xl_name'];
             $product_symbol_name = $_REQUEST['product_symbol_name'];
//             $startdate = $_REQUEST['startdate'];
//             $enddate = $_REQUEST['enddate'];
//             $starttime = $_REQUEST['starttime'];
//	         $endtime = $_REQUEST['endtime'];
             echo $obj->check_product_exist($group_id, $product_app_name, $desc, $excel_file_name, $product_symbol_name);
//             echo $obj->check_product_exist($group_id, $product_app_name, $desc, $excel_file_name, $product_symbol_name, $starttime, $endtime);
//	         echo $obj->check_product_exist($group_id, $product_app_name, $desc, $excel_file_name, $product_symbol_name, $startdate, $enddate, $starttime, $endtime);
		 }
		 
		 if(isset($_REQUEST['assoc']))		
		 {	
		 
		 $group_id=$_REQUEST['group_id'];
		 $op=$_REQUEST['op'];
		 $group_name=$obj->show_group_name($group_id);
		 $product_app_name=$_REQUEST['product_app_name'];
		 
		 $desc=$_REQUEST['desc'];
		 $excel_file_name = $_REQUEST['product_xl_name'];
		$uid=$group_name."_".$product_app_name;		 
		 if($op==1)
{

		
		 $qry="insert into products(group_id,app_friendly_name,description,excel_file_name,uid) values($group_id,'$product_app_name','$desc','$excel_file_name','$uid')";
		 $qry=mysql_query($qry) ;
		 
}
if($op==2)
{
$qry="insert into products(group_id,app_friendly_name,description,excel_file_name,uid) values($group_id,'$product_app_name','$desc','$excel_file_name','$uid')";
		 $qry=mysql_query($qry) ;
$obj->remove_path("groups/".$group_name."/".$product_app_name);
 mkdir("groups/".$group_name."/".$product_app_name);	
echo "$product_app_name replaced";
}
}
		 /* 
		
		 $ext=explode(".",$_FILES['product_xl_name'][name]);					$ext=end($ext);					$excel_file_name=$group_name."_".$product_app_name.".".$ext; 					if(move_uploaded_file($_FILES['product_xl_name'][tmp_name],"groups/".$group_name."/".$excel_file_name))					{		
		 $uid=$group_name."_".$product_app_name;
		 $qry="insert into products(group_id,app_friendly_name,description,excel_file_name,uid) values($group_id,'$product_app_name','$desc','$excel_file_name','$uid')";
		 $qry=mysql_query($qry) ;
		 if($qry)		
		 {			
		 if(!file_exists("groups/".$group_name."/".$product_app_name))	
		 {	
		 mkdir("groups/".$group_name."/".$product_app_name);
		 echo "1";		
		 }
		 else	
		 {
		 echo "2";
		 }		
		 }	
		 else
		 {	
		 echo "Product already exists in the group, Rename the Product or Select other Group Name";
		 }
		 */
		 if(isset($_REQUEST['edit']))
		 {
			$id=$_REQUEST['id'];
			$value1=mysql_fetch_array(mysql_query("select img,group_id from products where id='$id'"));
			$old_url=$value1['img'];
		     $gid=$value1['group_id'];
			  $group_name=$obj->show_group_name($gid);
			$product_app_name=$_REQUEST['product_app_name'];
            $product_symbol = $_REQUEST['product_symbol'];
            
			$image_name = date('YmdHis');
	
			$new_url="groups/$group_name/$image_name.jpg";	
			
			$desc=$_REQUEST['desc'];
			$excel_file_name=$_REQUEST['product_xl_name'];
			$qry="UPDATE `products` SET `app_friendly_name`='$product_app_name',`description`='$desc',`excel_file_name`='$excel_file_name',img='$new_url',symbol='$product_symbol' WHERE `id` ='$id'";
			$qry2=mysql_query($qry) or die(mysql_error());
					if($qry2)
					{			
							$error=$_FILES['productimg']['error'];
							if($error==0)
							{	
							$tmp=$_FILES['productimg']['tmp_name'];
							if(file_exists($new_url))
								{
								unlink($new_url);
								}
							move_uploaded_file($tmp,$new_url);
							}	  
							else
							{
							rename($old_url,$new_url);
							}
					
					die("Updated Successfully");
					
					}	
			 else
			 {
			 echo "Couldn't update ! Try another Product or group name!";
			 }
		 }			
		 
		 ?>