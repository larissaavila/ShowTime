<?php

require_once "config.php";
set_time_limit(1800);

mysqli_report(MYSQLI_REPORT_STRICT);


function open_database() {

	try {
		$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    	$conn->set_charset("utf8");
		return $conn;
	} catch (Exception $e) {
		echo $e->getMessage();
		return null;
	}
}

function close_database($conn) {
	try {
		mysqli_close($conn);
	} catch (Exception $e) {
		echo $e->getMessage();
	}
}

/**
 *  Pesquisa um Registro pelo ID em uma Tabela
 */

function find($conn, $table = null, $id = null, $what = null ) {
	$found = null;

	try {
	  	if ($id) {
		    if(strpos($id, "'")){
		      	$id = str_replace("'", "''", $id);
		      }
		  	$sql = "SELECT * FROM " . $table;

		  	if($table == "artista" || $table == "possuigenero" || $table == "possuilocal"){
		  		$sql .= " WHERE Nome LIKE '%$id%'";
		  	}
		  	elseif($table == "usuario"){
		  		$sql .= " WHERE Login LIKE '%$id%'";
		  	}
	      	elseif($table == "gosta"){
	        	if($what == 0)
	          		$sql .= " WHERE Login LIKE '%$id%'";
	        	else
	          		$sql .= " WHERE Nome LIKE '%$id%'";
	      	}
	      	elseif($table == "evento"){
	      		$sql .= " WHERE Artista LIKE '%$id%'";
	       	}
		  	else{
		  		$sql .= " WHERE A LIKE '%$id%'";
		  	}
		    $result = $conn->query($sql);

		    if ($result->num_rows > 0) {
		      	$found = $result->fetch_all(MYSQLI_ASSOC);
		    }	    
	 	} else {

		    $sql = "SELECT * FROM " . $table;
		    $result = $conn->query($sql);
	    	if ($result->num_rows > 0) {
	      		$found = $result->fetch_all(MYSQLI_ASSOC);
	      	}
	      }

        

        /* Metodo alternativo

        $found = array();



        while ($row = $result->fetch_assoc()) {

          array_push($found, $row);

        } */
	} catch (Exception $e) {
		$_SESSION['message'] = $e->GetMessage();
	  	$_SESSION['type'] = 'danger';
  	}
	return $found;
}


function find_all($conn, $table ) {
	return find($conn, $table);	
}

/**
*  Insere um registro no BD
*/

function save($conn, $table = null, $data = null) {
	$columns = null;
	$values = null;
  	foreach ($data as $key => $value) {
	    $columns .= trim($key, "'") . ",";
	    if(strpos($value, "'"))
	      $value = str_replace("'", "''", $value);
	    $values .= "'$value',";
  	}
  	// remove a ultima virgula

  	$columns = rtrim($columns, ',');
  	$values = rtrim($values, ',');

  	$sql = "INSERT INTO " . $table . "($columns)" . " VALUES " . "($values);";

  	try {
	    $conn->query($sql);
	    $_SESSION['message'] = 'Registro cadastrado com sucesso.';
	    $_SESSION['type'] = 'success';
	} catch (Exception $e) { 
	    $_SESSION['message'] = 'Nao foi possivel realizar a operacao.';
	    $_SESSION['type'] = 'danger';
	} 
}



/**

 *  Atualiza um registro em uma tabela, por ID

 */

function update($conn, $table = null, $id = 0, $data = null) {
	$items = null;
	foreach ($data as $key => $value) {
	    if(strpos($value, "'"))
	    	$value = str_replace("'", "''", $value);
	    $items .= trim($key, "'") . "='$value',";
	}

	// remove a ultima virgula
	$items = rtrim($items, ',');

  	if(strpos($id, "'"))
    	$id = str_replace("'", "''", $id);

  	$sql  = "UPDATE " . $table;
  	$sql .= " SET $items";
  	if($table == "artista" || $table == "possuigenero" || $table == "possuilocal" || $table == "evento")
		$sql .=" WHERE Nome LIKE '%$id%'";

  	elseif($table == "usuario" || $table == "gosta")
  		$sql .=" WHERE Login LIKE '%$id%'";

  	else
		$sql .=" WHERE A LIKE '%$id%'";

  	try {
	    $conn->query($sql);
	    $_SESSION['message'] = 'Registro atualizado com sucesso.';
	    $_SESSION['type'] = 'success';
	} catch (Exception $e) { 
		$_SESSION['message'] = 'Nao foi possivel realizar a operacao.';
    	$_SESSION['type'] = 'danger';
  	} 
}



/**

 *  Remove uma linha de uma tabela pelo ID do registro

 */

/*function remove( $table = null, $id = null ) {



  $database = open_database();

	

  try {

    if ($id) {

      $sql = "DELETE FROM " . $table;

      if($table == "atestadomatricula"){

      	$sql .= " WHERE NUMMATRICULA LIKE '%$id%'";

      }

      elseif($table == "listabolsistas"){

      	$sql .= " WHERE CPF LIKE '%$id%'";

      }

      else{

      	$sql .= " WHERE EMAIL LIKE '%$id%'";

      }



      //$sql = "DELETE FROM " . $table . " WHERE EMAIL LIKE '%$id%'";

      $result = $database->query($sql);



      if ($result = $database->query($sql)) {   	

        $_SESSION['message'] = "Registro Removido com Sucesso.";

        $_SESSION['type'] = 'success';

      }

    }

  } catch (Exception $e) { 



    $_SESSION['message'] = $e->GetMessage();

    $_SESSION['type'] = 'danger';

  }



  close_database($database);

}*/



?>