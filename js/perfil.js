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

function esconder_botoes( response ){
	// 'id', 'is_friend', 'request_exists', is_escort
	if (response['profile']['id'] == response['user']['id']){
		$("#but0").removeAttr('hidden');
		$('#pfp').on('click', function() {
			$('#file').trigger('click');
		});
	} else if(response['user']['is_friend'] == true){
		$("#but3").removeAttr('hidden');
	} else if(response['profile']['is_escort'] == false && response['user']['request_exists'] == true){
		$("#but2").removeAttr('hidden');
	} else if(response['user']['request_exists'] == false && response['profile']['is_escort'] == true && response['user']['is_escort'] == false){
		$("#but1").removeAttr('hidden');
	}
}

function preencher_coisas(perfil){
	// id, name, picture_file, gender, gender_identity, is_escort, price, contact
	$('#nome').text('Nome: ' + perfil['name']);
	$('#sexo').text(perfil['gender'] + ' ' + perfil['gender_identity']);
	if (perfil['picture_file'] != null) {
		$('#img').attr('src', ('../img/' + perfil['picture_file']));
	} else{
		$('#img').attr('src',('../img/null.jpg'));
	}
}

$.post("../src/get_profile.php", {target_id: getCookie('profile_id')})
.done( function ( data ) {
	console.log(data);
	let response = JSON.parse(data);
	esconder_botoes( response );
	preencher_coisas( response['profile'] );
});

$.post("../src/get_ratings.php", {target_id: getCookie('profile_id')})
	.done( function ( data ) {
		console.log(data);
		let response = JSON.parse(data);
		$('#nota').text(response['msg']);
	});