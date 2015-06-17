<html>
<head>
	<title> Register | Elite </title>
	<meta charset='UTF-8'/>
	<link type="text/css" rel="stylesheet" href="stylesheet.css"/>
</head>
<body>
<?php
/* The constants used in this script page: 
	name of the database, username of the user accessing the database,
	password for the user, and the host type (here localhost)*/
	define("DB_NAME", "UserAccounts");
	define('DB_USER', 'root');
	define('DB_PASS', '');
	define('DB_HOST', 'localhost');

	//Check for the match of passwords entered
	//In addition to the client side check for security
	if($_POST['password'] != $_POST['repassword']){
		echo "<script>
				alert('Passwords do not match. Please make the correction.');
				window.history.go(-1);
			  </script>";
		die();
	}

	//store the user password, roll_no, email_id and first_name in local memory
	$userPassword = $_POST['password'];
	$userRollNum = $_POST['roll_no'];
	$userEmailID = $_POST['email_id'];
	$firstName = $_POST['first_name'];
	
	if(!filter_var($userEmailID, FILTER_VALIDATE_EMAIL)){
		echo "<script>
				alert('Email format is invalid.');
				window.history.go(-1);
				</script>";
		die();
	}

	/*$emailMessage =  " Dear $firstName,\n\tThank you for registering with us.\n\nRegards,\nElite Team.";
	$emailFrom = "From: noreply@localhost";

	if(!mail($userEmailID, "[No-Reply] Registeration Successful | Elite", $emailMessage, $emailFrom)){
		echo "<script>
				alert('Email is not valid. Please make the correction.');
				window.history.go(-1);
			  </script>";
		die();
	}*/

	//store the age user_name, last_name and gender similarly
	$age = $_POST['age'];
	$userName = $_POST['user_name'];
	$lastName = $_POST['last_name'];
	$gender = $_POST['gender'];

	//store the hashed version of the password; false indicates that returned hash is in hexadecimal
	$hashedPass = hash("sha1", $userPassword, false);
	//echo "hased the password\n";
	
	//store the roll number, department, graduation year and photograph resource
	$roll = $_POST['roll_no'];
	$department = $_POST['department'];
	$gradYear = $_POST['grad_year'];
	
	//link to mysql using the define() constants
	$linked = mysql_connect(DB_HOST, DB_USER, DB_PASS);
	//echo "tried database mysql\n";

	//if the mysql connection failed..
	if(!$linked){
		die("Sorry, couldn't connect to mysql, do you have a mysql server?: \n" . mysql_error());
	}

	//try connection to user db
	if(!mysql_select_db(DB_NAME, $linked)){
		die("Sorry, couldn't connect to user profile database: " . mysql_error());
	}
	
	
	//create a random uid for the registered user
	$result_array = mysql_query("SELECT user_id FROM ProfileInformation");
	$storedUids = array();
	while($row = mysql_fetch_assoc($result_array))
	{
		 $storedUids[] = $row['user_id'];
	}
	
	$userid = 0;
	do{
		$userid = rand(100000, 999999);
		$isUnique = true;
		for($i=0; $i<count($storedUids); $i++){
			if($storedUids[$i] == $userid){
				$isUnique = false;
				break;
			}
		}
	}while(!$isUnique);


	//create a storable copy of the picture
	$imageData = mysql_real_escape_string(file_get_contents($_FILES['profile_pic']['tmp_name']));
	$imageType = mysql_real_escape_string($_FILES['profile_pic']['type']);
	
	if(substring($imageType, 0, 5) == "image"){
		echo "Working..\n";
	}else{
		echo "<script>
			alert('The file uploaded is not an image. ');
			window.history.go(-1);
		</script>";
		die();
	}
	
	
	
	
	//query to store verified information in a new row of database
	$writeDataQuery = "INSERT INTO ProfileInformation 
				(user_id, roll_number, department, grad_year, photograph_image, user_name, first_name, last_name, email_id, age, gender, password_digest, registeration_date) 
	VALUES ('$userid', '$roll', '$department', '$gradYear', '$imageData', '$userName', '$firstName', '$lastName', '$userEmailID', '$age', '$gender', '$hashedPass', NOW());";

	//execute query
	if(!mysql_query($writeDataQuery)){
		die("Sorry, error while data write: " . mysql_error());
	}

	//commit the changes made to the database
	mysql_query("COMMIT");

	//echo successful registeration
	echo "<h4> Registered $userName successfully </h4></h4>";
	
	//close database connection
	mysql_close(); 

?>
</body>
</html>
