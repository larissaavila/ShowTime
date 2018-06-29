<?php
/**
 * Classe que irá lidar com métodos específicos do evento
 * @author Adson Duarte <airduarte@inf.ufpel.edu.br>
 * @author Larissa Araujo <ldaaraujo@inf.ufpel.edu.br>
 * @author Yuri Weisshahn <yrweisshahn@inf.ufpel.edu.br>
 * @version 1.0
 * @package ShowTime
 */
include 'Artista.php';
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
    public function __construct() {

    }

}

?>