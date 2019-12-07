<?php
if(!isset($_SESSION)) {
	session_start();
}
echo json_encode(array('own_id' => $_SESSION['user_id']));
?>
