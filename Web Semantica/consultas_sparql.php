<?php

require_once('sparqllib.php');
require_once('unicode.php');
$db = sparql_connect('http://dbpedia.org/sparql/'); #Conecta com a DBpedia

	function queryEspecial($nome){
		$contem = $nome;
		$contem = retiraAcentos($contem);
		$nome = mb_strtolower($nome, 'UTF-8');
		$nome = insereUnicode($nome);
		return "  ?recurso foaf:name ?nome .
                  ?nome bif:contains \"'$contem'\" .
                  FILTER(regex(lcase(str(?nome)), '^$nome$'))";
        
	}

	function existeRecurso($nome){
		$query = "SELECT ?recurso WHERE{";
		$query .= queryEspecial($nome);
		$query .= "}";
		$result = sparql_query($query);
		$fields = sparql_field_array($result);
        while($row = sparql_fetch_array($result)){
        	foreach($fields as $field){
        		$lista[] = $row[$field];
        	}
        }
        if(isset($lista))
        	return true;
        else
        	return false;
	}
	
	/*function achaArtista($nome){
		if(strpos($nome, " ")){
			$i = strpos($nome, " ");
			$contem = substr($nome, 0, $i);
		}
		else{
			$contem = $nome;
		}
		$nome = strtolower($nome); #Passa o nome do artista para letras minúsculas
		if(strpos($nome, "'")){
			$nome = str_replace("'", "\'", $nome);
		}
		$lista = array();
        $query = "SELECT DISTINCT ?recurso WHERE{
                  ?recurso foaf:name ?nome .
                  ?nome bif:contains '$contem' .
                  {?recurso a dbo:MusicalArtist}
                      UNION
                  {?recurso a dbo:Band}
                      UNION
                  {?recurso a dbo:Artist}
                      UNION
                  {?recurso a yago:WikicatFeministMusicians} .
                  FILTER(lcase(str(?nome)) = '$nome')}"; 
        $result = sparql_query($query);
        $row = sparql_fetch_array($result);
        return $row['recurso'];
	};*/

	function achaGeneros($recurso){
		$lista = array();
		$query = "SELECT DISTINCT ?genreName WHERE{";
		if(strpos($recurso, "'"))
			$recurso = str_replace("'", "\'", $recurso);
		$query .= queryEspecial($recurso);
		$query .= "?recurso dbo:genre ?genero .
		          ?genero foaf:name ?genreName}";
		echo $query, "<br>";
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
		$query = "SELECT DISTINCT ?homeName WHERE{";
		if(strpos($recurso, "'"))
			$recurso = str_replace("'", "\'", $recurso);
		$query .= queryEspecial($recurso);
		$query .= "{?recurso dbo:hometown ?hometown}
		                    UNION
		          	   {?recurso dbo:birthPlace ?hometown} .
		          	   ?hometown foaf:name ?homeName}";
		echo $query, "<br>";
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
		$query = "SELECT DISTINCT ?year WHERE{";
		if(strpos($recurso, "'"))
			$recurso = str_replace("'", "\'", $recurso);
		$query .= queryEspecial($recurso);
		$query .= "?recurso dbo:activeYearsStartYear ?year}";
		echo $query, "<br>";
		$result = sparql_query($query);
		$fields = sparql_field_array($result);
		while($row = sparql_fetch_array($result)){
        	foreach($fields as $field){
        		return $row[$field];
        	}
        }

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
		$query = "SELECT DISTINCT ?associadoNome ?associado2Nome WHERE{";
		if(strpos($recurso, "'"))
			$recurso = str_replace("'", "\'", $recurso);
		$query .= queryEspecial($recurso);
		$query .= "?recurso dbo:genre ?genre .
		         
		         {?recurso dbo:associatedMusicalArtist ?associado}
		             UNION
		         {?associado dbo:associatedMusicalArtist ?recurso}
		             UNION
		         {?recurso dbo:associatedBand ?associado}
		             UNION
		         {?associado dbo:associatedBand ?recurso} .
		         
		         {?associado dbo:associatedMusicalArtist ?associado2}
		             UNION
		         {?associado2 dbo:associatedMusicalArtist ?associado}
		             UNION
		         {?associado dbo:associatedBand ?associado2}
		             UNION
		         {?associado2 dbo:associatedBand ?associado} .

		         ?associado dbo:genre ?genreAssoc .
		         ?associado2 dbo:genre ?genreAssoc2 .

		         FILTER(?genreAssoc = ?genre && ?genreAssoc2 = ?genre && ?associado != ?recurso && ?associado2 != ?recurso)
		         ?associado foaf:name ?associadoNome .
		         ?associado2 foaf:name ?associado2Nome}";
		echo $query, "<br>";
		$result = sparql_query($query);
		$fields = sparql_field_array($result);
		while($row = sparql_fetch_array($result)){
        	foreach($fields as $field){
        		$lista[] = $row[$field];
        	}
        }

        $query = "SELECT DISTINCT ?parecidoNome WHERE{";
		$query .= queryEspecial($recurso);
		$query .= "?recurso dbo:genre ?genre .
		          
		          {?recurso dbo:hometown ?local}
		              UNION
		          {?recurso dbo:birthPlace ?local} .
		          
		          ?recurso dbo:activeYearsStartYear ?ano .
		          
		          ?parecidoGenero dbo:genre ?genre

		          {?parecidoGenero dbo:hometown ?local}
		              UNION
		          {?parecidoGenero dbo:birthPlace ?local} .

		          ?parecidoGenero dbo:activeYearsStartYear ?anoParecido
		              FILTER(year(?anoParecido) >= (year(?ano)-5) && year(?anoParecido) <= (year(?ano)+5) && ?parecidoGenero != ?recurso)
		          ?parecidoGenero foaf:name ?parecidoNome}";
		echo $query, "<br>";
		$result = sparql_query($query);
		$fields = sparql_field_array($result);
		while($row = sparql_fetch_array($result)){
        	foreach($fields as $field){
        		$lista[] = $row[$field];
        	}
        }
        
    	return array_unique($lista);
	};
?>