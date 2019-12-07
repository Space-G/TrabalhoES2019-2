<?php
if(!isset($_SESSION)) {
	if(!isset($_SESSION)) {
		session_start();
	} elseif(empty($_SESSION)){
		session_start();
	}
}
echo json_encode(array('own_id' => $_SESSION['user_id']));
?>
