<?php
require 'Artista.php';

	$conn = open_database();
	$string = file_get_contents('JSON Spotify/larissa_longterm.json');
    $json = json_decode($string, true);
    //echo '<pre>' . print_r($json, true) . '</pre>'; //Interessante para ver o formato do JSON
    for($i=0;$i<10;$i++){
    	$name = $json['items'][$i]['name'];
    	$artista = new Artista($name);
		$artista->setImage($conn, $json['items'][$i]['images'][1]['url']);
	}

?>