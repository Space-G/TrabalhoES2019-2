<?php
$db = new PDO('mysql:host=localhost;dbname=gabriels_picker;charset=utf8', "gp","gp");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // isso é extremamente importante pra debugar

//header('Content-Type: application/json');
if (!isset($_SESSION)){
session_start();}
try {
	if (isset($_POST)) { // checa se tem informações necessárias para continuar
		$get_profile_stmt = $db->prepare("SELECT id, name, picture_file, gender, gender_identity, is_escort, price, contact FROM user WHERE id = ?");
		$get_profile_stmt->execute(array($_POST['target_id']));
		$profile = $get_profile_stmt->fetchAll()[0];
		$is_friend = false;
		$request_already_sent_stmt = $db->prepare('SELECT COUNT(*) FROM requests WHERE client_id = ? AND escort_id = ?');
		$request_already_sent_stmt->execute(array($_SESSION['user_id'], $_POST['target_id']));
		$request_already_sent = $request_already_sent_stmt->fetch(PDO::FETCH_NUM)[0];
		$user_is_escort = null;
		if (isset($_SESSION['user_id'])) {
			$check_friends = $db->prepare('SELECT COUNT(*) FROM friends WHERE (client_id = ? AND escort_id = ?) OR (client_id = ? AND escort_id = ?)');
			$check_friends->execute(array($_POST['target_id'], $_SESSION['user_id'], $_SESSION['user_id'], $_POST['target_id']));
			$is_friend = $check_friends->fetch(PDO::FETCH_NUM)[0];

			$user_is_escort_stmt = $db->prepare('SELECT is_escort FROM user WHERE id = ?');
			$user_is_escort_stmt->execute(array($_SESSION['user_id']));

			$user_is_escort = $user_is_escort_stmt->fetch(PDO::FETCH_NUM)[0];
		}
		if (!$is_friend) {
			$profile['contact'] = "Você não é amigo da pessoa";
		}
		$user = array('id' => $_SESSION['user_id'], 'is_friend' => $is_friend, 'request_exists' => $request_already_sent, 'is_escort' => $user_is_escort);
		echo json_encode(array('success' => true, 'msg' => null, 'profile' => $profile, 'user' => $user));
	}

} catch (\Exception $e) {
	echo json_encode(array('success' => false, 'msg' => $e->getMessage(), 'profile' => null, 'user' => null));
}

$db = null; // desliga a conexão
?>