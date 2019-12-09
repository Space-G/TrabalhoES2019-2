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
	$update_region = $db->prepare("UPDATE regions SET estado = ?, regiao = ? WHERE region_id = ?");
	if ($update_region->execute(array($_POST['estado'], $_POST['regiao'], $_POST['region_id']))){
		echo json_encode(array('success' => true, 'msg' => $update_region->rowCount()));
	} else{
		throw new Exception($db->errorInfo()[2]);
	}
} catch (\Exception $e) {
	echo json_encode(array('success' => false, 'msg' => $e->getMessage()));
}

$db = null; // desliga a conexão
?>