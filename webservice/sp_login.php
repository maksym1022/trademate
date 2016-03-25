<?php

//load and connect to MySQL database stuff
require("config.inc.php");

function add_days($date,$days)
{
	$date=explode(" ",$date);
	$date=$date[0];
	$date1=explode("-",$date);
	$year=$date1[0];
	$month=$date1[1];
	$day=$date1[2];
	$eday=0;
	$emonth=0;
	$eyear=0;
	$days_in_month=cal_days_in_month(CAL_GREGORIAN,$month,$day);
	if(($month!=12)||($month==12 && $day<=24))
	{
		if($day<=($days_in_month-$days))
		{
			$eday=$day+$days;
			$emonth=$month;
			$eyear=$year;
		}
		else
		{

			$eyear=$year;
			$emonth=$month+1;
			$eday=$day+$days-$days_in_month;
		}
	}
	else
	{

		$eyear=$year+1;
		$emonth=1;
		$eday=$day+$days-$days_in_month;
	}
	if($emonth<10)
	{
		$emonth="0".$emonth;

	}
	if($eday<10)
	{
		$eday="0".$eday;

	}


	$edate="$eyear-$emonth-$eday";
	return $edate;
}

function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

if (empty($_POST) || empty($_GET)) {
	if (empty($_POST['email']) && empty($_GET['email'])) {
        
   		$response["success"] = 0;
        $response["message"] = "Please enter a valid email address.";
        
        //die will kill the page and not execute any code below, it will also
        //display the parameter... in this case the JSON data our Android
        //app will parse
        die(json_encode($response));
    }
    
    //gets user's info based off of a username.
    $query = " 
            SELECT 
                id, 
                username, 
                password,status
            FROM  signup
            WHERE 
                username = :username 
        ";
    $email = $_GET['email'];
    if(!isset($email)){
        $email = $_POST['email'];
    }
    $query_params = array(
                          ':username' => $email
    );
    
    try {
        $stmt   = $db->prepare($query);
        $result = $stmt->execute($query_params);
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
    
    //fetching all the rows from the query
    $row = $stmt->fetch();
    if ($row) {//the user is registered. now checking account status.
        $status=$row['status'];
		$response['status']=$status;
		
			
		if ($status=="0") {
           	$response['success']=1;
			$response["message"] = "Login successful with Trial account! ";
			die(json_encode($response));
    	} else if ($status=="1") {
			$response['success']=0;
           	$response["message"] = "Trial Period Expired! Subscribe our plan to continue!";
			die(json_encode($response));
    	} else if ($status=="2") {
			$response['success']=1;
           	$response["message"] = "Login Successful!";
			die(json_encode($response));
    	} else {
			$response['success']=0;
           	$response["message"] = "Account Blocked! Contact us for further details!";
			die(json_encode($response));
    	}
    
	} else {
        date_default_timezone_set('UTC');
		$current_time=date('Y-m-d H:i:s');
		$expiring_on=add_days($current_time,14);
    	//If we have made it here without dying, then we are in the clear to 
    	//create a new user.  Let's setup our new query to create a user.  
    	//Again, to protect against sql injects, user tokens such as :user and :pass
    	$query = "INSERT INTO  signup ( username, password,name,country,mobile,email,expiring_on) VALUES ( :user, :pass,:name,:coun,:mob,:email,:expiring_on) ";
    	$auto_pass=generateRandomString(4);
        
        $name = $_GET['name'];
        if(!isset($name)){
            $name = $_POST['name'];
        }
        
    	//Again, we need to update our tokens with the actual data:
    	$query_params = array(
        ':pass' => $auto_pass,
        ':user' => $email,
		':name' => $name,
       	':coun' => '',
		':mob' => '',
       ':email' => $email,
	   ':expiring_on' => $expiring_on
    	);
    
    	//time to run our query, and create the user
    	try {
       		$stmt   = $db->prepare($query);
        	$result = $stmt->execute($query_params);
    	}
    	catch (PDOException $ex) {
        	// For testing, you could use a die and message. 
        	//die("Failed to run query: " . $ex->getMessage());
        
        	//or just use this use this one:
        	$response["success"] = 0;
		
        	$response["message"] = "Database Error2. Please Try Again!";
       	 	die(json_encode($response));
    	}
	
		$response["success"] = 1;
		$response["message"] = "Account Registered successfully!";
    	die(json_encode($response));
		
    }
    
} else {//the given email isn't registered in the system. Register automatically.
	$response["success"] = 0;
	$response["message"] = "Invalid Credentials!!";
	die(json_encode($response));
	
}
    
?> 
