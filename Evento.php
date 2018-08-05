<?php

/**

 * Classe que irá lidar com métodos específicos do evento

 * @author Adson Duarte <airduarte@inf.ufpel.edu.br>

 * @author Larissa Araujo <ldaaraujo@inf.ufpel.edu.br>

 * @author Yuri Weisshahn <yrweisshahn@inf.ufpel.edu.br>

 * @version 1.0

 * @package ShowTime

 */

require_once 'Artista.php';

class Evento

{

	/**

     *

     * @var nome contendo o nome do evento

     * @var local contendo o local de ocorrência do evento

     * @var data contendo a data de ocorrência do evento

     * @var descricao contendo uma descrição do evento

     * @var imagem contendo uma imagem do evento

     * @var artista contendo o artista que será anfitrião do evento

     */

	private $nome, $local, $data, $descricao, $Artista, $imagem;



	 /**

     * Construtor que caso tenha apenas um parâmetro então deve começar buscando o evento

     * no banco de dados e o carregando para a classe ou se tiver seis parâmetros deve

     * inserir evento novo no banco de dados

     * @access public

     */

    public function __construct($evento=null) {

        if(isset($evento)){
            $this->nome = $evento['Nome'];

            $this->local = $evento['Local'];

            $this->data = $evento['Data'];

            $this->descricao = $evento['Descricao'];

            $this->Artista = $evento['Artista'];

            $this->imagem = null;
        }

    }



    public function insereEvento($nome, $local, $data, $descricao, $artista){

        $conn = open_database();
        
        $procura = find($conn, 'artista', $artista);

        if($procura==null){
            $artista = new Artista($artista);
            $artista->setImage();
            $artista->insereArtista($conn, $artista->obtainGenres());

        }
        else if($procura[0]['Imagem']==null){
            $artista = new Artista($artista);
            $artista->setImage($conn);
        }

        $dados['Nome'] = $nome;

        $dados['Local'] = $local;

        $dados['Data'] = $data;

        $dados['Descricao'] = $descricao;

        $dados['Artista'] = $artista;



        save($conn, 'evento', $dados);

        close_database($conn);

    }



    public function getNome(){

        return $this->nome;

    }

    

    public function getLocal(){

        return $this->local;

    }

    

    public function getDescricao(){

        return $this->descricao;

    }

    public function getData(){
        $retorno = explode("-",$this->data);
        return $retorno[2] . "/" . $retorno[1] . "/" . $retorno[0];
    }

    public function setImage(){
        $conn = open_database();
        $artista = find($conn, 'artista', $this->Artista);
        $this->imagem = $artista[0]['Imagem'];
        close_database($conn);
    }

    public function getImage(){
        return $this->imagem;
    }







}



?>