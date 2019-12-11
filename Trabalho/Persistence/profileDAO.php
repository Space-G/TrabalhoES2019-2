<?php
// Realiza ações do usuário
class profileDAO{
	function __construct(){}

//	cadastra usuário
	function create_profile($name, $email, $password, $cpf, $gender, $gender_id, $contact, $region, $is_escort, $price, $connection){
		$insert_user = $connection->prepare('INSERT INTO user( name,  email,  password_hash,  cpf,  gender,  gender_identity,  contact,  region,  is_escort, price) 
                                                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
		$password_hash = hash('sha512', $password);
		$check_availability = $connection->prepare('SELECT COUNT(*) FROM user WHERE email = ? OR cpf = ?');
		$check_availability->execute(array($email, $cpf));
		$check_availability = $check_availability->fetch(PDO::FETCH_NUM)[0];
		if($check_availability == 0){
			return $insert_user->execute(array($name, $email, $password_hash, $cpf, $gender, $gender_id, $contact, $region, $is_escort, $price));
		}else{
			return false;
		}
	}

//	atualiza usuário usando seu cpf de base
	function update_profile($user_id, $name, $email, $password, $gender, $gender_id, $contact, $region, $is_escort, $price, $connection){
		$update_user = $connection->prepare('UPDATE user SET 
                name = :name, 
                email = :email, 
                password_hash = :password_hash, 
                gender = :gender, 
                gender_identity = :gender_identity, 
                contact = :contact, 
                region = :region, 
                is_escort = :is_escort, 
                price = :price WHERE id = :id');
		$password_hash = hash('sha512', $password);
		return $update_user->execute( array(
			':name' => $name,
			':email' => $email,
			':password_hash' => $password_hash,
			':gender' => $gender,
			':gender_identity' => $gender_id,
			':contact' => $contact,
			':region' => $region,
			':is_escort' => $is_escort,
			':price' => $price,
			':id' => $user_id) );
	}

//	busca perfil com base no id
	function get_profile($profile_id, $connection){
		$profile = $connection->prepare("SELECT id, name, picture_file, email, gender, gender_identity, contact, price, is_escort, is_admin FROM user WHERE id = ?");
		$profile->execute(array($profile_id));
		return $profile->fetch();
	}

//	usuário dá nota a outro usuário
	function rate($user_id, $target_id, $score, $connection){
		$rating_already_exists_stmt = $connection->prepare('SELECT COUNT(*) FROM ratings WHERE rater_id = ? AND subject_id = ?');
		$rating_already_exists_stmt->execute(array($user_id, $target_id));
		$rating_already_exists = $rating_already_exists_stmt->fetch(PDO::FETCH_NUM)[0];

		if ($rating_already_exists == 1){ // atualizar rate ou criar novo?
			$update_rate = $connection->prepare('UPDATE ratings SET score = ? WHERE rater_id = ? AND subject_id = ?');
			$update_rate->execute(array($score, $user_id, $target_id));
		} else{
			$rate = $connection->prepare('INSERT INTO ratings(rater_id, subject_id, score) VALUES (?, ?, ?)');
			$rate->execute(array($user_id, $target_id, $score));
		}
	}

//	pega média das notas
	function get_rate($target_id, $connection){
		$rate = $connection->prepare('SELECT AVG(score) FROM ratings WHERE subject_id = ?');
		$rate->execute(array($target_id));
		return $rate->fetch(PDO::FETCH_NUM)[0];
	}

//	adiciona foto
	function add_picture($user_id, $picture_file, $connection){
		$add = $connection->prepare('UPDATE user SET picture_file = ? WHERE id = ?');
		$add->execute(array($picture_file, $user_id));
	}
}