<?php

include_once "/home/monika/Documentos/UFLA/ES/TrabalhoES2019-2/Trabalho/Persistence/db_connection.php";
include_once "/home/monika/Documentos/UFLA/ES/TrabalhoES2019-2/Trabalho/Persistence/loginDAO.php";

use PHPUnit\Framework\TestCase;

class TesteRegions extends TestCase{
	public function test_login(){
		$db = new db_connection();
		$db = $db->conectar();
		$loginDAO = new loginDAO();
		$this->assertEquals(1, $loginDAO->check('admin','admin',$db));
	}
}

?>