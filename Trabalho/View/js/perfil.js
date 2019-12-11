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

var contato = "";

function esconder_botoes( response ){
	// 'id', 'is_friend', 'request_exists', is_escort
	if (response['profile']['id'] == response['user']['id']){
		$("#but0").removeAttr('hidden');
		$('#pfp').on('click', function() {
			$('#file').trigger('click');
		});
	} else if(response['user']['is_friend'] == 1){
		$("#but3").removeAttr('hidden');
		contato = response['profile']['contact'];
	} else if(response['profile']['is_escort'] == 0 && response['user']['request_exists'] == 1){
		$("#but2").removeAttr('hidden');
	} else if(response['user']['request_exists'] == 0 && response['profile']['is_escort'] == 1 && response['user']['is_escort'] == 0){
		$("#but1").removeAttr('hidden');
	}
}

function preencher_coisas(perfil){
	// id, name, picture_file, gender, gender_identity, is_escort, price, contact
	$('#nome').text( perfil['name']);
	$('#sexo').text(perfil['gender'] + ' ' + perfil['gender_identity']);
	if (perfil['picture_file'] != null) {
		$('#img').attr('src', ('../img/' + perfil['picture_file']));
	} else{
		$('#img').attr('src',('../img/null.jpg'));
	}
}

$.post("../../Controller/get_profile.php", {target_id: getCookie('profile_id')})
.done( function ( data ) {
	let response = JSON.parse(data);
	console.log(response);
	esconder_botoes( response );
	preencher_coisas( response['profile'] );
});

function solicitar_acompanhante(){
	$.post("../../Controller/request_handler.php", {
		func: "add",
		target_id: getCookie('profile_id')
	}).done(function(data){
		console.log(data);
		location.reload(true);
		})
}

function aceitar_solicitacao(){
	$.post("../../Controller/request_handler.php", {
		func: "accept",
		target_id: getCookie('profile_id')
	}).done(function(data){
		console.log(data);
		location.reload(true);
	})
}

function visualizar_contato(){
	alert(contato);
}