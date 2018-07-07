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
	private $nome, $local, $data, $descricao, $imagem, $Artista;

	 /**
     * Construtor que caso tenha apenas um parâmetro então deve começar buscando o evento
     * no banco de dados e o carregando para a classe ou se tiver seis parâmetros deve
     * inserir evento novo no banco de dados
     * @access public
     */
    public function __construct($evento) {
        $this->nome = $evento['Nome'];
        $this->local = $evento['Local'];
        $this->data = $evento['Data'];
        $this->descricao = $evento['Descricao'];
        $this->imagem = $evento['Imagem'];
        $this->Artista = $evento['Artista'];

    }

    public function insereEvento($conn, $nome, $local, $data, $descricao, $artista){
        $procura = find($conn, 'artista', $artista);
        if($procura==null){
            insereArtista($conn, $artista, null);
        }
        $dados['Nome'] = $nome;
        $dados['Local'] = $local;
        $dados['Data'] = $data;
        $dados['Descricao'] = $descricao;
        $dados['Artista'] = $artista;

        save($conn, 'evento', $dados);
    }

    public function getNome(){
        return $this->nome;
    }

}

?>