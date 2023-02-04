<?php

//To Handle Session Variables on This Page
session_start();

if(empty($_SESSION['id_user'])) {
  header("Location: ../index.php");
  exit();
}

//Including Database Connection From db.php file to avoid rewriting in all files
require_once("../db.php");

//if user Actually clicked update profile button
if(isset($_POST)) {

	//Escape Special Characters
	$firstname = mysqli_real_escape_string($conn, $_POST['fname']);
	$lastname = mysqli_real_escape_string($conn, $_POST['lname']);
	$adresa = mysqli_real_escape_string($conn, $_POST['adresa']);
	$grad = mysqli_real_escape_string($conn, $_POST['grad']);
	$kontakt = mysqli_real_escape_string($conn, $_POST['kontakt']);
	$kvalifikacija = mysqli_real_escape_string($conn, $_POST['kvalifikacija']);
	$vestine = mysqli_real_escape_string($conn, $_POST['vestine']);
	$biografija = mysqli_real_escape_string($conn, $_POST['biografija']);

	$uploadOk = true;

	if(isset($_FILES)) {

		$folder_dir = "../uploads/rezime/";

		$base = basename($_FILES['rezime']['name']); 

		$resumeFileType = pathinfo($base, PATHINFO_EXTENSION); 

		$file = uniqid() . "." . $resumeFileType;   

		$filename = $folder_dir .$file;  

		if(file_exists($_FILES['rezime']['tmp_name'])) { 
			
			if($resumeFileType == "pdf")  {

				if($_FILES['rezime']['size'] < 500000) { // File size is less than 5MB

					move_uploaded_file($_FILES["rezime"]["tmp_name"], $filename);

				} else {
					$_SESSION['uploadError'] = "Wrong Size. Max Size Allowed : 5MB";
					header("Location: uredi-profil.php");
					exit();
				}
			} else {
				$_SESSION['uploadError'] = "Wrong Format. Only PDF Allowed";
				header("Location: uredi-profil.php");
				exit();
			}
		}
	} else {
		$uploadOk = false;
	}

	

	//Update User Details Query
	$sql = "UPDATE kandidati SET firstname='$firstname', lastname='$lastname', adresa='$adresa', grad='$grad', kontakt='$kontakt', kvalifikacija='$kvalifikacija', vestine='$vestine', biografija='$biografija'";

	if($uploadOk == true) {
		$sql .= ", rezime='$file'";
	}

	$sql .= " WHERE id_user='$_SESSION[id_user]'";

	if($conn->query($sql) === TRUE) {
		$_SESSION['name'] = $firstname.' '.$lastname;
		//If data Updated successfully then redirect to dashboard
		header("Location: index.php");
		exit();
	} else {
		echo "Error ". $sql . "<br>" . $conn->error;
	}
	//Close database connection. Not compulsory but good practice.
	$conn->close();

} else {
	//redirect them back to dashboard page if they didn't click update button
	header("Location: uredi-profil.php");
	exit();
}