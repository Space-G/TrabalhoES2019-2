<?php
$db = new PDO('mysql:host=localhost;dbname=gabriels_picker;charset=utf8', "root");
$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); // isso é extremamente importante pra debugar

//header('Content-Type: application/json');
try{
    if (isset($_SESSION['user_id']) && isset($_POST['target_id'])){ // recebeu informações suficientes para executar?
        $is_escort_stmt = $db->prepare('SELECT is_escort FROM user WHERE id = ?');
        $is_escort_stmt->execute(array($_SESSION['user_id']));

        $user_is_escort = $is_escort_stmt->fetch(PDO::FETCH_NUM)[0];

        $is_escort_stmt->execute(array($_POST['target_id']));
        $target_is_escort = $is_escort_stmt->fetch(PDO::FETCH_NUM)[0];

        if (!$user_is_escort && $target_is_escort){ // se trata de um cliente requisitando um acompanhante?
            $request_already_sent_stmt = $db->prepare('SELECT COUNT(*) FROM requests WHERE client_id = ? AND escort_id = ?');
            $request_already_sent_stmt->execute(array($_SESSION['user_id'], $_POST['target_id']));
            $request_already_sent = $request_already_sent_stmt->fetch(PDO::FETCH_NUM)[0];

            $already_friends_stmt = $db->prepare('SELECT COUNT(*) FROM friends WHERE client_id = ? AND escort_id = ?');
            $already_friends_stmt->execute(array($_SESSION['user_id'], $_POST['target_id']));
            $already_friends = $already_friends_stmt->fetch(PDO::FETCH_NUM)[0];

            if ($request_already_sent == 0 && $already_friends == 0){ // request já foi feito antes?
                $request = $db->prepare('INSERT INTO requests(client_id, escort_id) VALUES (?, ?)');
                $request->execute(array($_SESSION['user_id'], $_POST['target_id']));
                echo json_encode(array('success' => true, 'msg' => null));
            }else{
                echo json_encode(array('success' => false, 'msg' => 'request_already_sent'));
            }
        }else{
            echo json_encode(array('success' => false, 'msg' => 'not_escort'));
        }
    }else{
        echo json_encode(array('success' => false, 'msg' => 'not_logged_in'));
    }
} catch (\Exception $e){
    echo json_encode(array('success' => false, 'msg' => $e->getMessage()));
}

$db = null;
?>