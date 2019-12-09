<!--Interface responsável pela comunicação com o banco de dados em operações relacionadas à tabela dates-->
<?php
class datesDAO{
	function __construct(){}

//	cria um date dado os ids dos usuários, o dia do encontro, e a região em que o encontro ocorrerá
	function create_date($user1, $user2, $day, $region, $connection){
		$date = $connection->prepare("INSERT INTO dates(user1, user2, day, region) VALUES (?, ?, ?, ?)");
		return $date->execute(array($user1, $user2, $day, $region));
	}

//	lista todos os dates de um usuário especificado em ordem cronológica
	function get_dates($user, $connection){
		$dates_stmt = $connection->prepare("SELECT * FROM dates WHERE (user1 = ?) OR (user2 = ?) ORDER BY day");
		if($dates_stmt->execute(array($user, $user))){
			return $dates_stmt->fetchAll();
		} else{
			throw new Exception("Algo deu errado ao executar linha 15 do arquivo datesDAO.php");
		}
	}

//	lista TODOS os dates
	function get_all_dates($connection){
		return $connection->query("SELECT * FROM dates");
	}

//	atualiza date alvo
	function update_date($id, $user1, $user2, $region, $day, $connection){
		$date = $connection->prepare("UPDATE dates SET user1 = ?, user2 = ?, region = ?, day = ? WHERE id = ?");
		return $date->execute(array($user1, $user2, $region, $day, $id));
	}

//	remove date
	function delete_date($id, $connection){
		$date = $connection->prepare("DELETE FROM dates WHERE id = ?");
		return $date->execute(array($id));
	}
}