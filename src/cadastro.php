<?php
$db = new PDO('mysql:host=127.0.0.1;dbname=gabriels_picker;charset=utf8', "gp", 'gp');
$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); // isso é extremamente importante pra debugar

//header('Content-Type: application/json');

session_start();
try {
    $insertUser   = $db->prepare('INSERT INTO user( name,  email,  password_hash,  cpf,  gender,  gender_identity,  contact,  region,  is_escort, price) 
                                                 VALUES (:name, :email, :password_hash, :cpf, :gender, :gender_identity, :contact, :region, :is_escort, :price)');
    $insertFetish = $db->prepare('INSERT INTO user_fetishes( id,  fetish) VALUES (:id, :fetish)');
    $userID_stmt = $db->prepare('SELECT id FROM user WHERE email=?');

    $db->beginTransaction();

    $password = hash('sha512', $_POST['password']);
    $insertUser->execute(array(':name' => $_POST['name'], ':email' => $_POST['email'], ':password_hash' => $password, ':cpf' => $_POST['cpf'], ':gender' => $_POST['gender'], ':gender_identity' => $_POST['gender_identity'], ':contact' => $_POST['contact'], ':region' => $_POST['region'], ':is_escort' => $_POST['is_escort'], ':price' => $_POST['price']));

    $userID_stmt->execute(array($_POST['email']));
    $usrID = $userID_stmt->fetch(PDO::FETCH_NUM)[0];

    $insertFetish->execute(array(':id' => $usrID, ':fetish' => $_POST['fetish']));

    $db->commit();

    echo "Sucesso!
    <script type='text/javascript'>
    function red(){
           window.location.href = '../Views/login.html';
    }
    
    setTimeout(red, 3000);
    </script>";
}
catch (\Exception $e){
    if ($db->inTransaction()){
        $db->rollBack();
    }

    echo json_encode(array('success' => false, 'msg' => $e->getMessage()));
}

$db = null; // desliga a conexão
?>
