<?php

/*
Our "config.inc.php" file connects to database every time we include or require
it within a php script.  Since we want this script to add a new user to our db,
we will be talking with our database, and therefore,
let's require the connection to happen:
*/
require("config.inc.php");


//if posted data is not empty
if (!empty($_POST)) {
    //If the username or password is empty when the user submits
    //the form, the page will die.
    //Using die isn't a very good practice, you may want to look into
    //displaying an error message within the form instead.  
    //We could also do front-end form validation from within our Android App,
    //but it is good to have a have the back-end code do a double check.
    if (empty($_POST['task']) ) {
        
   		$response["success"] = 0;
        $response["message"] = "Invalid Attempt.";
        
        //die will kill the page and not execute any code below, it will also
        //display the parameter... in this case the JSON data our Android
        //app will parse
        die(json_encode($response));
    }
    
    if($_POST['task'] != "get_app_data") {
    	$response["success"] = 0;
        $response["message"] = "Invalid Attempt.";
        
        //die will kill the page and not execute any code below, it will also
        //display the parameter... in this case the JSON data our Android
        //app will parse
        die(json_encode($response));
    }
    $query = " SELECT uploaded_at FROM app_images where title='splash'";
    
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
        $splash_date = $row['uploaded_at'];
        
    }
    
    $query = " SELECT pageDesc FROM pages where pageId=1";
    
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
        $disclaimer = $row['pageDesc'];
        
    }
    
    $response["success"] = 1;
    $response["splash_date"] = $splash_date;
    $response["disclaimer_text"] = $disclaimer;
    
    die(json_encode($response));
    
	
    
    
} 

?>
