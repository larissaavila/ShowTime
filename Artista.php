<?php

/**

 * Classe que irá lidar com métodos específicos do artista

 * @author Adson Duarte <airduarte@inf.ufpel.edu.br>

 * @author Larissa Araujo <ldaaraujo@inf.ufpel.edu.br>

 * @author Yuri Weisshahn <yrweisshahn@inf.ufpel.edu.br>

 * @version 1.0

 * @package ShowTime

 */

require_once 'Web Semantica/consultas_sparql.php';

require_once 'Banco de Dados/database.php';

require_once 'vendor/autoload.php';

class Artista

{

	/**

     *

     * @var nome contendo o nome do artista

     * @var anoInicio contendo o ano em que o artista começou a carreira

     * @var imagem contendo uma imagem do artista (geralmente retirado do Spotify)

     * @var genero array contendo os generos do artista (retirado do dbpedia)

     * @var local array contendo o local de nascimento do artista (retirado do dbpedia)

     * @var associados array contendo os artistas associados ao artista (retirado do dbpedia)

     */

	private $nome, $anoInicio, $imagem;

    private $genero = array(), $local = array(), $associados = array();



	/**

     * Construtor

     * @access public

     */

    public function __construct($nome, $imagem) {

        $this->nome = $nome;

        if($imagem!=null)

            $this->imagem = $imagem;



    }



    public function insereArtista($conn, $genres=null){

        if(existeRecurso($this->nome)){

            $generos = achaGeneros($this->nome);

            $locais = achaLocal($this->nome);

            $ano = achaAno($this->nome);

            $associados = achaAssociados($this->nome);

            //$parecidos = achaParecidosGenero($aux);

        }

        $procura = find($conn, 'artista', $this->nome);

        if($procura!=null){

            if(isset($ano)){

                $dados['anoInicio'] = $ano;

            }

            $dados['Imagem'] = $this->imagem;

            update($conn, 'artista', $this->nome, $dados);

            unset($dados);  

        }

        else{

            $dados['Nome'] = $this->nome;

            $dados['Imagem'] = $this->imagem;

            if(isset($ano))

                $dados['anoInicio'] = $ano;

            save($conn, 'artista', $dados);

            unset($dados);

        }

        $dados['Nome'] = $this->nome;

        if(isset($genres)){

            foreach($genres as $genre){

                $dados['Genero'] = $genre;

                save($conn, 'possuigenero', $dados); //Salva generos do Spotify

            }

        }

        unset($dados);

        $dados['Nome'] = $this->nome;

        if(isset($generos)){

            foreach($generos as $genero){

                $dados['Genero'] = $genero;

                save($conn, 'possuigenero', $dados); //Salva generos da DBPedia

            }

        }    

        unset($dados);

        $dados['Nome'] = $this->nome;

        if(isset($locais)){

            foreach($locais as $local){

                $dados['Local'] = $local;

                save($conn, 'possuilocal', $dados);

            }

        }

        unset($dados);

        if(isset($associados)){

            foreach($associados as $associado){

                $procura = find($conn, 'artista', $associado);

                if($procura==null){

                    $dados['Nome'] = $associado;

                    save($conn, 'artista', $dados); 

                    unset($dados);

                }

                $dados['A'] = $this->nome;

                $dados['B'] = $associado;

                save($conn, 'associado', $dados);

                unset($dados);

            }

        }           

    }



    public function carrega($conn){

        $artista = find($conn, 'artista', $this->nome);

        if($artista==null){

            echo "Artista não encontrado", "<br>";

            return null;

        }

        else{

            $this->anoInicio = $artista[0]['anoInicio'];

            $this->imagem = $artista[0]['Imagem'];

            $generos = find($conn,'possuigenero', $this->nome);

            if($generos==null)

                $this->genero = null;

            else

                foreach($generos as $genero)

                    $this->genero[] = $genero['Genero'];

            $locais = find($conn,'possuilocal', $this->nome);

            if($locais==null)

                $this->local = null;

            else

                foreach($locais as $local)

                    $this->local[] = $local['Local'];

            $associados = find($conn,'associado', $this->nome);

            if($associados==null)

                $this->associados = null;

            else

                foreach($associados as $associado)

                    $this->associados[] = $associado['B'];

        }

    }



    public function getNome(){

        return $this->nome;

    }



    public function getAssociados(){

        return $this->associados;

    }



    public function setImage($conn=null){
        $session = new SpotifyWebAPI\Session(
            'a8eb8437bd354f478f45f41487844e2a',
            'd1c3f1d5a5794dd3a00c0a7e84518e23'
        );
        $session->requestCredentialsToken();
        $accessToken = $session->getAccessToken();
        $api = new SpotifyWebAPI\SpotifyWebAPI();
        $api->setAccessToken($accessToken);
        $options['limit']=1;
        $artistas = $api->search('Silva', 'artist', $options);
        $teste = json_decode(json_encode($artistas), true);
        $this->imagem = $teste['artists']['items'][0]['images'][1]['url'];
        if(isset($conn)){
            $dados['Imagem'] = $this->imagem;
            update($conn, 'artista', $this->nome, $dados);
        }
    }

    public function obtainGenres(){
        $session = new SpotifyWebAPI\Session(
            'a8eb8437bd354f478f45f41487844e2a',
            'd1c3f1d5a5794dd3a00c0a7e84518e23'
        );
        $session->requestCredentialsToken();
        $accessToken = $session->getAccessToken();
        $api = new SpotifyWebAPI\SpotifyWebAPI();
        $api->setAccessToken($accessToken);
        $options['limit']=1;
        $artistas = $api->search('Silva', 'artist', $options);
        $teste = json_decode(json_encode($artistas), true);
        return $teste['artists']['items'][0]['genres'];
    }



    public function getImage(){

        return $this->imagem;

    }

    public function getGeneros(){
        if(!isset($this->genero))
            return null;
        else{
            $retorno = "";
            foreach($this->genero as $genero)
                $retorno .= $genero . ", ";
            $retorno = trim($retorno);
            $retorno = rtrim($retorno, ",");
            return $retorno;
        }
    }



}



?>