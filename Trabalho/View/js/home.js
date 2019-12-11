$.post('../../Controller/is_logged_in.php').done(function(data){
	let response = JSON.parse(data);
	if(!response['logged_in']) {
		document.location.href = 'login.html';
	} else{
		document.cookie = ("profile_id=" + response['user_id']);
		secret(response['user_id']);
	}
});

function my_profile(){
	document.location.href = 'perfil.html';
}

function secret(user_id) {
	$.post("../../Controller/get_profile.php", {target_id: user_id})
		.done(function (data) {
			console.log(data);
			let response = JSON.parse(data);
			if(response['profile']['is_admin'] == 1){
				$("#main-button").attr('href','admin.html')
			}
		});
}

