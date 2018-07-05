<?php
/**
 * Classe que irá lidar com métodos específicos do artista
 * @author Adson Duarte <airduarte@inf.ufpel.edu.br>
 * @author Larissa Araujo <ldaaraujo@inf.ufpel.edu.br>
 * @author Yuri Weisshahn <yrweisshahn@inf.ufpel.edu.br>
 * @version 1.0
 * @package ShowTime
 */
require_once 'Web Semantica\consultas_sparql.php';
require_once 'Banco de Dados\database.php';
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
    public function __construct($nome) {
        $this->nome = $nome;

    }

    public function insereArtista($conn, $nome, $genres){
        if(existeRecurso($nome)){
            $generos = achaGeneros($nome);
            $locais = achaLocal($nome);
            $ano = achaAno($nome);
            $associados = achaAssociados($nome);
            //$parecidos = achaParecidosGenero($aux);
        }
        $procura = find($conn, 'artista', $nome);
        if($procura!=null){
            if(isset($ano)){
                $dados['anoInicio'] = $ano;
                update($conn, 'artista', $nome, $dados);
                unset($dados);  
            }
        }
        else{
            $dados['Nome'] = $nome;
            if(isset($ano))
                $dados['anoInicio'] = $ano;
            save($conn, 'artista', $dados);
            unset($dados);
        }
        $dados['Nome'] = $nome;
        if(isset($genres)){
            foreach($genres as $genre){
                $dados['Genero'] = $genre;
                save($conn, 'possuigenero', $dados); //Salva generos do Spotify
            }
        }
        unset($dados);
        $dados['Nome'] = $nome;
        if(isset($generos)){
            foreach($generos as $genero){
                $dados['Genero'] = $genero;
                save($conn, 'possuigenero', $dados); //Salva generos da DBPedia
            }
        }    
        unset($dados);
        $dados['Nome'] = $nome;
        if(isset($locais)){
            foreach($locais as $local){
                $dados['Local'] = $local;
                save($conn, 'possuilocal', $dados);
            }
        }
        unset($dados);
        if(isset($associados)){
            foreach($associados as $associado){
                $procura = find('artista', $associado);
                if($procura==null){
                    $dados['Nome'] = $associado;
                    save($conn, 'artista', $dados);
                    unset($dados);
                }
                $dados['A'] = $nome;
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


}

?>