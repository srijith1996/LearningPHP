<html>
<head>
	<title>create DB</title>
	<meta charset="UTF-8"/>
</head>
<body>
<?php

	define('DB_NAME', 'UserAccounts');
	define('DB_USER', 'root');
	define('DB_PASS', '');
	define('DB_HOST', 'localhost');

	$linked = mysql_connect(DB_HOST, DB_USER, DB_PASS);

	echo "connected\n";

	if(!$linked){
		die("Could not connect to mysql: " . mysql_error());
	}

	$db_selected = mysql_select_db(DB_NAME, $linked);

	if(!$db_selected){

		$database_sql = "CREATE DATABASE " . DB_NAME;

		if(!mysql_query($database_sql)){
			die("Database not created: " . mysql_error());
		}

		mysql_query("USE " . DB_NAME);

		echo "Connection to database successful\n";

		$table_sql	= "CREATE TABLE ProfileInformation (
						user_id INT(6) UNSIGNED UNIQUE PRIMARY KEY,
						roll_number INT(9) UNSIGNED UNIQUE NOT NULL,
						grad_year INT(4) UNSIGNED NOT NULL,
						department VARCHAR(25) NOT NULL,
						photograph_image BLOB,
						user_name VARCHAR(40) NOT NULL,
						first_name VARCHAR(30) NOT NULL,
						last_name VARCHAR(30),
						email_id VARCHAR(50) NOT NULL,
						age INT(3) UNSIGNED NOT NULL,
						gender ENUM('M', 'F') NOT NULL,
						password_digest VARCHAR(40) NOT NULL,
						registeration_date TIMESTAMP 
					)";

		if(!mysql_query($table_sql)){
			die("Table ProfileInformation could not be created: " . mysql_error());
		}

		echo "Table created successfully :)";
	}

	mysql_close();
?>
</body>
</html>
