<?php

include_once "session_start.php";
include_once "../Persistence/db_connection.php";
include_once "../Persistence/profileDAO.php";
include_once "../Persistence/requestsDAO.php";

$db = new db_connection();
$db = $db->conectar();
$requests = new requestsDAO();

if($_POST['func'] == 'add'){
	print_r($requests->create_request($_SESSION['user_id'], $_POST['target_id'], $db));
} elseif ($_POST['func'] == 'accept'){
	print_r($requests->accept_request($_SESSION['user_id'], $_POST['target_id'], $db));
}

?>