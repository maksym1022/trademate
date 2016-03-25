<?php
ob_start();
session_start();
?>

<!DOCTYPE html>
<html>
<head>
<?php 
include("include/class.php");
$obj=new admin;
$obj->conn();
?>
<?php

if(isset($_POST['submit']))
{
	$username=$_POST['username'];
	$password=$_POST['password'];
	$value=mysql_query("select * from admin where username='$username' and password='$password'");
	$count=mysql_num_rows($value);
	$rec=mysql_fetch_array($value);

	if($count==1)
	{	
		$_SESSION['a_id']=$rec['id'];
        $_SESSION['user'] = "admin";
		echo "<script>window.location.href='dashboard.php';</script>";
	}
	else{
        $value = mysql_query("select * from company_profile where manusername='$username' and manuserpw = '$password'");
        $count = mysql_num_rows($value);
        $rec = mysql_fetch_array($value);
        
        if($count == 1) {
            $_SESSION['a_id'] = $rec['id'];
            $_SESSION['user'] = "manuser";
            echo "<script>window.location.href='dashboard.php';</script>";
        }
        else {
            echo"<script>document.getElementById('login-alert').style.display='block';</script>";
        }
	}
}
?>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Admin Panel</title>
<link rel="stylesheet" href="css/style.default.css" type="text/css" />
<link rel="stylesheet" href="css/style.shinyblue.css" type="text/css" />

<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/jquery-migrate-1.1.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.9.2.min.js"></script>
<script type="text/javascript" src="js/modernizr.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('#login').submit(function(){
            var u = jQuery('#username').val();
            var p = jQuery('#password').val();
            if(u == '' && p == '') {
                jQuery('.login-alert').fadeIn();
                return false;
            }
        });
    });
	
</script>
<style>


/*** LOGIN PAGE ***/
*{margin:0;padding:0;}
.loginpanel { position:relative ;margin:150px auto;width:300px;text-align:center;}
.loginpanelinner { position: absolute; background:rgba(23,23,23,.5);box-shadow:5px 5px 5px #000; padding:10px 30px 30px 30px }
.loginpanelinner .logo { text-align: center; padding: 20px 0; }

.inputwrapper input { border: 0; padding: 10px; background: #fff; width: 250px; }
.inputwrapper input:active, .inputwrapper input:focus { background: #fff; border: 0; }
.inputwrapper button {
		  display: block; border: 1px solid #0c57a3; padding: 10px; background: #0972dd; width: 100%;
		  color: #fff; text-transform: uppercase; }
.inputwrapper button:focus, .inputwrapper button:active, .inputwrapper button:hover { background: #1e82e8; }
.inputwrapper label {
		  display: inline-block; margin-top: 10px; color: rgba(255,255,255,0.8); font-size: 11px; vertical-align: middle; }
.inputwrapper label input { width: auto; margin: -3px 5px 0 0; vertical-align: middle; }
.inputwrapper .remember { padding: 0; background: none; }

.login-alert { display: none; }
.login-alert .alert { font-size: 11px; text-align: center; padding: 5px 0; border: 0; }

.loginfooter {
		  font-size: 11px; color: rgba(255,255,255,0.5); position: absolute; position: fixed; bottom: 0; left: 0;
		  width: 100%; text-align: center; font-family: arial, sans-serif !important; padding: 5px 0; }
.loginCaption{
color:#fff; font-size:24px;padding-bottom:15px;
}
		  </style>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>



<body class="loginpage"  >


<div class="loginpanel">
    <div class="loginpanelinner"  >
        <h1 class='loginCaption'>Trademate Admin Panel</h1>
        <form id="login" action="" method="post" />
            <div class="inputwrapper login-alert" id='login-alert'>
                <div class="alert alert-error" >Invalid username or password</div>
            </div>
            <div class="inputwrapper animate1 bounceIn">
                <input type="text" name="username" id="username" placeholder="Enter any username" />
            </div>
            <div class="inputwrapper animate2 bounceIn">
                <input type="password" name="password" id="password" placeholder="Enter any password" />
            </div>
            <div class="inputwrapper animate3 bounceIn">
                <button name="submit" >Sign In</button>
            </div>
          
        </form>
    </div><!--loginpanelinner-->
	  
</div><!--loginpanel-->


<?php

?>
</body>
</html>
