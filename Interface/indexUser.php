<?php require_once 'inc/headerUser.php';?>

<?php
	session_start();
	if(isset($_SESSION['login'])){
		require_once 'top.php';
	}
	else{
		header("Location: index.php");
	}
	?>