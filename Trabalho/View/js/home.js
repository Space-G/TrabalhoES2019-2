$.post('../../Controller/is_logged_in.php').done(function(data){
	let response = JSON.parse(data);
	if(!response['logged_in']) {
		document.location.href = 'login.html';
	} else{
		document.cookie = ("profile_id=" + response['user_id']);
	}
});

function my_profile(){
	document.location.href = 'perfil.html';
}

