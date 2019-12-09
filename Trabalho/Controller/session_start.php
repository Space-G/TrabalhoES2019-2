<?php
// Assegura que sessão seja iniciada apropriadamente
	try{
		if(!isset($_SESSION)) {
			session_start();
		} elseif(empty($_SESSION)){
			session_start();
		}
} catch (\Exception $e){
		die(json_encode(array('success' => false, 'msg' => $e->getMessage())));
	}
?>