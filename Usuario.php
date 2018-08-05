<?php

/**

 * Classe que irá lidar com métodos específicos do Usuário

 * @author Adson Duarte <airduarte@inf.ufpel.edu.br>

 * @author Larissa Araujo <ldaaraujo@inf.ufpel.edu.br>

 * @author Yuri Weisshahn <yrweisshahn@inf.ufpel.edu.br>

 * @version 1.0

 * @package ShowTime

 */

require_once 'Artista.php';

require_once 'Evento.php';

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



    public function cadastrarUsuario($caminho, $login, $nome){

        $conn = open_database();

        $procura = find($conn, 'usuario', $login);

        if($procura!=null){

            $retorno = null;

        }

        else{

            $string = file_get_contents($caminho);

            $json = json_decode($string, true);

            //echo '<pre>' . print_r($json, true) . '</pre>'; //Interessante para ver o formato do JSON

            $dados['Login'] = $login;

            $dados['Nome'] = $nome;



            save($conn, 'usuario', $dados);

            unset($dados);

            for($i=0;$i<10;$i++){

                $name = $json['items'][$i]['name'];

                $image = $json['items'][$i]['images'][1]['url'];

                $procura = find($conn, 'gosta', $name, 1);

                if($procura==null){

                    foreach($json['items'][$i]['genres'] as $genero){

                        $generos[] = $genero;

                    }

                    $artista = new Artista($name, $image);

                    if(isset($generos)){

                        $artista->insereArtista($conn, $generos);

                    }

                    else{

                        $artista->insereArtista($conn, null);

                    }

                    unset($generos);

                }

                $dados['Login'] = $login;

                $dados['Nome'] = $name;

                save($conn, 'gosta', $dados);

            }

            $retorno = 1;

        }

        close_database($conn);

        return $retorno;



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

            $this->recomendacoes = null;

            $procura = find($conn, 'gosta', $login, 0);

            if($procura==null){

                echo "Erro: usuário não possui artistas na tabela gosta";

                return null;

            }

            else{

                foreach($procura as $gosto){

                    $artista = new Artista($gosto['Nome'],null);

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

        $eita = 0;

        $conn = open_database();

        foreach($this->topArtistas as $topArtista){

            $eventos = find($conn, 'evento', $topArtista->getNome());

            if($eventos!=null){

                foreach($eventos as $evento){

                    if($this->recomendacoes!=null){

                    foreach($this->recomendacoes as $recomendacoes){

                        if($recomendacoes['Evento']->getNome() == $evento['Nome']){

                            $eita = 1;

                        }

                    }}

                    if($eita!=1){

                        $show = New Evento($evento);
                        $show->setImage();

                        $this->recomendacoes[$i]['Evento'] = $show;

                        $this->recomendacoes[$i]['Artista'] = $topArtista;

                        $this->recomendacoes[$i]['Associado'] = null;

                        $i++;  

                    }

                    else{

                        $eita = 0;

                    }

                }

            }

            if($topArtista->getAssociados()!=null){

               foreach($topArtista->getAssociados() as $associado){

                    

                    $eventos = find($conn, 'evento', $associado);

                    if($eventos!=null){

                        foreach($eventos as $evento){

                            if($this->recomendacoes!=null){

                            foreach($this->recomendacoes as $recomendacoes){

                                if($recomendacoes['Evento']->getNome() == $evento['Nome']){

                                    $eita = 1;

                                }

                            }}

                            if($eita!=1){

                                $show = new Evento($evento);
                                $show->setImage();

                                $this->recomendacoes[$i]['Evento'] = $show;

                                $this->recomendacoes[$i]['Artista'] = $topArtista;

                                $this->recomendacoes[$i]['Associado'] = $evento['Artista'];

                                $i++;

                            }

                            else{

                                $eita=0;

                            }

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

    public function buscarAssociado($A){
        $conn = open_database();
        return find($conn, 'associado', $A);
    }   



}



?>