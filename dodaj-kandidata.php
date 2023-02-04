<?php

//To Handle Session Variables on This Page
session_start();

//Including Database Connection From db.php file to avoid rewriting in all files
require_once("db.php");

//If user Actually clicked register button
if(isset($_POST)) {

	//Escape Special Characters In String First
	$firstname = mysqli_real_escape_string($conn, $_POST['fname']);
	$lastname = mysqli_real_escape_string($conn, $_POST['lname']);
	$adresa = mysqli_real_escape_string($conn, $_POST['adresa']);
	$grad = mysqli_real_escape_string($conn, $_POST['grad']);

	$kontakt = mysqli_real_escape_string($conn, $_POST['kontakt']);
	$kvalifikacija = mysqli_real_escape_string($conn, $_POST['kvalifikacija']);

	$datum_rodjenja = mysqli_real_escape_string($conn, $_POST['datum_rodjenja']);
	$godina = mysqli_real_escape_string($conn, $_POST['godina']);
	$zvanje = mysqli_real_escape_string($conn, $_POST['zvanje']);
	$biografija = mysqli_real_escape_string($conn, $_POST['biografija']);
	$vestine = mysqli_real_escape_string($conn, $_POST['vestine']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$password = mysqli_real_escape_string($conn, $_POST['password']);
	//Encrypt Password
	$password = base64_encode(strrev(md5($password)));

	//sql query to check if email already exists or not
	$sql = "SELECT email FROM kandidati WHERE email='$email'";
	$result = $conn->query($sql);

	//if email not found then we can insert new data
	if($result->num_rows == 0) {

			//This variable is used to catch errors doing upload process. False means there is some error and we need to notify that user.
	$uploadOk = true;

	//Folder where you want to save your rezime. THIS FOLDER MUST BE CREATED BEFORE TRYING
	$folder_dir = "uploads/rezime/";

	//Getting Basename of file. So if your file location is Documents/New Folder/myResume.pdf then base name will return myResume.pdf
	$base = basename($_FILES['rezime']['name']); 

	//This will get us extension of your file. So myResume.pdf will return pdf. If it was rezime.doc then this will return doc.
	$resumeFileType = pathinfo($base, PATHINFO_EXTENSION); 

	//Setting a random non repeatable file name. Uniqid will create a unique name based on current timestamp. We are using this because no two files can be of same name as it will overwrite.
	$file = uniqid() . "." . $resumeFileType;   

	//This is where your files will be saved so in this case it will be uploads/rezime/newfilename
	$filename = $folder_dir .$file;  

	//We check if file is saved to our temp location or not.
	if(file_exists($_FILES['rezime']['tmp_name'])) { 

		//Next we need to check if file type is of our allowed extention or not. I have only allowed pdf. You can allow doc, jpg etc. 
		if($resumeFileType == "pdf")  {

			//Next we need to check file size with our limit size. I have set the limit size to 5MB. Note if you set higher than 2MB then you must change your php.ini configuration and change upload_max_filesize and restart your server
			if($_FILES['rezime']['size'] < 500000) { // File size is less than 5MB

				//If all above condition are met then copy file from server temp location to uploads folder.
				move_uploaded_file($_FILES["rezime"]["tmp_name"], $filename);

			} else {
				//Size Error
				$_SESSION['uploadError'] = "Wrong Size. Max Size Allowed : 5MB";
				$uploadOk = false;
			}
		} else {
			//Format Error
			$_SESSION['uploadError'] = "Wrong Format. Only PDF Allowed";
			$uploadOk = false;
		}
	} else {
			//File not copied to temp location error.
			$_SESSION['uploadError'] = "Something Went Wrong. File Not Uploaded. Try Again.";
			$uploadOk = false;
		}

	//If there is any error then redirect back.
	if($uploadOk == false) {
		header("Location: registruj-kandidata.php");
		exit();
	}

		$hash = md5(uniqid());


		//sql new registration insert query
		$sql = "INSERT INTO kandidati(firstname, lastname, email, password, adresa, grad, kontakt, kvalifikacija, datum_rodjenja, godina, zvanje, rezime, hash, biografija, vestine) VALUES ('$firstname', '$lastname', '$email', '$password', '$adresa', '$grad', '$kontakt', '$kvalifikacija', '$datum_rodjenja', '$godina', '$zvanje', '$file', '$hash', '$biografija', '$vestine')";

		if($conn->query($sql)===TRUE) {


			// //If data inserted successfully then Set some session variables for easy reference and redirect to login
			$_SESSION['registerCompleted'] = true;
			header("Location: login-kandidat.php");
			exit();
		} else {
			//If data failed to insert then show that error. Note: This condition should not come unless we as a developer make mistake or someone tries to hack their way in and mess up :D
			echo "Error " . $sql . "<br>" . $conn->error;
		}
	} else {
		//if email found in database then show email already exists error.
		$_SESSION['registerError'] = true;
		header("Location: registruj-kandidata.php");
		exit();
	}

	//Close database connection. Not compulsory but good practice.
	$conn->close();

} else {
	//redirect them back to register page if they didn't click register button
	header("Location: registruj-kandidata.php");
	exit();
}