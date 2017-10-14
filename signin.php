<?php
	//Initiate the session, save path outside directory folder in a safe location that can't be accessed easily.
	ini_set("session.save_path", "/home/unn_w13020720/sessionData");
	//Start session, tracking activity and storing it in the session directory.
	session_start(); 

	require_once('functions.php');
	include 'data_conn.php';
	
	//Submit the form, with name logon.
	if(isset($_POST['logon'])){
		//Verify that session isn't already active by calling signed_in value from session data, whether it's set and if it's true. Echo Already logged in if this is the case.
		if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true){
			echo "<p>You're already signed in</p>";
		//If signed_in returns false:
		} else {
		//Check if isset, else make null.
			//Uses a test mechanism, checking if the test variable is equal to $_POST[var], otherwise return null.
			$username = filter_has_var(INPUT_POST, 'username') ? $_POST['username']: null;
			$pass = filter_has_var(INPUT_POST, 'password') ? $_POST['password']: null;

		//trim white space from the variables.
			$username = trim($username);
			$pass = trim($pass);

		//no quotes or encode tags
			$username=filter_var($username, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			$pass=filter_var($pass, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		//Special Chars filterer.
			$username= filter_var($username, FILTER_SANITIZE_SPECIAL_CHARS);
			$pass = filter_var($pass, FILTER_SANITIZE_SPECIAL_CHARS);

		//Initialize error array. Ideally calling an array is done using "[]" only, and is considerred the proper way, however it didn't work, so I reverted to outdated PHP array function.
			$errors = array();

		//check if variables are null or empty. if this is the case, push an error message into the array.
			if(!empty($username) || $username == ''){
				$errors = '<p>Please Enter a username</p>';
			}
			elseif(!empty($pass) || $pass == ''){
				$errors = '<p>Please Enter a password</p>';
			}

		//check for errors. If any are returned, echo the errors.
			if(is_array($errors)){
				echo "<ul>";
				foreach($errors as $key => $value){
					echo "<li>$value </li>";
				}
				echo "</ul>";
			}
		//Select password from the user database where username is equal to submited username. This is to verify whether the account exists, and if 0 results are returned, an error should occur.
			else {
				$sql = "SELECT passwordHash FROM nmc_users WHERE username = ?";

				//use prepared statements. Is good to prevent SQL injections. connects to the database initially, preparing the query for submission by adding it to a variable $stmt.
				//"or die(mysqli_error($conn));" used for error handling to pinpoint a potential error in the process.
				$stmt = mysqli_prepare($conn, $sql) or die(mysqli_error($conn));
				//submits one parameter of type string from the prepared statement $stmt.
				mysqli_stmt_bind_param($stmt, "s", $username) or die(mysqli_error($conn));
				//execute the prepared statement.
				mysqli_stmt_execute($stmt) or die(mysqli_error($conn));
				//retrieves the results from the prepared statement and prepares the selected value in a variable
				mysqli_stmt_bind_result($stmt, $passHash) or die(mysqli_error($conn));

				//If a result has been returned.
				if (mysqli_stmt_fetch($stmt)){
					//verify the password using a method that checks the submitted password to its hashed version. If it returns true...
					if(password_verify($pass, $passHash)){
						echo "<p>Password Correct</p>\n";
						//Start session by identifying session variables. One boolean, and one $username variable to print the session user in another location

						$_SESSION['username'] = $username;
						$_SESSION['signed_in'] = true;
						//link to the location the user last came from when submitting the form.
						header("location: {$_SERVER['HTTP_REFERER']}");

					} else {
						//otherwise die error message
						echo "<p>Password Incorrect</p>\n";
					}
				//if no results were found, die the error message stating that the username didn't exist.
				} else {
					echo "<p>Sorry we don't seem to have that username.</p>";
				}
			//close the prepared statement to prevent further use of the submitted data.
			mysqli_stmt_close($stmt);
			//close the connection to the database
			mysqli_close($conn);
			}
		}
	}	
	
?>