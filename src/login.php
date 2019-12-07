<?php
$db = new PDO('mysql:host=127.0.0.1;dbname=gabriels_picker;charset=utf8', "gp", 'gp');
$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); // isso é extremamente importante pra debugar

try{
	if(!isset($_SESSION)) {
		session_start();
	} elseif(empty($_SESSION)){
		session_start();
	}
} catch (\Exception $e){}
$login_stmt = $db->prepare('SELECT password_hash, id FROM user WHERE email = ?');
$login_stmt->execute(array($_POST['email']));
$login_select = $login_stmt->fetch(PDO::FETCH_NUM);

//header('Content-Type: application/json');

if (!empty($_POST['email']) && !empty($_POST['password'])){
    if (!empty($login_select)){
        $password = hash('sha512', $_POST['password']);
        if($password === $login_select[0]){
            session_start(['cookie_lifetime' => 86400]); // cookie expira em 1 dia
            $_SESSION['user_id'] = $login_select[1];
            echo json_encode(array('success' => true, 'msg' => null));
        } else{
            echo json_encode(array('success' => false, 'msg' => 'credentials'));
        }
    }else{
        echo json_encode(array('success' => false, 'msg' => 'credentials'));
    }
}else{
    echo json_encode(array('success' => false, 'msg' => 'empty'));
}

?>
