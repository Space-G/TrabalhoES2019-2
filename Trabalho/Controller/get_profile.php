<?php

include_once "session_start.php";
include_once "../Persistence/db_connection.php";
include_once "../Persistence/profileDAO.php";
include_once "../Persistence/requestsDAO.php";

$db = new db_connection();
$db = $db->conectar();
$profile = new profileDAO();
$requests = new requestsDAO();

$user = array('id' => $_SESSION['user_id'],
			'is_friend' => $requests->are_friends($_SESSION['user_id'], $_POST['target_id'], $db),
			'request_exists' => $requests->request_exists($_SESSION['user_id'],$_POST['target_id'], $db),
			'is_escort' => $profile->get_profile($_SESSION['user_id'], $db)['is_escort']);

$get_profile = $profile->get_profile($_POST['target_id'], $db);
$get_profile['rating'] = $profile->get_rate($_POST['target_id'], $db);
echo json_encode(array('success' => true, 'msg' => null, 'profile' => $get_profile, 'user' => $user))

?>