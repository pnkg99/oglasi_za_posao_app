<?php

//To Handle Session Variables on This Page
session_start();

//Including Database Connection From db.php file to avoid rewriting in all files
require_once("db.php");

//If user Actually clicked login button 
if(isset($_POST)) {

	//Escape Special Characters in String
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$password = mysqli_real_escape_string($conn, $_POST['password']);

	//Encrypt Password
	$password = base64_encode(strrev(md5($password)));

	//sql query to check poslodavac login
	$sql = "SELECT id_company, imefirme, email, active FROM poslodavac WHERE email='$email' AND password='$password'";
	$result = $conn->query($sql);

	//if poslodavac table has this this login details
	if($result->num_rows > 0) {
		//output data
		while($row = $result->fetch_assoc()) {

			if($row['active'] == '2') {
				$_SESSION['companyLoginError'] = "Your Account Is Still Pending Approval.";
				header("Location: login-poslodavac.php");
				exit();
			} else if($row['active'] == '0') {
				$_SESSION['companyLoginError'] = "Your Account Is Rejected. Please Contact For More Info.";
				header("Location: login-poslodavac.php");
				exit();
			} else if($row['active'] == '1') {
				// active 1 means admin has approved account.
				//Set some session variables for easy reference
				$_SESSION['name'] = $row['imefirme'];
				$_SESSION['id_company'] = $row['id_company'];

				//Redirect them to poslodavac dashboard once logged in successfully
				header("Location: poslodavac/index.php");
				exit();
			} else if($row['active'] == '3') {
				$_SESSION['companyLoginError'] = "Vas Nalog je Ugasen. Kontaktirajte admina za Ponovno vracanje naloga.";
				header("Location: login-poslodavac.php");
				exit();
			}
		}
 	} else {
 		//if no matching record found in user table then redirect them back to login page
 		$_SESSION['loginError'] = $conn->error;
 		header("Location: login-poslodavac.php");
		exit();
 	}

 	//Close database connection. Not compulsory but good practice.
 	$conn->close();

} else {
	//redirect them back to login page if they didn't click login button
	header("Location: login-poslodavac.php");
	exit();
}