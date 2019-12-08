<!--Realiza ações do usuário-->
<?php
class profileDAO
{
	function __construct(){}

//	busca o id do email informado
	function search_email($email, $connection){
		$login_stmt = $connection->prepare('SELECT id FROM user WHERE email = ?');
		$login_stmt->execute(array($email));
		return $login_stmt->fetch(PDO::FETCH_NUM);
	}

//	busca perfil com base no id
	function get_profile($profile_id, $connection){
		$profile = $connection->prepare("SELECT id, name, picture_file, email, gender, gender_identity, contact, price, is_escort, is_admin FROM user WHERE id = ?");
		$profile->execute(array($profile_id));
		return $profile->fetch(PDO::FETCH_NUM)[0];
	}
}