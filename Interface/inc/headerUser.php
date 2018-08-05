<?php require_once 'config.php'?>
<?php require_once '../Usuario.php';?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ShowTime</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!--<link href="css/style.css" rel="stylesheet">-->

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<div class="container-fluid">
        <nav class="navbar navbar-inverse"> 
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="<?php echo BASEURL; ?>Interface/indexUser.php">ShowTime</a>
                </div>
                <ul class="nav navbar-nav">
                    <li "active"> <a href="top.php">Top Artistas</a></li>
                    <li> <a href="recomendacao.php">Recomendação de Eventos</a></li>
                    <li> <a href="buscaAssociado.php">Buscar artistas parecidos</a></li>
                    <li> <a href="logout.php">Sair</a></li>
                </ul>
            </div>
        </nav>
    <div class="row">
        <div role="main">