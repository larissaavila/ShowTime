<?php

    require_once '..\Usuario.php';

	if(isset($_POST['login']) && !empty($_POST['login'])){

		$usuario = new Usuario();

		if($usuario->login($_POST['login'])!=null){

			$_SESSION['login'] = $_POST['login'];

			header("Location: indexUser.php");

		}

		else{

			$_SESSION['message'] = "Login não encontrado";

			$_SESSION['type'] = "danger";

		}}?>

<?php require_once 'inc/header.php';?>

<?php require_once 'entrar.php';?>