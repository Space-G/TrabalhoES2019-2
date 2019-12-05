<?php
$db = new PDO('mysql:host=localhost;dbname=gabriels_picker;charset=utf8', "root");
$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); // isso é extremamente importante pra debugar

session_start();
try{
    if (isset($_SESSION['user_id']) && isset($_POST['target_id']) && isset($_POST['rate'])){ // recebeu informações suficientes para executar?
        $already_friends_stmt = $db->prepare('SELECT COUNT(*) FROM friends WHERE client_id = ? AND escort_id = ?');
        $already_friends_stmt->execute(array($_POST['target_id'], $_SESSION['user_id']));
        $already_friends = $already_friends_stmt->fetch(PDO::FETCH_NUM)[0];

        if ($already_friends == 1){ // são amigos?

            $rating_already_exists_stmt = $db->prepare('SELECT COUNT(*) FROM ratings WHERE rater_id = ? AND subject_id = ?');
            $rating_already_exists_stmt->execute(array($_SESSION['user_id'], $_POST['target_id']));
            $rating_already_exists = $rating_already_exists_stmt->fetch(PDO::FETCH_NUM)[0];

            if ($rating_already_exists == 1){ // atualizar rate ou criar novo?
                $update_rate = $db->prepare('UPDATE ratings SET score = ? WHERE rater_id = ? AND subject_id = ?');
                $update_rate->execute(array($_POST['rate'], $_SESSION['user_id'], $_POST['target_id']));
            } else{
                $rate = $db->prepare('INSERT INTO ratings(rater_id, subject_id, score) VALUES (?, ?, ?)');
                $rate->execute(array($_SESSION['user_id'], $_POST['target_id'], $_POST['rate']));
            }
        }else{
            echo json_encode(array('success' => false, 'msg' => 'not_friends'));
        }
    }else{
        echo json_encode(array('success' => false, 'msg' => 'not_logged_in'));
    }
} catch (\Exception $e){
    echo json_encode(array('success' => false, 'msg' => $e->getMessage()));
}

$db = null;
?>
