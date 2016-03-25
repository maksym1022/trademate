<?php

/*
Our "config.inc.php" file connects to database every time we include or require
it within a php script.  Since we want this script to add a new user to our db,
we will be talking with our database, and therefore,
let's require the connection to happen:
*/
require("config.inc.php");

function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}


//if posted data is not empty
if (!empty($_POST) || !empty($_GET)) {
    //If the username or password is empty when the user submits
    //the form, the page will die.
    //Using die isn't a very good practice, you may want to look into
    //displaying an error message within the form instead.  
    //We could also do front-end form validation from within our Android App,
    //but it is good to have a have the back-end code do a double check.
    if (empty($_POST['username']) && empty($_GET['username']))  {
        
        
        // Create some data that will be the JSON response 
        $response["success"] = 0;
        $response["message"] = "Please Enter Your Username !!";
        
        //die will kill the page and not execute any code below, it will also
        //display the parameter... in this case the JSON data our Android
        //app will parse
        die(json_encode($response));
    }
    
    //if the page hasn't died, we will check with our database to see if there is
    //already a user with the username specificed in the form.  ":user" is just
    //a blank variable that we will change before we execute the query.  We
    //do it this way to increase security, and defend against sql injections
    $query        = " SELECT 1 FROM signup WHERE username= :user OR email= :email";
    //now lets update what :user should be
    
    $username = $_GET['username'];
    if(!isset($username)){
        $username = $_POST['username'];
    }
    $query_params = array(
       
        ':user' => $username,
        ':email' => $username
    );
    
    //Now let's make run the query:
    try {
        // These two statements run the query against your database table. 
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
    
    //fetch is an array of returned data.  If any data is returned,
    //we know that the username is already in use, so we murder our
    //page
    $row = $stmt->fetch();
    if (empty($row)) {
        // For testing, you could use a die and message. 
        //die("This username is already in use");
        
        //You could comment out the above die and use this one:
       $response["success"] = 0;
        $response["message"] = "Sorry, this  username is not present in our database";
       die(json_encode($response));
    }
    $newpassword=generateRandomString(4);
	
	
	
	
    //If we have made it here without dying, then we are in the clear to 
    //create a new user.  Let's setup our new query to create a user.  
    //Again, to protect against sql injects, user tokens such as :user and :pass
    $query = "UPDATE signup SET password= :pass WHERE username= :user ";
    
    //Again, we need to update our tokens with the actual data:
    $query_params = array(
        ':user' => $username,
        ':pass' => $newpassword);
    
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
    
    //If we have made it this far without dying, we have successfully added
    //a new user to our database.  We could do a few things here, such as 
    //redirect to the login page.  Instead we are going to echo out some
    //json data that will be read by the Android application, which will login
    //the user (or redirect to a different activity, I'm not sure yet..)
    $to=$username;
	$subject="TradeMate Password Reset!";
	$txt="Hello User! Your Password has been successfully updated to :".$newpassword." . ThankYou!";
	$txt="Dear Subscriber,

We hope we did not take a long time to get back to you with your login information.
It seems you have misplaced them or do not remember their details. Your login details are:

Username: ".$username."
Password:$newpassword

Regards,
Trade Mate Master
";
$headers = "From: info@tradersallied.com" . "\r\n" .
			"CC: info@tradersallied.com";
	if (mail($to,$subject,$txt,$headers)){
	$response["success"] = 1;
    $response["message"] = "Your password was reset. Your new password has been emailed to you.";
    echo json_encode($response);
						}
else{
	
$response["success"] = 0;
    $response["message"] = "Unable to send mail to $to , Enter Valid mail id or try after sometime!";
    echo json_encode($response);
	}
	
	
	
	
	
	
	
    
    //for a php webservice you could do a simple redirect and die.
    //header("Location: login.php"); 
    //die("Redirecting to login.php");
    
    
} else {
?>
	<h1>Register</h1> 
	<form action="" method="post"> 
	    Username:<br /> 
	    <input type="text" name="username" value="" /> 
	    <br /><br /> 
	    Password:<br /> 
	    <input type="password" name="password" value="" /> 
	    <br /><br /> 
	    <input type="submit" value="Register New User" /> 
	</form>
	<?php
}

?>
