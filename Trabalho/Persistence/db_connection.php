<?php
// Faz conexão com o banco de dados
class db_connection{
	private $server_address = "127.0.0.1";
	private $dbname = "gabriels_picker";
	private $dbuser = "gp";
	private $dbpass = "gp";
	private $connection = null;

	function __construct(){}

	function conectar(){
		if($this->connection == null) {
			$this->connection = new PDO('mysql:host=' . $this->server_address . ';dbname=' . $this->dbname . ';charset=utf8', $this->dbuser, $this->dbpass);
			$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // isso é extremamente importante pra debugar
		} if(!$this->connection){
			die(json_encode(array('success' => false, 'msg' => $this->connection->getMessage())));
		}
		return $this->connection;
	}
}
?>