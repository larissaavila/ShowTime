<?php if(session_status()!=PHP_SESSION_ACTIVE)

		session_start();

?>
<?php
	require_once "../Usuario.php";

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
<?php require_once 'inc/headerUser.php';?>
<link href="css/modal-rec.css" rel="stylesheet">


<div class="container">

    <?php if(isset($recomendacoes)):?>

		<h2>Suas recomendações de Shows</h2>
	<hr />

	<div class="row">

<?php $i=0;?>

<?php foreach($recomendacoes as $recomendacao) : ?>

<?php if($i<6) :?>

	<div class="col-md-2">

        <div class="thumbnail">
        	<a data-toggle="modal" href="#<?php echo str_replace(str_split(" :',"), "", $recomendacao['Evento']->getNome());?>">
        	<img src="<?php echo $recomendacao['Evento']->getImage();?>" alt="Imagem Responsiva">
        	</a>

        </div>
    </div>
        <!-- Modal -->
  <div class="modal fade" id="<?php echo str_replace(str_split(" :',"), "", $recomendacao['Evento']->getNome());?>" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><b><?php echo $recomendacao['Evento']->getNome();?></b></h4>
        </div>
        <div class="modal-body">
        	<div class="row">
        		<div class="cold-md-12">
        	<center><img src="<?php echo $recomendacao['Evento']->getImage();?>" class="img-fluid"></center>
        </div>
    </div>
        </div>
        <div class="modal-footer">
        	<center>
          <?php if(isset($recomendacao['Associado'])):?>

              			<p><?php echo "<b>Artista: </b>", $recomendacao['Associado'];?></p>

              			<p><?php echo "<b>Parecido com: </b>", $recomendacao['Artista']->getNome();?></p>

              		<?php else:?>

              			<p><?php echo "<b>Artista: </b>", $recomendacao['Artista']->getNome();?></p>

              		<?php endif?>

              		<p><?php echo "<b>Local: </b>", $recomendacao['Evento']->getLocal();?></p>
              		<p><?php echo "<b>Data: </b>", $recomendacao['Evento']->getData();?></p>
              	</center>
        </div>
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
        	<a data-toggle="modal" href="#<?php echo str_replace(str_split(" :',"), "", $recomendacao['Evento']->getNome());?>">
        	<img src="<?php echo $recomendacao['Evento']->getImage();?>" alt="Imagem Responsiva">
        	</a>

        </div>
    </div>
        <!-- Modal -->
  <div class="modal fade" id="<?php echo str_replace(str_split(" :',"), "", $recomendacao['Evento']->getNome());?>" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><b><?php echo $recomendacao['Evento']->getNome();?></b></h4>
        </div>
        <div class="modal-body">
        	<center><img src="<?php echo $recomendacao['Evento']->getImage();?>"></center>
        </div>
        <div class="modal-footer">
        	<center>
          <?php if(isset($recomendacao['Associado'])):?>

              			<p><?php echo "<b>Artista: </b>", $recomendacao['Associado'];?></p>

              			<p><?php echo "<b>Parecido com: </b>", $recomendacao['Artista']->getNome();?></p>

              		<?php else:?>

              			<p><?php echo "<b>Artista: </b>", $recomendacao['Artista']->getNome();?></p>

              		<?php endif?>

              		<p><?php echo "<b>Local: </b>", $recomendacao['Evento']->getLocal();?></p>
              		<p><?php echo "<b>Data: </b>", $recomendacao['Evento']->getData();?></p>
              	</center>
        </div>
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
	<?php require_once "inc/footer.php";?>