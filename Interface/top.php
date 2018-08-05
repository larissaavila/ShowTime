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

<link href="css/modal-rec.css" rel="stylesheet">

<div class="container">

		<h2>Seu top 10 Artistas</h2>
		<hr/>

	<div class="row">

<?php $i=0;?>

<?php foreach($top as $artista) : ?>

<?php if($i<5) :?>

	<div class="col-md-2">

        <div class="thumbnail">
        	<a data-toggle="modal" href="#<?php echo str_replace(str_split(" :'"), "", $artista->getNome());?>">

        	<img src="<?php echo $artista->getImage();?>" alt="Imagem Responsiva">
        </a>

        </div>

    </div>

     <!-- Modal -->
  <div class="modal fade" id="<?php echo str_replace(str_split(" :'"), "", $artista->getNome());?>" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><b><?php echo $artista->getNome();?></b></h4>
        </div>
        <div class="modal-body">
        	<div class="row">
        		<div class="cold-md-12">
        	<center><img src="<?php echo $artista->getImage();?>" class="img-fluid"></center>
        </div>
    </div>
        </div>
        <div class="modal-footer">
        	<center>
          <?php if($artista->getGeneros()!=null):?>

              			<p><?php echo "<b>Gêneros: </b>", $artista->getGeneros();?></p>

              		<?php endif?>
              	</center>
        </div>
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
        	<a data-toggle="modal" href="#<?php echo str_replace(str_split(" :'"), "", $artista->getNome());?>">

        	<img src="<?php echo $artista->getImage();?>" alt="Imagem Responsiva">
        </a>

        </div>

    </div>

     <!-- Modal -->
  <div class="modal fade" id="<?php echo str_replace(str_split(" :'"), "", $artista->getNome());?>" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><b><?php echo $artista->getNome();?></b></h4>
        </div>
        <div class="modal-body">
        	<div class="row">
        		<div class="cold-md-12">
        	<center><img src="<?php echo $artista->getImage();?>" class="img-fluid"></center>
        </div>
    </div>
        </div>
        <div class="modal-footer">
        	<center>
          <?php if($artista->getGeneros()!=null):?>

              			<p><?php echo "<b>Gêneros: </b>", $artista->getGeneros();?></p>

              		<?php endif?>
              	</center>
        </div>
      </div>
      
    </div>
  </div>

<?php endif ?>

<?php endforeach ?>

	</div>

	</div>
	<?php require_once "inc/footer.php";?>