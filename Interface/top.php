<?php if(session_status()!=PHP_SESSION_ACTIVE)
		session_start();
?>

<?php require_once 'inc/headerUser.php';?>

<?php
	if(isset($_SESSION['login'])){
		$usuario = new Usuario();
		$usuario->login($_SESSION['login']);
		$top = $usuario->getTop();
	}
	else{
		Header('Location: index.php');
	}
?>

<div class="container">
	<div class="row">
		<h2>Seu top 10 Artistas</h2>
	</div>
	<div class="row">
<?php $i=0;?>
<?php foreach($top as $artista) : ?>
<?php if($i<5) :?>
	<div class="col-md-2">
        <div class="thumbnail">
        	<img src="<?php echo $artista->getImage();?>" alt="Imagem Responsiva">
            <div class="right-caption">
              <p><?php echo $artista->getNome();?></p>
            </div>
        </div>
    </div>
    <?php $i++;?>
<?php else : ?>
	<?php $i=0;?>
	</div>
	<div class="row">
		<div class="col-md-2">
        <div class="thumbnail">
        	<img src="<?php echo $artista->getImage();?>" alt="Imagem Responsiva">
            <div class="right-caption">
              <p><?php echo $artista->getNome();?></p>
            </div>
        </div>
    </div>
<?php endif ?>
<?php endforeach ?>
	</div>
	</div>