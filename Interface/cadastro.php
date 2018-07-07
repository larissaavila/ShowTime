<?php require_once 'inc/header.php';?>

<link href="css/signup.css" rel="stylesheet">

<div class="container">
	<form>
		<div class="form-group">
			<label class="lb-md" for="login">Login</label>
			<input type="text" class="form-control" name="login" placeholder="Seu user do Spotify">
		</div>
		<div class="form-group">
			<label class="lb-md" for="nome">Nome</label>
			<input type="text" class="form-control" name="nome" placeholder="Seu nome">
		</div>
		<div class="form-group">
			<input type="file" class="form-control-file" name="arquivo" aria-describedby="arquivoAjuda">
			<small id="arquivoAjuda" class="form-text text-muted">O arquivo JSON do Spotify contendo seus top artistas</small>
		</div>
		<div class="form-group">
			<button class="btn btn-lg btn-primary btn-block" type="submit">Cadastrar-se</button>
		</div>
	</form>
</div>

<?php require_once 'inc/footer.php';?>

