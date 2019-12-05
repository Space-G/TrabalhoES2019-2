<?php
$db = new PDO('mysql:host=127.0.0.1;dbname=gabriels_picker;charset=utf8', "gp",'gp');
$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); // isso é extremamente importante pra debugar

session_start();
try{
    if (isset($_POST)){ // recebeu informações suficientes para executar?
        $gender_string = implode(',', $_POST['gender']);
        $gender_id_string = implode(',', $_POST['gender_id']);
        $fetish_string = implode(',', $_POST['fetish']);

        $search_escorts_stmt = $db->prepare('SELECT id, name, gender, gender_identity FROM user INNER JOIN user_fetishes
WHERE FIND_IN_SET(gender, ?) AND FIND_IN_SET(gender_identity, ?) AND ? IN fetish AND region = ? AND is_escort = 1');
        $search_escorts_stmt->execute(array($gender_string, $gender_id_string, $fetish_string, $_POST['region_id']));
        $escorts = $search_escorts_stmt->fetchAll();
        echo json_encode(array('success' => true, 'msg' => null, escorts => $escorts));
    }else{
        echo json_encode(array('success' => false, 'msg' => 'no_query', escorts => null));
    }
} catch (\Exception $e){
    echo json_encode(array('success' => false, 'msg' => $e->getMessage(), escorts => null));
}

$db = null;
?>
