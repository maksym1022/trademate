<?php
   include('include/header.php');
   include('include/left.php');
   ?><?php
include("include/class.php");
$obj=new admin;
$obj->conn();
if(isset($_POST['save']))
{
	$oldpwd=$_POST['oldpwd'];
	$newpwd=$_POST['newpwd'];
	$cpwd=$_POST['cpwd'];
	$value=mysql_query("select * from admin where password='$oldpwd'");
	$count=mysql_num_rows($value);
	if(!$count<1)
	{
		if($newpwd == $cpwd and !empty($newpwd))
		{
		$rec=mysql_fetch_array($value);
		$id=$rec['id'];
		$resetpwd=mysql_query("update admin set password='$newpwd' where id='$id'");
		if($resetpwd)
		{
		echo "<script>alert('Password Changed !');
			window.location.href='dashboard.php';
		</script>";
		
			}
		}
		else{
			echo "<script>alert('Password Does Not Match');</script>";
			}
	}
	else{
		echo "<script>alert('Current Password Wrong !');</script>";
	}
}
?>
<!DOCTYPE html>
<html>
<body>
<div class="mainwrapper">
    
    <div class="rightpanel">
        
        <ul class="breadcrumbs">
            <li><a href="dashboard.html"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="dashboard.html">Dashboard</a> <span class="separator"></span></li>
            <li>Change Password</li>
        </ul>
        
        <div class="pageheader">
            
            <div class="pagetitle">
              <h1>  Change Password</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
            
            	<div id="wiz1step1" class="formwiz">
                    <form action='' method='post'>
                        <p>
                            <label>Current Password</label>
                            <span class="field"><input type="password" name="oldpwd" class="input-large" /></span>
                        </p>
                        
                         <p>
                            <label>New Password</label>
                            <span class="field"><input type="password" name="newpwd" class="input-large" /></span>
                        </p>
                        
                        <p>
                            <label>Retype Password</label>
                            <span class="field"><input type="password" name="cpwd" class="input-large" /></span>
                        </p>
                       	<p class="stdformbutton">
                           <input type="submit" name='save' value="Save" class="btn btn-primary" style="margin-top:10px;" title="Submit">
                        </p>
                    </form>
                </div><!--#wiz1step1-->
                
              
            
            </div><!--maincontentinner-->
        </div><!--maincontent-->
        
    </div><!--rightpanel-->
    
</div><!--mainwrapper-->
</body>
</html>
