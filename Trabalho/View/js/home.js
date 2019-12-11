$.post('../../Controller/is_logged_in.php').done(function(data){
	let response = JSON.parse(data);
	if(!response['logged_in']) {
		document.location.href = 'login.html';
	} else{
		document.cookie = ("user_id=" + response['user_id']);
		secret(response['user_id']);
	}
});

function my_profile(){
	document.cookie = ("profile_id=" + getCookie('user_id'));
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

function getCookie(cname) {
	var name = cname + "=";
	var decodedCookie = decodeURIComponent(document.cookie);
	var ca = decodedCookie.split(';');
	for (var i = 0; i < ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == ' ') {
			c = c.substring(1);
		}
		if (c.indexOf(name) == 0) {
			return c.substring(name.length, c.length);
		}
	}
	return "";
}