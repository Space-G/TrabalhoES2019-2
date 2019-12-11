<?php

include_once "session_start.php";
include_once "../Persistence/db_connection.php";
include_once "../Persistence/regionsDAO.php";

$db = new db_connection();
$db = $db->conectar();

$regionsDAO = new regionsDAO();

print_r($regionsDAO->create_region($_POST['estado'], $_POST['regiao'], $db));
?>