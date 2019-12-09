<?php

include_once "session_start.php";

if(empty($_SESSION['user_id'])){
	echo json_encode(array('logged_in' => false, 'user_id' => null));
}else{
	echo json_encode(array('logged_in' => true, 'user_id' => $_SESSION['user_id']));
}

?>