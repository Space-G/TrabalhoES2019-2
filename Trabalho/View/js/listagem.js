$.post("../../Controller/list_profiles.php", {}).done(function(data){
	let response = JSON.parse(data)[0];
	// console.log(response);
	for(let i = 0; i < response.length; i++){
		let aux_str = "<a onclick='check_profile(" + response[i]['id'] + ")'><div class='inline'>\n" +
			"<div style='background-image: url(../img/" + response[i]['picture_file'] + ");background-size: cover;background-repeat: no-repeat;width: 145px;height: 145px;background-position: center;'></div>\n" +
			"<p>" + response[i]['name'] + "</p>\n" +
			"<p class='simbolo'>";

		if(response[i]['gender'].toLowerCase() == "masculino"){
			aux_str = aux_str +'♂ ';
		}else if (response[i]['gender'].toLowerCase() == "feminino"){
			aux_str = aux_str + '♀ ';
		}else{
			aux_str = aux_str + '⚲ ';
		}

		aux_str = aux_str +  response[i]['gender_identity'] + " </p>\n" +
			"</div></a>";
		if (response[i]['is_escort'] == 1) {
			$("#colocar-perfis-aqui").append(aux_str);
		}
	}
});

function check_profile(id){
	document.cookie = ("profile_id=" + id);
	document.location.href = 'perfil.html';
}