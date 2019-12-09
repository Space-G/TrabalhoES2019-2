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
	$remove_region = $db->prepare("DELETE FROM  regions WHERE region_id = ?");
	if ($remove_region->execute(array($_POST['region_id']))){
		echo json_encode(array('success' => true, 'msg' => $remove_region->rowCount()));
	} else{
		throw new Exception($db->errorInfo()[2]);
	}
} catch (\Exception $e) {
	echo json_encode(array('success' => false, 'msg' => $e->getMessage()));
}

$db = null; // desliga a conexão
?>