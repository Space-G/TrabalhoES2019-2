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

$.post("../../Controller/request_handler.php", {
	func: "get_requests"
}).done(function(data){
	// console.log(data);
	// location.reload(true);
	let response = JSON.parse(data);

	for(let i = 0; i < response.length; i++){
		$.post("../../Controller/get_profile.php", {target_id: response[i]['client_id']}).done(function(new_data){
			console.log(new_data);
			let this_response = JSON.parse(new_data)['profile'];
			let aux_str = "<a onclick='check_profile(" + this_response['id'] + ")'><div class='inline'>\n" +
				"<div style='background-image: url(../img/" + this_response['picture_file'] + ");background-size: cover;background-repeat: no-repeat;width: 145px;height: 145px;background-position: center;'></div>\n" +
				"<p>" + this_response['name'] + "</p>\n" +
				"<p class='simbolo'>";

			if(this_response['gender'].toLowerCase() == "masculino"){
				aux_str = aux_str +'♂ ';
			}else if (this_response['gender'].toLowerCase() == "feminino"){
				aux_str = aux_str + '♀ ';
			}else{
				aux_str = aux_str + '⚲ ';
			}

			aux_str = aux_str +  this_response['gender_identity'] + " </p>\n" +
				"</div></a>";
			$("#notif").append(aux_str);
		});
	}
})

function check_profile(id){
	document.cookie = ("profile_id=" + id);
	document.location.href = 'perfil.html';
}