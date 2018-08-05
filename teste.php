<?php

require_once "Banco de Dados/database.php";
require_once "vendor/autoload.php";
$conn = open_database();
$eventos = find($conn, 'evento');
$session = new SpotifyWebAPI\Session(
            'a8eb8437bd354f478f45f41487844e2a',
            'd1c3f1d5a5794dd3a00c0a7e84518e23'
        );
$session->requestCredentialsToken();
$accessToken = $session->getAccessToken();
$api = new SpotifyWebAPI\SpotifyWebAPI();
$api->setAccessToken($accessToken);
$options['limit']=1;

foreach($eventos as $evento){
	$artista = find($conn, 'artista', $evento['Artista']);
	if($artista[0]['Imagem']==null){
		$artistas = $api->search($artista[0]['Nome'], 'artist', $options);
		$teste = json_decode(json_encode($artistas), true);
		$dados['Imagem'] = $teste['artists']['items'][0]['images'][1]['url'];
        update($conn, 'artista', $artista[0]['Nome'], $dados);
	}
}

close_database($conn);

?>