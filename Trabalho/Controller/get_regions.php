<?php

include_once "session_start.php";
include_once "../Persistence/db_connection.php";
include_once "../Persistence/regionsDAO.php";

$db = new db_connection();
$db = $db->conectar();

$regionsDAO = new regionsDAO();

try{
	echo json_encode(array('success' => true, 'msg' => $regionsDAO->get_region($db)));
} catch (\Exception $e) {
	echo json_encode(array('success' => false, 'msg' => $e->getMessage()));
}

?>