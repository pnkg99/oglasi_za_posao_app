<?php


session_start();

require_once("../db.php");

if(isset($_POST)) {
	$message = mysqli_real_escape_string($conn, $_POST['description']);

	$sql = "INSERT INTO reply_mailbox (id_mailbox, id_user, usertype, message) VALUES ('$_POST[id_mail]', '$_SESSION[id_company]', 'poslodavac', '$message')";

	if($conn->query($sql) == TRUE) {
		header("Location: pogledaj-sanduce.php?id_mail=".$_POST['id_mail']);
		exit();
	} else {
		echo $conn->error;
	}
} else {
	header("Location: sanduce.php");
	exit();
}