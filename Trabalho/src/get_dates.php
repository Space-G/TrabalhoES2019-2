<?php
$db = new PDO('mysql:host=127.0.0.1;dbname=gabriels_picker;charset=utf8', "gp", 'gp');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // isso é extremamente importante pra debugar

try{
	if(!isset($_SESSION)) {
		session_start();
	} elseif(empty($_SESSION)){
		session_start();
	}
} catch (\Exception $e){}
try{
	if($_SESSION['is_admin']){
		$get_date = $db->prepare("SELECT * from  dates");
		$get_date->execute();
	} else{
		$get_date = $db->prepare("SELECT * from  dates WHERE (user1 = ? OR user2 = ?)");
		$get_date->execute(array($_SESSION['user_id'], $_SESSION['user_id']));
	}
	$dates = $get_date->fetchAll();
	if (!empty($dates)){
		echo json_encode(array('success' => true, 'msg' => $dates));
	} else{
		throw new Exception('Algo deu errado');
	}
} catch (\Exception $e) {
	echo json_encode(array('success' => false, 'msg' => $e->getMessage()));
}

$db = null; // desliga a conexão
?>