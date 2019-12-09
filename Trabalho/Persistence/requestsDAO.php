<?php
// Lida com requisições de amizade
class requestsDAO{
	function __construct(){}

//	cria uma solicitação de amizade
	function create_request($user_id, $target_id, $connection){
		$check_validity = $connection->prepare('SELECT count(*) FROM user WHERE (id = ? AND is_escort = false) OR (id = ? AND is_escort = TRUE)');
		$check_validity->execute(array($user_id, $target_id));
		$check_validity = $check_validity->fetch(PDO::FETCH_NUM)[0];
		if($check_validity == 2){
			$request = $connection->prepare('INSERT INTO requests(client_id, escort_id) VALUES (?, ?)');
			return $request->execute(array($user_id, $target_id));
		} else{
			return false;
		}
	}

//	aceita uma solicitação de amizade
	function accept_request($user_id, $target_id, $connection){
		try{
			$connection->beginTransaction();
			$remove_request = $connection->prepare("DELETE FROM requests WHERE escort_id = ? AND client_id = ?");
			$remove_request->execute(array($user_id, $target_id));
			if($remove_request->rowCount() == 1){
				$insert_friend = $connection->prepare("INSERT INTO friends(client_id, escort_id) VALUEs (?, ?)");
				if($insert_friend->execute(array($target_id, $user_id))){
					$connection->commit();
				}else{
					throw new Exception('Couldn\'t add to friends table');
				}
			} else{
				throw new Exception('No row deleted on requests table');
			}
		}catch (\Exception $e){
			if($connection->inTransaction()){
				$connection->rollBack();
			}
			throw $e;
		}
	}

//	seleciona todos requests que o usuário recebeu
	function get_requests($user_id, $connection){
		$requests = $connection->prepare("SELECT * FROM requests WHERE escort_id = ?");
		$requests = $connection->execute(array($user_id));
		return $requests->fetchAll();
	}
}