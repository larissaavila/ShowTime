<?php

require_once "database.php";
require_once "sparql.php";

function lerUsuario($caminho, $login, $nome){
	$procura = find('usuario', $login);
	if($procura!=null){
		echo "Usuário já cadastrado";
	}
	else{
		$string = file_get_contents($caminho);
		$json = json_decode($string, true);
		//echo '<pre>' . print_r($json, true) . '</pre>'; //Interessante para ver o formato do JSON
		$dados['Login'] = $login;
		$dados['Nome'] = $nome;

		save('usuario', $dados);
		unset($dados);
		for($i=0;$i<10;$i++){
			$name = $json['items'][$i]['name'];
			$procura = find('gosta', $name, 1);
			if($procura==null){
				foreach($json['items'][$i]['genres'] as $genero){
					$generos[] = $genero;
				}
				if(isset($generos)){
					insereArtista($json['items'][$i]['name'], $generos);
				}
				else{
					insereArtista($json['items'][$i]['name'], null);
				}
				unset($generos);
			}
			$dados['Login'] = $login;
			$dados['Nome'] = $json['items'][$i]['name'];
			save('gosta', $dados);
		}
	}

};

function insereArtista($nome, $genres){
    if(existeRecurso($nome)){
    	$generos = achaGeneros($nome);
	    echo "achei generos";
	    $locais = achaLocal($nome);
	    echo "achei local";
	    $ano = achaAno($nome);
	    echo "aachei ano";
	    $associados = achaAssociados($nome);
	    echo "achei associados";
	    //$parecidos = achaParecidosGenero($aux);
    }
    $procura = find('artista', $nome);
	if($procura!=null){
	    if(isset($ano)){
	    	$dados['anoInicio'] = $ano;
	    	update('artista', $nome, $dados);
	    	unset($dados);	
	    }
	}
	else{
		$dados['Nome'] = $nome;
		if(isset($ano))
	    	$dados['anoInicio'] = $ano;
		save('artista', $dados);
		unset($dados);
	}
    $dados['Nome'] = $nome;
    if(isset($genres)){
    	foreach($genres as $genre){
    		$dados['Genero'] = $genre;
    		save('possuigenero', $dados); //Salva generos do Spotify
    	}
    }
    unset($dados);
    $dados['Nome'] = $nome;
    if(isset($generos)){
    	foreach($generos as $genero){
    		$dados['Genero'] = $genero;
    		save('possuigenero', $dados); //Salva generos da DBPedia
    	}
    }    
    unset($dados);
    $dados['Nome'] = $nome;
    if(isset($locais)){
    	foreach($locais as $local){
    		$dados['Local'] = $local;
    		save('possuilocal', $dados);
    	}
    }
    unset($dados);
    if(isset($associados)){
    	foreach($associados as $associado){
    		$procura = find('artista', $associado);
    		if($procura==null){
    			$dados['Nome'] = $associado;
    			save('artista', $dados);
    			unset($dados);
    		}
    		$dados['A'] = $nome;
    		$dados['B'] = $associado;
    		save('associado', $dados);
    		unset($dados);
    	}
    }   	    
};

function insereEvento($nome, $local, $data, $descricao, $artista){
    $procura = find('artista', $artista);
	if($procura==null){
	    insereArtista($artista, null);
	}
	$dados['Nome'] = $nome;
	$dados['Local'] = $local;
	$dados['Data'] = $data;
	$dados['Descricao'] = $descricao;
	$dados['Artista'] = $artista;

	save('evento', $dados);
};

if(!empty($_POST['nome']) && !empty($_POST['local']) && !empty($_POST['data']) && !empty($_POST['descricao']) && !empty($_POST['artista'])){
	insereEvento($_POST['nome'], $_POST['local'], $_POST['data'], $_POST['descricao'], $_POST['artista']);
}
else{?>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<form method="post" action="">
	<label>Nome</label> <input type="text" name="nome"> <br>
	<label>Local</label> <input type="text" name="local"> <br>
	<label>Data</label> <input type="date" name="data"> <br>
	<label>Descrição</label> <input type="text" name="descricao"> <br>
	<label>Artista</label> <input type="text" name="artista"> <br>
	<input type="submit">
	</form>

<?php }

?>