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
	$add_region = $db->prepare("INSERT INTO regions(estado, regiao) VALUES (?, ?)");
	if ($add_region->execute(array($_POST['estado'], $_POST['regiao']))){
		echo json_encode(array('success' => true, 'msg' => $add_region->rowCount()));
	} else{
		throw new Exception('Algo deu errado');
	}
} catch (\Exception $e) {
	echo json_encode(array('success' => false, 'msg' => $e->getMessage()));
}

$db = null; // desliga a conexão
?>