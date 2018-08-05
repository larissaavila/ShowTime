<?php if(session_status()!=PHP_SESSION_ACTIVE)
		session_start();
?>
<?php
	require_once "../Usuario.php";
	if(isset($_SESSION['login'])){
		$usuario = new Usuario();
		$usuario->login($_SESSION['login']);
	}
	else{
		Header('Location: index.php');
	}
?>
<?php
	if(isset($_POST['A']) && !empty($_POST['A']))
		$associados = $usuario->buscarAssociado($_POST['A']);
?>
<?php require_once 'inc/headerUser.php';?>
<div class="container">
	<div class="row">
		<h2>Buscar artistas parecidos</h2>
	</div>
	<div class="row">
		<form action="buscaAssociado.php" method="post">
		  <!-- area de campos do form -->
		  <hr />
		  <div class="row">
		  	<div class="form-group col-md-3">
			    <input type="text" class="form-control" name="A" placeholder="Informe o nome do artista">
			</div>
			<div class="form-group cold-md-3">
		      <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
		    </div>
		  </div>
		</form>

		<table class="table table-hover">
			<thead>
				<tr>
					<th>Parecidos</th>
				</tr>
			</thead>
			<tbody>
			<?php if(isset($associados) && $associados!=null):?>
				<?php foreach($associados as $artista):?>
					<tr>
						<td><?php echo $artista['B'];?></td>
					</tr>
				<?php endforeach;?>
			<?php else:?>
				<tr>
					<td>Nenhum registro encontrado.</td>
				</tr>
			<?php endif; ?>
		</tbody>
		</table>