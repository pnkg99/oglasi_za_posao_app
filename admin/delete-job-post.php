<?php

session_start();

if(empty($_SESSION['id_admin'])) {
  header("Location: index.php");
  exit();
}

require_once("../db.php");

if(isset($_GET)) {

	$sql = "DELETE FROM oglasi_za_posao WHERE id_jobpost='$_GET[id]'";
	if($conn->query($sql)) {
		$sql1 = "DELETE FROM prijava_za_oglas WHERE id_jobpost='$_GET[id]'";
		if($conn->query($sql1)) {
		}
		header("Location: aktivni-poslovi.php");
		exit();
	} else {
		echo "Error";
	}
}