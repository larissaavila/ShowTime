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
	private $nome, $anoInicio, $imagem;
    private $genero = array(), $local = array(), $associados = array();

	/**
     * Construtor
     * @access public
     */
    public function __construct($nome) {
        $this->nome = $nome;

    }

    public function carrega(){
        $artista = $find('artista', $this->nome);
        if($artista==null){
            echo "Artista não encontrado", "<br>";
            return null;
        }
        else{
            $this->anoInicio = $artista['anoInicio'];
            $this->imagem = $artista['imagen'];
            $generos = find('possuigenero', $this->nome);
            if($generos==null)
                $this->genero = null;
            else
                foreach($generos as $genero)
                    $this->genero[] = $genero['Genero'];
            $locais = find('possuilocal', $this->nome);
            if($locais==null)
                $this->local = null;
            else
                foreach($locais as $local)
                    $this->local[] = $local['Local'];
            $associados = find('associado', $this->nome);
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


}

?>