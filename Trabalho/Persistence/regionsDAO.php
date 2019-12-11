<?php
// Responsável pelo CRUD da tabela regions
class regionsDAO{
	function __construct(){}

//	cria uma nova região
	function create_region($estado, $regiao, $connection){
		$new_region = $connection->prepare("INSERT INTO regions(estado, regiao) VALUES (?, ?)");
		$new_region->execute(array($estado, $regiao));
		return $new_region->rowCount();
	}

//	seleciona todas regiões
	function get_region($connection){
		return $connection->query("SELECT * FROM regions ORDER BY estado")->fetchAll();
	}

//	edita região de ID selecionado
	function update_region($region_id, $estado, $regiao, $connection){
		$region_stmt = $connection->prepare("UPDATE regions SET estado = ?, regiao = ? WHERE region_id = ?");
		return $region_stmt->execute(array($estado, $regiao, $region_id));
	}

//	delete região de ID selecionado
	function delete_region($region_id, $connection){
		$delete_stmt = $connection->prepare("DELETE FROM regions WHERE region_id = ?");
		return $delete_stmt->execute(array($region_id));
	}
}
