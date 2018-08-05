<?php if(session_status()!=PHP_SESSION_ACTIVE)
		session_start();
?>
<?php
	require_once "../Usuario.php";
	if(isset($_SESSION['login'])){
		$usuario = new Usuario();
		$usuario->login($_SESSION['login']);
		$top = $usuario->getTop();
	}
	else{
		Header('Location: index.php');
	}
?>
<?php require_once 'inc/headerUser.php';?>
<div class="container">
	<div class="row">
		<h2>Crie seu evento</h2>
		<hr/>
	</div>
	<div class="row">
		<?php if (!empty($_SESSION['message'])) : ?>
			<div class="alert alert-<?php echo $_SESSION['type']; ?> alert-dismissible col-md-1 col-md-offset-5" role="alert" align="center">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<?php echo $_SESSION['message']; ?>
			</div>
			<?php clear_messages(); ?>
		<?php endif; ?>
		
		<form method="post" enctype="multipart/form-data">
			<div class="form-group">
				<div class="row">
					<div class="col-md-4">
						<label class="lb-md" for="Nome">Nome</label>
						<input type="text" class="form-control" name="Nome" placeholder="Nome do evento" required="" autofocus="">
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-md-4">
						<label class="lb-md" for="Local">Local</label>
						<input type="text" class="form-control" name="Local" placeholder="Local do evento" required="" autofocus="">
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-md-4">
						<label class="lb-md" for="Data">Data</label>
						<input type="text" class="form-control" name="Data" placeholder="Data do evento" required="" autofocus="">
					</div>
				</div>
			</div>
		</form>


<?php require_once 'inc/footer.php';?>