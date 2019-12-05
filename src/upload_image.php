<?php
$target_dir = "ProfilePics/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

$db = new PDO('mysql:host=127.0.0.1;dbname=gabriels_picker;charset=utf8', "gp", 'gp');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // isso é extremamente importante pra debugar


session_start();
function redirect_to_error(){
    echo '<script>window.location.href = "error.html";</script>';
}

try{
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

        if (move_uploaded_file($_FILES["file"]["tmp_name"], "../img/" . $newfilename)) { // faz o upload

            $old_file_stmt = $db->prepare('SELECT picture_file FROM user WHERE id = ?');
            $old_file_stmt->execute(array($_SESSION['user_id']));
            $old_file = $old_file_stmt->fetch(PDO::FETCH_NUM);

            $old_filepath = '../img/'.$old_file;

            unlink($old_filepath);

            $update_user_table_stmt = $db->prepare('UPDATE user SET picture_file = ? WHERE id = ?');
            $update_user_table_stmt->execute(array($newfilename, $_SESSION['user_id']));

            echo '<script>window.location.href = "../Views/perfil.html";</script>';
        } else {
            redirect_to_error();
        }
    }
} catch(\Exception $e){
    echo $e->getMessage();
}
?>
