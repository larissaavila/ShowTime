<?php

require_once "database.php";
require_once "sparql.php";

function insereArtista($nome){
	$artistas = achaArtista($nome);
	foreach($artistas as $artista){
    	$aux = substr($artista, 28); #Retira o http://dbpedia.org/resource/
    	$generos = achaGeneros($aux);
    	$locais = achaLocal($aux);
    	$ano = achaAno($aux);
    	$associados = achaAssociados($aux);
    	//$parecidos = achaParecidosGenero($aux);
    }
    $vetor['Nome'] = $nome;
    $vetor['anoInicio'] = $ano;
    save('artista', $vetor);
    unset($vetor);
    $vetor['Nome'] = $nome;
    foreach($generos as $genero){
    	$vetor['Genero'] = $genero;
    	save('possuigenero', $vetor);
    }
    unset($vetor);
    $vetor['Nome'] = $nome;
    foreach($locais as $local){
    	$vetor['Local'] = $local;
    	save('possuilocal', $vetor);
    }
    unset($vetor);
    foreach($associados as $associado){
    	$vetor['Nome'] = $associado;
    	save('artista', $vetor);
    	unset($vetor);
    	$vetor['A'] = $nome;
    	$vetor['B'] = $associado;
    	save('associado', $vetor);
    	unset($vetor);
    }

};

insereArtista('Caetano Veloso');


?>