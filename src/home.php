<?php
$db = new PDO('mysql:host=127.0.0.1;dbname=gabriels_picker;charset=utf8', "gp", 'gp');
$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); // isso é extremamente importante pra debugar

session_start();
try{
    if (isset($_SESSION['user_id'])){ // recebeu informações suficientes para executar?
        $is_escort_stmt = $db->prepare('SELECT is_escort FROM user WHERE id = ?');
        $is_escort_stmt->execute(array($_SESSION['user_id']));

        $user_is_escort = $is_escort_stmt->fetch(PDO::FETCH_NUM)[0];

        if($user_is_escort == 1){
            $search_clients_stmt = $db->prepare('SELECT client_id as "id", picture_file FROM friends INNER JOIN user ON friends.client_id=user.id WHERE escort_id = ?');
            $search_clients_stmt->execute(array($_SESSION['user_id']));
            $friends = $search_clients_stmt->fetchAll();
        } else{
            $search_escorts_stmt = $db->prepare('SELECT escort_id as "id", picture_file FROM friends INNER JOIN user ON friends.escort_id=user.id WHERE client_id = ?');
            $search_escorts_stmt->execute(array($_SESSION['user_id']));
            $friends = $search_escorts_stmt->fetchAll();
        }

        echo json_encode(array('success' => true, 'msg' => null, friends => $friends));
    }else{
        echo json_encode(array('success' => false, 'msg' => 'no_query', friends => null));
    }
} catch (\Exception $e){
    echo json_encode(array('success' => false, 'msg' => $e->getMessage(), friends => null));
}

$db = null;
?>
