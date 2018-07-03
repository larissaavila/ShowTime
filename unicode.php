<?php

	function getUnicode($char){
		$codigos = [

		"á" => "\u00E1",
		"é" => "\u00E9",
		"í" => "\u00ED",
		"ó" => "\u00F3",
		"ú" => "\u00FA",
		"ã" => "\u00E3",
		"ö" => "\u00F6",
		"ü" => "\u00FC",
		"â" => "\u00E2",
		"ê" => "\u00EA",
		"ç" => "\u00E7",
		];
		return $codigos[$char];
	};

	function insereUnicode($nome){
		if(strpos($nome, "ö")){
			$nome = str_replace("ö", getUnicode("ö"), $nome);
		}
		if(strpos($nome, "ü")){
			$nome = str_replace("ü", getUnicode("ü"), $nome);
		}
		if(strpos($nome, "â")){
			$nome = str_replace("â", getUnicode("â"), $nome);
		}
		if(strpos($nome, "á")){
			$nome = str_replace("á", getUnicode("á"), $nome);
		}
		if(strpos($nome, "ó")){
			$nome = str_replace("ó", getUnicode("ó"), $nome);
		}
		if(strpos($nome, "ã")){
			$nome = str_replace("ã", getUnicode("ã"), $nome);
		}
		return $nome;
	}

	function retiraAcentos($nome){
		if(strpos($nome, "ö")){
			$nome = str_replace("ö", "o", $nome);
		}
		if(strpos($nome, "ü")){
			$nome = str_replace("ü", "u", $nome);
		}
		if(strpos($nome, "â")){
			$nome = str_replace("â", "a", $nome);
		}
		if(strpos($nome, "á")){
			$nome = str_replace("á", "a", $nome);
		}
		if(strpos($nome, "ó")){
			$nome = str_replace("ó", "o", $nome);
		}
		if(strpos($nome, "ã")){
			$nome = str_replace("ã", "a", $nome);
		}
		return $nome;
	}

	/*print_r($codigos);
	$string = "Mötley Crüe";
	$array = str_split($string);
	foreach ($array as $char)
		echo $char, "<br>";
	if(strpos($string, "ö")){
		$string = str_replace("ö", $codigos["ö"], $string);
		echo $string;
	}*/

?>