<?php

/*
Our "config.inc.php" file connects to database every time we include or require
it within a php script.  Since we want this script to add a new user to our db,
we will be talking with our database, and therefore,
let's require the connection to happen:
*/
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

//if posted data is not empty
if (empty($_POST) || empty($_GET)) {
    //If the username or password is empty when the user submits
    //the form, the page will die.
    //Using die isn't a very good practice, you may want to look into
    //displaying an error message within the form instead.  
    //We could also do front-end form validation from within our Android App,
    //but it is good to have a have the back-end code do a double check.
    if (empty($_POST['email'])  && empty($_GET['email'])) {
        
   $auto_username="";     
        // Create some data that will be the JSON response 
        $response["success"] = 0;
        $response["message"] = "Please enter a valid email address and a password.";
        
        //die will kill the page and not execute any code below, it will also
        //display the parameter... in this case the JSON data our Android
        //app will parse
        die(json_encode($response));
    }
    
    //if the page hasn't died, we will check with our database to see if there is
    //already a user with the username specificed in the form.  ":user" is just
    //a blank variable that we will change before we execute the query.  We
    //do it this way to increase security, and defend against sql injections
    $query        = " SELECT 1 FROM signup WHERE email = :email";
    //now lets update what :user should be
    $email = $_GET['email'];
    if(!isset($email)){
        $email = $_POST['email'];
    }
    $query_params = array(
        ':email' => $email
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
    if ($row) {
        // For testing, you could use a die and message. 
        //die("This username is already in use");
        
        //You could comment out the above die and use this one:
        $response["success"] = 0;
        $response["message"] = "I'm sorry, this email is already in use";
        die(json_encode($response));
    }
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
    
    $count = $_GET['count'];
    if(!isset($count)){
        $count = $_POST['count'];
    }
    
    $mobile = $_GET['mobile'];
    if(!isset($mobile)){
        $mobile = $_POST['mobile'];
    }
    //Again, we need to update our tokens with the actual data:
    $query_params = array(
        ':pass' => $auto_pass,
        ':user' => $email,
		':name' => $name,
       	':coun' => $count,
		':mob'  => $mobile,
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
    
    //If we have made it this far without dying, we have successfully added
    //a new user to our database.  We could do a few things here, such as 
    //redirect to the login page.  Instead we are going to echo out some
    //json data that will be read by the Android application, which will login
    //the user (or redirect to a different activity, I'm not sure yet..)
    //$response["success"] = 1;
    //$response["message"] = "Username Successfully Created!";
    //echo json_encode($response);
    
    //for a php webservice you could do a simple redirect and die.
    //header("Location: login.php"); 
    //die("Redirecting to login.php");
	$to=$_POST['email'];
	$subject="TradeMate Login Details!";
	

$txt="Dear subscriber,

Welcome to Trade Mate !
 
Thank you for registering with us . Please find below your login details. 
You will be able to access our predictions across a wide range of markets, check out our best trading opportunities, including our trade entry and exist suggestions.

Username: ".$_POST['email']."
Password: $auto_pass



Sincerely,
Trade Mate Master";




	$headers = "From: info@tradersallied.com" . "\r\n" .
			"CC: info@tradersallied.com";
	
	if (mail($to,$subject,$txt,$headers)){
	$response["success"] = 1;
	$response["auto_pass"] = '"'.$auto_pass.'"';
    $response["message"] = "Account created successfully! Your username and password is sent to your registered email";
    die(json_encode($response));
											}
else{
	
$response["success"] = 0;
    $response["message"] = "Unable to register , Enter a valid e-mail or try a little bit later!";
    die(json_encode($response));
	}
	
    
    
} else {
?>
	<h1>Register</h1> 
	<form action="" method="post"> 
	    email:<br /> 
	    <input type="text" name="email" value="" /> 
	    <br />name:<br /> 
	    <input type="text" name="name" value="" /> 
	   <br /> 
	    Password:<br /> 
	    <input type="password" name="password" value="" /> 
		
		
		
	    <br /><br /> 
	    <input type="submit" value="Register New User" /> 
	</form>
	<?php
}

?>
