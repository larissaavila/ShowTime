<?php
/**
 * Classe que irá lidar com métodos específicos do Usuário
 * @author Adson Duarte <airduarte@inf.ufpel.edu.br>
 * @author Larissa Araujo <ldaaraujo@inf.ufpel.edu.br>
 * @author Yuri Weisshahn <yrweisshahn@inf.ufpel.edu.br>
 * @version 1.0
 * @package ShowTime
 */
include 'Artista.php';
include 'Evento.php';
class Usuario
{
    /**
     *
     * @var login contendo o login do usuário dado pelo Spotify
     * @var nome contendo o nome do usuário dado pelo Spotify
     * @var topArtistas array contendo os top artistas favoritos do usuário dado pelo Spotify
     * @var eventos array contendo os eventos confirmados pelo usuário
     */
	private $login, $nome, $topArtistas, $eventos;

	 /**
     *Construtor que deve começar com valores default até o login ser autenticado
     * @access public
     */
    public function __construct() {
    	$this->login = "";
    	$this->nome = "";
    }

     /**
     * Função que recebe o login do usuário e verifica se o usuário já está cadastrado,
     * se estiver então carrega os dados do usuário para a classe
     * @access public
     * @param String $login Indica o login do Spotify do usuário
     * @return int Indicando se o login foi feito corretamente ou erro de usuário inexistente
     */
    public function login($login){

    }

     /**
     * Função que recebe o evento e o coloca no array de eventos do usuário
     * @access public
     * @param Evento $evento Indica o evento da qual o usuário quer confirmar
     * @return int Indicando se o evento foi confirmado com sucesso ou se já passou da data
     */
    public function confirmarEvento($evento){

    }    

}

?>