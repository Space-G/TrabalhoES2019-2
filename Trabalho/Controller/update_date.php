<?php

include_once "session_start.php";
include_once "../Persistence/db_connection.php";
include_once "../Persistence/datesDAO.php";

$db = new db_connection();
$db = $db->conectar();

$datesDAO = new datesDAO();
if($_POST['func'] == 'add') {
	print_r($datesDAO->create_date($_POST['add_date_id1'], $_POST['add_date_id2'], $_POST['add_date_data'], $_POST['add_date_regiao'], $db));
}
?>