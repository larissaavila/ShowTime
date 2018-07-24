<?php require_once '..\Usuario.php'?>

<?php if(session_status()!=PHP_SESSION_ACTIVE)

          session_start(); ?>

<?php 

	if(isset($_POST['login']) && !empty($_POST['login'])){

		$usuario = new Usuario();

		if($usuario->login($_POST['login'])!=null){

			$_SESSION['login'] = $_POST['login'];

			header("Location: indexUser.php");

		}

		else{

			$_SESSION['message'] = "Login não encontrado";

			$_SESSION['type'] = "danger";

		}



	}?>

<?php require_once 'index.php'; ?>



<link href="css/signin.css" rel="stylesheet">



<div class="container">

	<div class="row">



<?php if (!empty($_SESSION['message'])) : ?>

		<div class="alert alert-<?php echo $_SESSION['type']; ?> alert-dismissible col-md-2 col-md-offset-5" role="alert" align="center">

			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

			<?php echo $_SESSION['message']; ?>

		</div>

	<?php clear_messages(); ?>

<?php endif; ?>



	<form class="form-signin" method="post">

		<label for="login" class="sr-only">Login</label>

		<input type="text" id="login" name="login" class="form-control" placeholder="Login" required="" autofocus="">

		<br>

		<button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>

	</form>

</div>



<?php require_once 'inc/footer.php';?>