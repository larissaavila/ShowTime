<?php

require_once('sparqllib.php');
$db = sparql_connect('http://dbpedia.org/sparql/'); #Conecta com a DBpedia
	
	function achaArtista($nome){
		$nome = strtolower($nome); #Passa o nome do artista para letras minúsculas
		$lista = array();
        $query = "SELECT DISTINCT ?recurso WHERE{
                  {?recurso a dbo:Artist}
                      UNION
                  {?recurso a dbo:Band}
                      UNION
                  {?recurso a dbo:MusicalArtist} .
                  ?recurso foaf:name ?nome
                  FILTER(lcase(str(?nome)) = '$nome')}"; 
        $result = sparql_query($query);
        $fields = sparql_field_array($result);
        while($row = sparql_fetch_array($result)){
        	foreach($fields as $field){
        		$lista[] = $row[$field];
        	}
        }
    return $lista;
	};

	function achaGeneros($recurso){
		$lista = array();
		$query = "SELECT DISTINCT ?genreName WHERE{
		          dbr:$recurso dbo:genre ?genero .
		          ?genero foaf:name ?genreName}";
		$result = sparql_query($query);
        $fields = sparql_field_array($result);
        while($row = sparql_fetch_array($result)){
        	foreach($fields as $field){
        		$lista[] = $row[$field];
        	}
        }
    return $lista;
	};

	function achaLocal($recurso){
		$lista = array();
		$query = "SELECT DISTINCT ?homeName WHERE{
		          {dbr:$recurso dbo:hometown ?hometown}
		              UNION
		          {dbr:$recurso dbo:birthPlace ?hometown} .
		          ?hometown foaf:name ?homeName}";
		$result = sparql_query($query);
		$fields = sparql_field_array($result);
		while($row = sparql_fetch_array($result)){
        	foreach($fields as $field){
        		$lista[] = $row[$field];
        	}
        }
    	return $lista;
	};

	function achaAno($recurso){
		$lista = array();
		$query = "SELECT DISTINCT ?year WHERE{
		         dbr:$recurso dbo:activeYearsStartYear ?year}";
		$result = sparql_query($query);
		$fields = sparql_field_array($result);
		while($row = sparql_fetch_array($result)){
        	foreach($fields as $field){
        		$lista[] = $row[$field];
        	}
        }
    	return $lista;

	};

	function achaParecidosGenero($recurso){
		$lista = array();
		$query = "SELECT DISTINCT ?parecidoNome WHERE{
		          dbr:$recurso dbo:genre ?genre .
		          
		          {dbr:$recurso dbo:hometown ?local}
		              UNION
		          {dbr:$recurso dbo:birthPlace ?local} .
		          
		          dbr:$recurso dbo:activeYearsStartYear ?ano .
		          
		          ?parecidoGenero dbo:genre ?genre

		          {?parecidoGenero dbo:hometown ?local}
		              UNION
		          {?parecidoGenero dbo:birthPlace ?local} .

		          ?parecidoGenero dbo:activeYearsStartYear ?anoParecido
		              FILTER(year(?anoParecido) >= (year(?ano)-5) && year(?anoParecido) <= (year(?ano)+5) && ?parecidoGenero != dbr:$recurso)
		          ?parecidoGenero foaf:name ?parecidoNome}";
		$result = sparql_query($query);
		$fields = sparql_field_array($result);
		while($row = sparql_fetch_array($result)){
        	foreach($fields as $field){
        		$lista[] = $row[$field];
        	}
        }
    	return array_unique($lista);

	}

	function achaAssociados($recurso){
		$lista = array();
		$query = "SELECT DISTINCT ?associadoNome ?associado2Nome WHERE{
		         dbr:$recurso dbo:genre ?genre .
		         
		         {dbr:$recurso dbo:associatedMusicalArtist ?associado}
		             UNION
		         {?associado dbo:associatedMusicalArtist dbr:$recurso}
		             UNION
		         {dbr:$recurso dbo:associatedBand ?associado}
		             UNION
		         {?associado dbo:associatedBand dbr:$recurso} .
		         
		         {?associado dbo:associatedMusicalArtist ?associado2}
		             UNION
		         {?associado2 dbo:associatedMusicalArtist ?associado}
		             UNION
		         {?associado dbo:associatedBand ?associado2}
		             UNION
		         {?associado2 dbo:associatedBand ?associado} .

		         ?associado dbo:genre ?genreAssoc .
		         ?associado2 dbo:genre ?genreAssoc2 .

		         FILTER(?genreAssoc = ?genre && ?genreAssoc2 = ?genre && ?associado != dbr:$recurso && ?associado2 != dbr:$recurso)
		         ?associado foaf:name ?associadoNome .
		         ?associado2 foaf:name ?associado2Nome}";
		$result = sparql_query($query);
		$fields = sparql_field_array($result);
		while($row = sparql_fetch_array($result)){
        	foreach($fields as $field){
        		$lista[] = $row[$field];
        	}
        }
    	return array_unique($lista);
	}

    $artistas = achaArtista("Rita Lee");
    foreach($artistas as $artista){
    	$aux = substr($artista, 28); #Retira o http://dbpedia.org/resource/
    	$generos = achaGeneros($aux);
    	$locais = achaLocal($aux);
    	$anos = achaAno($aux);
    	$associados = achaAssociados($aux);
    	$parecidos = achaParecidosGenero($aux);
    }
    foreach($generos as $genero){
    	echo $genero, "<br>";
    }
    foreach($locais as $local){
    	echo $local, "<br>";
    }
    foreach($anos as $ano){
    	echo $ano, "<br>";
    }
    foreach($associados as $associado){
    	echo $associado, "<br>";
    }
    foreach($parecidos as $parecido){
    	echo $parecido, "<br>";
    }

?>