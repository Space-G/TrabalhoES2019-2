<?php

include_once "session_start.php";
include_once "../Persistence/db_connection.php";
include_once "../Persistence/datesDAO.php";

$db = new db_connection();
$db = $db->conectar();

$datesDAO = new datesDAO();
if($_POST['func'] == 'add') {
	print_r($datesDAO->create_date($_POST['add_date_id1'], $_POST['add_date_id2'], $_POST['add_date_data'], $_POST['add_date_regiao'], $db));
}elseif ($_POST['func'] == 'update'){
	print_r($datesDAO->update_date($_POST['date_id'], $_POST['user_id1'], $_POST['user_id2'], $_POST['date_regiao'], $_POST['date_data'], $db));
} else{
	print_r($datesDAO->delete_date($_POST['date_id'], $db));
}
?>