<?php
echo"hey";

//load and connect to MySQL database stuff
//require("config.inc.php");

if (isset($_POST)) {
        
if (empty($_POST['username']) || empty($_POST['password'])) || empty($_POST['npassword']))  {
        
        
        // Create some data that will be the JSON response 
        $response["success"] = 0;
        $response["message"] = "Please Enter Both a Username and Password.";
        
        //die will kill the page and not execute any code below, it will also
        //display the parameter... in this case the JSON data our Android
        //app will parse
        die(json_encode($response));
    }//if block ends
    //gets user's info based off of a username.
    $query = " 
            SELECT 
                id, 
                username, 
                password
            FROM users 
            WHERE 
                username = :username 
        ";
    
    $query_params = array(
        ':username' => $_POST['username']
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
    $validated_info = false;
    
    //fetching all the rows from the query
    $row = $stmt->fetch();
    if ($row) {
        //if we encrypted the password, we would unencrypt it here, but in our case we just
        //compare the two passwords
        if ($_POST['password'] === $row['password']) {
            $login_ok = true;
        }
    }
    
    // If the user logged in successfully, then we send them to the private members-only page 
    // Otherwise, we display a login failed message and show the login form again 
    if ($login_ok) {
        //$response["success"] = 1;
        //$response["message"] = "Login successful!";
        
		$query="update into users set password=:npass where username=:user";
		$query_params = array(
        ':user' => $_POST['username'],
		'npass'=>$_POST['npassword']
    );
		
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
    $response["message"] = "Password Updated Successfully!";
    echo json_encode($response);
    
		
		
		
		
		
    } else {
        $response["success"] = 0;
        $response["message"] = "Invalid Credentials!";
        die(json_encode($response));
    }
} else {
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
