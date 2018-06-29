<?php
/**
 * Classe que irá lidar com métodos específicos do artista
 * @author Adson Duarte <airduarte@inf.ufpel.edu.br>
 * @author Larissa Araujo <ldaaraujo@inf.ufpel.edu.br>
 * @author Yuri Weisshahn <yrweisshahn@inf.ufpel.edu.br>
 * @version 1.0
 * @package ShowTime
 */
include 'WSO/sparql.php';
class Artista
{
	/**
     *
     * @var nome contendo o nome do artista
     * @var anoInicil contendo o ano em que o artista começou a carreira
     * @var imagem contendo uma imagem do artista (geralmente retirado do Spotify)
     * @var genero array contendo os generos do artista (retirado do dbpedia)
     * @var local array contendo o local de nascimento do artista (retirado do dbpedia)
     * @var associados array contendo os artistas associados ao artista (retirado do dbpedia)
     */
	private $nome, $anoInicio, $imagem, $genero, $local, $associados;

	/**
     * Construtor
     * @access public
     */
    public function __construct() {

    }



}

?>