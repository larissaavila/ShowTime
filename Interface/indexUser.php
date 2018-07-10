<?php require_once 'inc/headerUser.php';?>

<?php
	if(session_status()!=PHP_SESSION_ACTIVE)
          session_start();
	if(isset($_SESSION['login'])){
		require_once 'top.php';
	}
	else{
		header("Location: index.php");
	}
	?>