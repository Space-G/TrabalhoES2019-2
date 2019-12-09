<?php
// Confere informações do login
class loginDAO{
	function __construct(){}

//	checa validade do e-mail
	function check($email, $password, $connection){
		$login_stmt = $connection->prepare('SELECT password_hash, id, is_admin FROM user WHERE email = ?');
		$login_stmt->execute(array($email));
		$login_select = $login_stmt->fetch(PDO::FETCH_NUM);

		if (!is_null($email) && !is_null($password)){
			if (!empty($login_select)){
				$password_hash = hash('sha512', $password);
				if($password_hash === $login_select[0]){
					return true;
				} else{
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

//	busca o id do email informado
	function search_email($email, $connection){
		$login_stmt = $connection->prepare('SELECT id FROM user WHERE email = ?');
		$login_stmt->execute(array($email));
		return $login_stmt->fetch(PDO::FETCH_NUM)[0];
	}

//	checa se usuário é adm
	function is_adm($id, $connection){
		$login_stmt = $connection->prepare('SELECT is_admin FROM user WHERE id = ?');
		$login_stmt->execute(array($id));
		return $login_stmt->fetch(PDO::FETCH_NUM);
	}
}