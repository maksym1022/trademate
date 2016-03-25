<?php

//load and connect to MySQL database stuff
require("config.inc.php");

if (!empty($_POST) || !empty($_GET)) {
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
    $username = $_GET['username'];
    if(!isset($username)){
        $username = $_POST['username'];
    }
    $query_params = array(
        ':username' => $username
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
    if ($row) {
        //if we encrypted the password, we would unencrypt it here, but in our case we just
        //compare the two passwords
        $password = $_GET['password'];
        if(!isset($password)){
            $password = $_POST['password'];
        }
        if ($password != $row['password'])
		{
		
            $response["success"] = 0;
			$response["message"] = "Password Mismatch!! Try Again!";
			die(json_encode($response));
    	}
		else
		{
		$status=$row['status'];
		$response['status']=$status;
			
		if ($status=="0") 
			{
           		$response['success']=1;
			$response["message"] = "Login successful with Trial account! ";
			die(json_encode($response));
    		}
    else if ($status=="1") 
			{
			$response['success']=0;
           $response["message"] = "Trial Period Expired! Subscribe our plan to continue!";
			die(json_encode($response));
    		}
    
	else if ($status=="2") 
			{
			$response['success']=1;
           $response["message"] = "Login Successful!";
			die(json_encode($response));
    		}
    else  
			{
			$response['success']=0;
           $response["message"] = "Account Blocked! Contact us for further details!";
			die(json_encode($response));
    		}
    
	
	}
	}
    else
	{
			$response["success"] = 0;
			$response["message"] = "Invalid Credentials!! Enter valid username and Password!";
			die(json_encode($response));
    	
	
	}
    // If the user logged in successfully, then we send them to the private members-only page 
    // Otherwise, we display a login failed message and show the login form again 
    }
 else {
?>
		<h1>Login</h1> 
		<form action="login.php" method="post"> 
		    Username:<br /> 
		    <input type="text" name="username" placeholder="username" /> 
		    <br /><br /> 
		    Password:<br /> 
		    <input type="password" name="password" placeholder="password" value="" /> 
		    <br /><br /> 
		    <input type="submit" value="Login" /> 
		</form> 
		<a href="register.php">Register</a>
	<?php
}

?> 
