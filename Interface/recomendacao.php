<?php if(session_status()!=PHP_SESSION_ACTIVE)
		session_start();
?>
<?php require_once 'inc/headerUser.php';?>
<?php
	if(isset($_SESSION['login'])){
		if(!isset($usuario)){
			$usuario = new Usuario();
			$usuario->login($_SESSION['login']);
		}
		if($usuario->getRecomendacoes()==null)
			$usuario->recomendar();
		
		$recomendacoes = $usuario->getRecomendacoes();
	}
	else{
		header("Location: index.php");
	}
?>

<div class="container">
    <?php if(isset($recomendacoes)):?>
	<div class="row">
		<h2>Suas recomendações de Shows</h2>
	</div>
	<div class="row">
<?php $i=0;?>
<?php foreach($recomendacoes as $recomendacao) : ?>
<?php if($i<5) :?>
	<div class="col-md-2">
        <div class="thumbnail">
        	<img src="<?php echo $recomendacao['Artista']->getImage();?>" alt="Imagem Responsiva">
            <div class="right-caption">
              <p><?php echo "Nome: ", $recomendacao['Evento']->getNome();?></p>
              <?php if(isset($recomendacao['Associado'])):?>
              <p><?php echo "Artista: ", $recomendacao['Associado'];?></p>
              <p><?php echo "Porque você gosta de: ", $recomendacao['Artista']->getNome();?></p>
              <?php else:?>
              <p><?php echo "Artista: ", $recomendacao['Artista']->getNome();?></p>
              <?php endif?>
              <p><?php echo "Local: ", $recomendacao['Evento']->getLocal();?></p>
              
            </div>
        </div>
    </div>
    <?php $i++;?>
<?php else : ?>
	<?php $i=1;?>
	</div>
	<div class="row">
		<div class="col-md-2">
        <div class="thumbnail">
        	<img src="<?php echo $recomendacao['Artista']->getImage();?>" alt="Imagem Responsiva">
            <div class="right-caption">
              <p><?php echo $recomendacao['Evento']->getNome();?></p>
            </div>
        </div>
    </div>
<?php endif ?>
<?php endforeach ?>
	</div>
	<?php else:?>
	<div class="row">
		<h2>Infelizmente ainda não possuímos nenhuma recomendaçao para você :(</h2>
	</div>
	<?php endif?>
	</div>