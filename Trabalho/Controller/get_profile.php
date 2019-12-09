<?php

include_once "session_start.php";
include_once "../Persistence/db_connection.php";
include_once "../Persistence/profileDAO.php";

$db = new db_connection();
$db = $db->conectar();
$profile = new profileDAO();

$user = array('id' => $_SESSION['user_id'], 'is_friend' => $is_friend, 'request_exists' => $request_already_sent, 'is_escort' => $user_is_escort);
echo json_encode(array('success' => true, 'msg' => null, 'profile' => $profile, 'user' => $user))

?>