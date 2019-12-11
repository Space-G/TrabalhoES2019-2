<?php

include_once "session_start.php";
include_once "../Persistence/db_connection.php";
include_once "../Persistence/profileDAO.php";

$db = new db_connection();
$db = $db->conectar();
$profile = new profileDAO();

$list_profiles = $profile->list_profile($db);
echo json_encode(array($list_profiles));

?>