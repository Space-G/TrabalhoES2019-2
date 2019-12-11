<?php

include_once "session_start.php";
include_once "../Persistence/db_connection.php";
include_once "../Persistence/regionsDAO.php";

$db = new db_connection();
$db = $db->conectar();

$regionsDAO = new regionsDAO();

if ($_POST['func'] == "add") {
	print_r($regionsDAO->create_region($_POST['estado'], $_POST['regiao'], $db));
} elseif ($_POST['func'] == 'change'){
	print_r($regionsDAO->update_region($_POST['region_id'], $_POST['estado'], $_POST['regiao'], $db));
} else{
	print_r($regionsDAO->create_region($_POST['region_id'], $db));
}
?>