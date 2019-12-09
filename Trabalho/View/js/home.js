function my_profile(){
	$.post('../../Controller/is_logged_in.php').done(function(data){
		let response = JSON.parse(data);
		if(response['logged_in']) {
			document.cookie = ("profile_id=" + response['user_id']);
			document.location.href = 'perfil.html';
		} else{
			document.location.href = 'login.html';
		}
	});
}

