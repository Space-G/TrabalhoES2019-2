<?php

include_once "session_start.php";
include_once "../Persistence/db_connection.php";
include_once "../Persistence/profileDAO.php";

$db = new db_connection();
$db = $db->conectar();

$profileDAO = new profileDAO();

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$cpf = $_POST['cpf'];
$gender = $_POST['gender'];
$gender_id = $_POST['gender_id'];
$contact = $_POST['contact'];
$region = $_POST['region'];
$is_escort = $_POST['is_escort'];
$price = $_POST['price'];

if($profileDAO->create_profile($name, $email, $password, $cpf, $gender, $gender_id, $contact, $region, $is_escort, $price, $db)){
	echo "Sucesso!
	<script type='text/javascript'>
	function red(){
		   window.location.href = '../View/login.html';
	}
	
	setTimeout(red, 3000);
	</script>";
} else{
	echo "Informações inválidas
	<script type='text/javascript'>
	function red(){
		   window.location.href = '../View/cadastro.html';
	}
	
	setTimeout(red, 3000);
	</script>\";";
}
?>