<?php

include_once "./Controller/session_start.php";
include_once "./Persistence/db_connection.php";
include_once "./Persistence/profileDAO.php";

$db = new db_connection();
$db = $db->conectar();

$profileDAO = new profileDAO();

try{
	$target_dir = "img/";
	$target_file = $target_dir . basename($_FILES["file"]["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

	if(isset($_POST["submit"])) { // checa imagens fake
		$check = getimagesize($_FILES["file"]["tmp_name"]);
		if($check !== false) {
			$uploadOk = 1;
		} else {
			$uploadOk = 0;
		}
	}

	if ($_FILES["file"]["size"] > 8388608) {$uploadOk = 0;} // size máximo da imagem: 8MB

	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {$uploadOk = 0;}

	if ($uploadOk == 0) {
		redirect_to_error();
	} else {

		$temp = explode(".", $_FILES["file"]["name"]);
		$newfilename = round(microtime(true)) . '.' . end($temp); // dá nome de acordo com o tempo de upload

		if (move_uploaded_file($_FILES["file"]["tmp_name"], "./View/img/" . $newfilename)) { // faz o upload
			$profileDAO->add_picture($_SESSION['user_id'], $newfilename, $db);

			echo '<script>window.location.href = "./View/html/perfil.html";</script>';
		} else {
			echo "Error";
		}
	}
} catch(\Exception $e){
	echo $e->getMessage();
}
?>