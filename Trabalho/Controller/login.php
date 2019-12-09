<?php

include_once "session_start.php";
include_once "../Persistence/db_connection.php";
include_once "../Persistence/loginDAO.php";

$db = new db_connection();
$db = $db->conectar();
$login = new loginDAO();

if($login->check($_POST['email'], $_POST['password'], $db)){
	$_SESSION['user_id'] = $login->search_email($_POST['email'], $db);
	$_SESSION['is_admin'] = $login->is_adm($_SESSION['user_id'], $db);
	echo json_encode(array('success' => true, 'msg' => null));
} else{
	echo json_encode(array('success' => false, 'msg' => 'credentials'));
}
?>
