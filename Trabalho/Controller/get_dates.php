<?php

include_once "session_start.php";
include_once "../Persistence/db_connection.php";
include_once "../Persistence/datesDAO.php";

$db = new db_connection();
$db = $db->conectar();

$datesDAO = new datesDAO();
if($_SESSION['is_admin'] == 1) {
	echo json_encode($datesDAO->get_all_dates($db));
}else{
	echo json_encode($datesDAO->get_dates($_SESSION['user_id'], $db));
}
?>