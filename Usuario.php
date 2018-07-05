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
	private $login, $nome;
    private $eventos = array(), $recomendacoes = array(), $topArtistas = array();

	 /**
     *Construtor que deve começar com valores default até o login ser autenticado
     * @access public
     */
    public function __construct() {
    }

     /**
     * Função que recebe o login do usuário e verifica se o usuário já está cadastrado,
     * se estiver então carrega os dados do usuário para a classe
     * @access public
     * @param String $login Indica o login do Spotify do usuário
     * @return int Indicando se o login foi feito corretamente ou erro de usuário inexistente
     */
    public function login($login){
        $this->login = $login;
        $conn = open_database();
        $procura = find($conn, 'usuario', $login);
        if($procura==null){
            close_database($conn);
            return null;
        }
        else{
            $this->nome = $procura[0]['Nome'];
            $procura = find($conn, 'gosta', $login, 0);
            if($procura==null){
                echo "Erro: usuário não possui artistas na tabela gosta";
                return null;
            }
            else{
                foreach($procura as $gosto){
                    $artista = new Artista($gosto['Nome']);
                    $artista->carrega($conn);
                    $this->topArtistas[] = $artista;
                }
            }
            close_database($conn);
            return 1;
        }
    }

    public function recomendar(){
        $i = 0;
        $conn = open_database();
        foreach($this->topArtistas as $topArtista){
            $eventos = find($conn, 'evento', $topArtista->getNome());
            if($eventos!=null){
                foreach($eventos as $evento){
                    $show = New Evento($evento);
                    $this->recomendacoes[$i]['Evento'] = $show;
                    $this->recomendacoes[$i]['Artista'] = $evento['Artista'];
                    $this->recomendacoes[$i]['Associado'] = null;
                    $i++;    
                }
            }
            if($topArtista->getAssociados()!=null){
               foreach($topArtista->getAssociados() as $associado){
                    
                    $eventos = find($conn, 'evento', $associado);
                    if($eventos!=null){
                        foreach($eventos as $evento){
                            $show = new Evento($evento);
                            $this->recomendacoes[$i]['Evento'] = $show;
                            $this->recomendacoes[$i]['Artista'] = $topArtista->getNome();
                            $this->recomendacoes[$i]['Associado'] = $evento['Artista'];
                            $i++;    
                        }
                    }
                } 
            }
        }
        close_database($conn);   
    }

    public function getRecomendacoes(){
        return $this->recomendacoes;
    }

    public function getTop(){
        return $this->topArtistas;
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