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
	$add_date = $db->prepare("INSERT INTO dates(user1, user2, day, region) VALUES (?, ?, ?, ?)");
	if ($add_date->execute(array($_POST['user1'], $_POST['user2'], $_POST['day'], $_POST['region']))){
		echo json_encode(array('success' => true, 'msg' => $add_date->rowCount()));
	} else{
		throw new Exception('Algo deu errado');
	}
} catch (\Exception $e) {
	echo json_encode(array('success' => false, 'msg' => $e->getMessage()));
}

$db = null; // desliga a conexão
?>