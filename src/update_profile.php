<?php
$db = new PDO('mysql:host=localhost;dbname=gabriels_picker;charset=utf8', "root");
$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); // isso é extremamente importante pra debugar

//header('Content-Type: application/json');
session_start();
try {
	$update_user = $db->prepare('UPDATE user SET name = :name, email = :email, password_hash = :password_hash, cpf = :cpf, gender = :gender, gender_identity = :gender_identity, contact = :contact, region = :region, is_escort = :is_escort, price = :price WHERE id = :id');
	$update_fetish = $db->prepare('UPDATE user_fetishes SET fetish = :fetish WHERE id = :id');
	$db->beginTransaction();

	$password = hash('sha512', $_POST['password']);
	$update_user->execute( array(':name' => $_POST['name'],
		':email' => $_POST['email'],
		':password_hash' => $password,
		':cpf' => $_POST['cpf'],
		':gender' => $_POST['gender'],
		':gender_identity' => $_POST['gender_identity'],
		':contact' => $_POST['contact'],
		':region' => $_POST['region'],
		':is_escort' => $_POST['is_escort'],
		':price' => $_POST['price'],
		':id' => $_SESSION['user_id']) );

    $update_fetish->execute( array(':fetish' => $_POST['fetish'], ':id' => $_SESSION['user_id']));

    $db->commit();

    echo json_encode(array('success' => true, 'msg' => null));
}
catch (\Exception $e){
    if ($db->inTransaction()){
        $db->rollBack();
    }

    echo json_encode(array('success' => false, 'msg' => $e->getMessage()));
}

$db = null; // desliga a conexão
?>