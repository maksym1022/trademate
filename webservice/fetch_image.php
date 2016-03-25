<?php

//load and connect to MySQL database stuff
require("config.inc.php");
include("custom_functions.php");



if (!empty($_POST)) {
$logo_time=0;
$splash_time=0;
$splash_path=$web_url."/app_img/splash.jpg";
$logo_path=$web_url."/app_img/logo.png";


    //gets user's info based off of a username.
    $query = " 
            SELECT 
                title, 
                uploaded_at
            FROM  app_images
                    ";
    
    
    try {
        $stmt   = $db->prepare($query);
        $result = $stmt->execute();
    }
    catch (PDOException $ex) {
        // For testing, you could use a die and message. 
        //die("Failed to run query: " . $ex->getMessage());
        
        //or just use this use this one to product JSON data:
        $response["success"] = 0;
        $response["message"] = "Database Error1. Please Try Again!";
        die(json_encode($response));
        
    }
    
    //This will be the variable to determine whether or not the user's information is correct.
    //we initialize it as false.
    $validated_info = false;
    
    //fetching all the rows from the query
    //$row = $stmt->fetch();
    while($row=$stmt->fetch()) {
        //if we encrypted the password, we would unencrypt it here, but in our case we just
        //compare the two passwords
    if($row['title']=='logo' )    
	{
	$logo_time=$row['uploaded_at'];
	}
	else if($row['title']=='splash' )    
	{
	$splash_time=$row['uploaded_at'];
	}
	}
	
    // If the user logged in successfully, then we send them to the private members-only page 
    // Otherwise, we display a login failed message and show the login form again 
	
	if($logo_time==$_POST['logo_time'] && $splash_time==$_POST['splash_time'])
	{
			$response["success"] = 1;
			die(json_encode($response));
	}
	else if(($logo_time==$_POST['logo_time']) && ($splash_time!=$_POST['splash_time']))
	{
			$response["success"] = 2;
			$response["splash_time"] = $splash_time;
			$response["splash_path"] = $splash_path;
			
			die(json_encode($response));
	}
	else if(($logo_time!=$_POST['logo_time']) && ($splash_time==$_POST['splash_time']))
	{
			$response["success"] = 3;
			$response["logo_time"] = $logo_time;
			$response["logo_path"] = $logo_path;
			die(json_encode($response));
	}
	else
	{
	$response["success"] = 0;
	$response["splash_time"] =$splash_time;
	$response["splash_path"] = $splash_path;
	$response["logo_time"] = $logo_time;
	$response["logo_path"] = $logo_path;
			
	die(json_encode($response));
	}
    }
 else {
?>
		<h1>Login</h1> 
		<form action="" method="post"> 
		    Username:<br /> 
		    <input type="text" name="splash_time" placeholder="splash" /> 
		    <br /><br /> 
		    Password:<br /> 
		    <input type="text" name="logo_time" placeholder="logo_time"  /> 
		    <br /><br /> 
		    <input type="submit" value="Login" /> 
		</form> 
		<a href="register.php">Register</a>
	<?php
}

?> 
