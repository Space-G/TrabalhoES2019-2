<?php
$db = new PDO('mysql:host=127.0.0.1;dbname=gabriels_picker;charset=utf8', "gp", 'gp');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // isso é extremamente importante pra debugar

session_start();
try{
	$get_regions = $db->prepare("SELECT region_id, estado, regiao FROM regions ORDER BY estado");
	$get_regions->execute();
	echo json_encode(array('success' => true, 'msg' => $get_regions->fetchAll()));
} catch (\Exception $e) {
	echo json_encode(array('success' => false, 'msg' => $e->getMessage()));
}

$db = null; // desliga a conexão
?>
