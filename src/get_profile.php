<?php
$db = new PDO('mysql:host=localhost;dbname=gabriels_picker;charset=utf8', "root");
$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); // isso é extremamente importante pra debugar

//header('Content-Type: application/json');

try {
    if (isset($_POST)){ // checa se tem informações necessárias para continuar
        $get_profile_stmt = $db->prepare("SELECT id, name, picture_file, gender, gender_identity, is_escort, price, contact FROM user WHERE id = ?");
        $get_profile_stmt->execute(array($_POST['target_id']));
        $profile = $get_profile_stmt->fetchAll()[0];
        $is_friend = false;
        if (isset($_SESSION['user_id'])){
            $check_friends = $db->prepare('SELECT COUNT(*) FROM friends WHERE (client_id = ? AND escort_id = ?) OR (client_id = ? AND escort_id = ?)');
            $check_friends->execute(array($_POST['target_id'], $_SESSION['user_id'], $_SESSION['user_id'], $_POST['target_id']));
            $is_friend = $check_friends->fetch(PDO::FETCH_NUM)[0];
        }
        if (!$is_friend){
            $profile['contact'] = null;
        }
        echo json_encode(array('success' => true, 'msg' => null, profile => $profile));
    }

}
catch (\Exception $e){
    echo json_encode(array('success' => false, 'msg' => $e->getMessage(), profile => null));
}

$db = null; // desliga a conexão
?>