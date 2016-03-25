<?php
 include('include/header.php');
   include('include/left.php');
   include('include/class.php');
   ?>
<html>
<head>
<script type="text/javascript">
function updateinfo()
{
	var name=document.getElementById('name').value;
	var email=document.getElementById('email').value;
	var address=document.getElementById('address').value;
	var phone=document.getElementById('phone').value;
    var manusername = document.getElementById('manusername').value;
    var manuserpw = document.getElementById('manuserpw').value;
	
	if(name!="" && email!="" && address!="" && phone!="" && manusername!="" && manuserpw!="")
	{
	    var ajx;
	    if(window.XMLHttpRequest)
	    {
		    ajx=new XMLHttpRequest();
	    }
	    else
	    {
		    ajx = new ActiveXObject("Microsoft.XMLHTTP");
	    }
	    ajx.onreadystatechange = function()
	    {
		    if(ajx.readyState==4 && ajx.status==200)
		    {
			    alert(ajx.responseText);
			    window.location.href='manageprofile.php';
			    //document.getElementById('result').innerHTML=ajx.responseText;
		    }
	    }
		ajx.open("POST", "updateProfile.php?updateprofile&name="+name+"&email="+email+"&address="+address+"&phone="+phone+"&manusername="+manusername+"&manuserpw="+manuserpw, true);
		ajx.send();
    }
}
</script>


</head>

<body>

<div class="mainwrapper">
    
   <?php
  	$name;$email;$address;$phone;
	$current_timestamp=date('Y-m-d H:i:s');
	
	$obj=new admin;
	$obj->conn();
	$qry="select * from company_profile";
	$qr=mysql_query($qry);
	if($x=mysql_fetch_array($qr))
	{
		$id=$x['id'];
		$name=$x['name'];
		$email=$x['email'];
		$address=$x['address'];
		$phone=$x['phone'];
        $manusername = $x['manusername'];
        $manuserpw = $x['manuserpw'];
	}
if(isset($_REQUEST['logo1']))
{
	$tmpname=$_FILES['logo']['tmp_name'];
	if(file_exists("app_img/logo.png"))
	{
	unlink("app_img/logo.png");
	}
	if(move_uploaded_file($tmpname,"app_img/logo.png"))
	{
	$qry=mysql_query("update app_images set uploaded_at='$current_timestamp' where title='logo'")or die(mysql_error());
	if($qry)
	{
	
	echo"<script>alert('Logo Image Changed Succesfully');
	</script>";
	}
	else
	{
	echo"<script>alert('Couldn't change logo image! Try Again!');
	</script>";
	
	}
	
	}
	
	
	
}   
if(isset($_REQUEST['splash1']))
{
	$tmpname=$_FILES['splash']['tmp_name'];
	if(file_exists("app_img/splash.jpg"))
	{
	unlink("app_img/splash.jpg");
	}
	
	
	
	if(move_uploaded_file($tmpname,"app_img/splash.jpg"))
	{
	$qry=mysql_query("update app_images set uploaded_at='$current_timestamp' where title='splash'") or die(mysql_error());
	if($qry)
	{
	
	echo"<script>alert('Splash Image Changed Succesfully');
	window.location.href='manageprofile.php';</script>";
	}
	else
	{
	echo"<script>alert('Couldn't change Splash image! Try Again!');
	window.location.href='manageprofile.php';</script>";
	
	}
	
	}
}   



   
   ?>
   
   
    <div class="rightpanel">
       <ul class="breadcrumbs">
            <li><a href="dashboard.php"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
            <li><a href="dashboard.php">Dashboard</a> <span class="separator"></span></li>
            <li>Company's Profile</li>
        </ul>
        
        <div class="pageheader">
           
            <div class="pagetitle">
                <h1>Manage Company Profile</h1>
            </div>
        </div><!--pageheader-->
        
        <div class="maincontent">
            <div class="maincontentinner">
              <div class='tabs'>
        
        	<div class='tab'> 
            	<input type="radio" id='viewPages' name='tab' checked>
                <label for='viewPages' onclick='hide_pop()'>View Profile</label>
                <div class='content' id='view_pages'>
                 <?php 
					 $obj->view_profile();
					 ?>
                </div>
        	</div>
            <div class='tab'> 
            	<input type="radio" id='editTab' name='tab'>
                <label for='editTab' id='editCreate'>Edit Profile</label>
                 <div class='content' id='editPage'>
                 
                 </div>
                  <div class='content'>  
                 <div id="wiz1step1" class="formwiz">
                    
                        <p>
                            <label>Company's Name</label>
                            <span class="field"><input type="text" name="name" id='name' class="input-large" value="<?php echo $name?>" /></span>
                        </p>
                        
                        <p>
                            <label>Email</label>
                            <span class="field"><input type="email" name="email" id='email'  class="input-large" value="<?php echo $email?>" /></span>
                        </p>
                        <p>
                            <label>Address</label>
                            <span class="field"><textarea id='address'><?php echo $address?></textarea></span>
                        </p>
                        <p>
                            <label>Contact No.</label>
                            <span class="field"><input type="text" name="phone" id='phone' class="input-large" value="<?php echo $phone?>" /></span>
                        </p>
                        <p>
                            <label>ManUsername</label>
                            <span class="field"><input type="text" name="manusername" id='manusername'  class="input-large" value="<?php echo $manusername?>" /></span>
                        </p>
                        <p>
                            <label>ManUserPassword</label>
                            <span class="field"><input type="password" name="manuserpw" id='manuserpw'  class="input-large" value="<?php echo $manuserpw?>" /></span>
                        </p>
                        
                        
                       	<p class="stdformbutton">
                           <input type="button" onClick="updateinfo()" value="Update" class="btn btn-primary" style="margin-top:10px;" title="Update Info">
                        </p>
                    
                
                <p>
                            <form action="" method="post" enctype="multipart/form-data">
                            <span class="field"><input type="file" name="logo" id='logo' class="input-large"  /></span><input type="submit" name='logo1' value="Update Logo Pic" class="btn btn-primary" style="margin-top:10px;" title="Update Info"></form><br>
							<?php
							
							echo"Last Modified at:". $obj->show_img_time('logo');
							?>
                            
                            
                            
                            
                            
                        </p>
                
                <p>
                            <form action="" method="post" enctype="multipart/form-data">
                            <span class="field"><input type="file" name="splash" id='splash' class="input-large"  /></span><input type="submit"  name='splash1' value="Update Splash Screen" class="btn btn-primary" style="margin-top:10px;" title="Update Info"></form><br>
							<?php
							
							echo"Last Modified at:". $obj->show_img_time('splash');
							?>
                            
                        </p>
                
                </div>
                </div>
                
                
            </div><!--maincontentinner-->
        </div><!--maincontent-->
        
    </div><!--rightpanel-->
    
</div><!--mainwrapper-->

</body>
</html>
