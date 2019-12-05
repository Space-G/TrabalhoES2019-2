<?php
$db = new PDO('mysql:host=127.0.0.1;dbname=gabriels_picker;charset=utf8', 'gp','gp');
$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); // isso é extremamente importante pra debugar

//header('Content-Type: application/json');

try{
session_start();
} catch (\Exception $e){}
try{
    if (isset($_POST['target_id'])){ // recebeu informações suficientes para executar?
        $get_score_stmt = $db->prepare('SELECT AVG(score) FROM ratings WHERE subject_id = ?');
        $get_score_stmt->execute(array($_POST['target_id']));
        $get_score = $get_score_stmt->fetch(PDO::FETCH_NUM)[0];
        echo json_encode(array('success' => true, 'msg' => $get_score));
    }else{
        echo json_encode(array('success' => false, 'msg' => 'no_target'));
    }
} catch (\Exception $e){
    echo json_encode(array('success' => false, 'msg' => $e->getMessage()));
}

$db = null;
?>
