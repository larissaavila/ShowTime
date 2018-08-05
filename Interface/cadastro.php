<?php if(session_status()!=PHP_SESSION_ACTIVE)

          session_start(); ?>

<?php require_once 'inc/header.php';?>

<?php require_once '../Usuario.php';?>



<link href="css/signup.css?version=12" rel="stylesheet">



<?php



	if(!empty($_POST['login']) && !empty($_POST['nome'])){

		if (is_uploaded_file($_FILES['arquivo']['tmp_name'])){

			$usuario = new Usuario();

			$result = $usuario->cadastrarUsuario($_FILES['arquivo']['tmp_name'],$_POST['login'], $_POST['nome']);

			if($result == null){

				$_SESSION['message'] = "Usuário já cadastrado";

				$_SESSION['type'] = "danger";

			}

			else{

				$_SESSION['message'] = "Sucesso";

				$_SESSION['type'] = "success";

			}

		}

	}

?>

<div class="container">

	<div class="row">

<h2>Cadastre-se!</h2>
<hr/>

<?php if (!empty($_SESSION['message'])) : ?>

		<div class="alert alert-<?php echo $_SESSION['type']; ?> alert-dismissible col-md-1 col-md-offset-5" role="alert" align="center">

			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

			<?php echo $_SESSION['message']; ?>

		</div>

	<?php clear_messages(); ?>

<?php endif; ?>

	<form method="post" enctype="multipart/form-data">

		<div class="form-group">

			<label class="lb-md" for="login">Login</label>

			<input type="text" class="form-control" name="login" placeholder="Seu user do Spotify" required="" autofocus="">

		</div>

		<div class="form-group">

			<label class="lb-md" for="nome">Nome</label>

			<input type="text" class="form-control" name="nome" placeholder="Seu nome" required="">

		</div>

		<div class="form-group">

			<input type="file" class="form-control-file" name="arquivo" aria-describedby="arquivoAjuda" required="">

			<small id="arquivoAjuda" class="form-text text-muted">O arquivo JSON do Spotify contendo seus top artistas</small>

		</div>

		<div class="form-group">

			<button class="btn btn-lg btn-primary btn-block" type="submit">Cadastrar-se</button>

		</div>

	</form>

</div>

</div>



<?php require_once 'inc/footer.php';?>



