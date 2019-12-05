<?php
$db = new PDO('mysql:host=localhost;dbname=gabriels_picker;charset=utf8', "gp","gp");
$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); // isso é extremamente importante pra debugar

session_start();
try{
    if (isset($_SESSION['user_id']) && isset($_POST['target_id'])){ // recebeu informações suficientes para executar?
        $is_escort_stmt = $db->prepare('SELECT is_escort FROM user WHERE id = ?');
        $is_escort_stmt->execute(array($_SESSION['user_id']));

        $user_is_escort = $is_escort_stmt->fetch(PDO::FETCH_NUM)[0];
        if ($user_is_escort){ // se trata de um acompanhante aceitando pedido?
            $request_exists_stmt = $db->prepare('SELECT COUNT(*) FROM requests WHERE client_id = ? AND escort_id = ?');
            $request_exists_stmt->execute(array($_POST['target_id'], $_SESSION['user_id']));
            $request_exists = $request_exists_stmt->fetch(PDO::FETCH_NUM)[0];

            $already_friends_stmt = $db->prepare('SELECT COUNT(*) FROM friends WHERE client_id = ? AND escort_id = ?');
            $already_friends_stmt->execute(array($_POST['target_id'], $_SESSION['user_id']));
            $already_friends = $already_friends_stmt->fetch(PDO::FETCH_NUM)[0];

            if ($request_exists == 1 && $already_friends == 0){ // request já foi feito antes?
                $db->beginTransaction();

                $befriend = $db->prepare('INSERT INTO friends(client_id, escort_id) VALUES (?, ?)');
                $befriend->execute(array($_POST['target_id'], $_SESSION['user_id']));

                $request_removal = $db->prepare('DELETE FROM requests WHERE client_id = ? AND escort_id = ?');
                $request_removal->execute(array($_POST['target_id'], $_SESSION['user_id']));

                $db->commit();

                echo json_encode(array('success' => true, 'msg' => null));
            }else{
                echo json_encode(array('success' => false, 'msg' => 'request_doesnt_exist'));
            }
        }else{
            echo json_encode(array('success' => false, 'msg' => 'not_escort'));
        }
    }else{
        echo json_encode(array('success' => false, 'msg' => 'not_logged_in'));
    }
} catch (\Exception $e){
    echo json_encode(array('success' => false, 'msg' => $e->getMessage()));
    if($db->inTransaction()){
        $db->rollBack();
    }
}

$db = null;
?>