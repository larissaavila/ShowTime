<?php session_start(); ?>
<?php require_once 'index.php'; ?>

<?php 
	if(isset($_POST['login']) && !empty($_POST['login'])){
		$usuario = new Usuario();
		if($usuario->login($_POST['login'])!=null){
			$_SESSION['login'] = $_POST['login'];
			header("Location: indexUser.php");
		}
		else{
			echo "não logou";
		}

	}
		
?>

<link href="css/signin.css" rel="stylesheet">

<div class="container">
	<form class="form-signin" method="post">
		<label for="login" class="sr-only">Login</label>
		<input type="text" id="login" name="login" class="form-control" placeholder="Login" required="" autofocus="">
		<br>
		<button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
	</form>
</div>

<?php require_once 'inc/footer.php';?>