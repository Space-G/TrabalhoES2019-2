function adicionar_date() {
	if ($("#add-date-id1").val().length > 0 && $("#add-date-id2").val().length > 0){
		$.post("../../Controller/update_date.php", {
			func: 'add',
			add_date_id1: $("#add-date-id1").val(),
			add_date_id2: $("#add-date-id2").val(),
			add_date_data: $("#add-date-data").val(),
			add_date_regiao: $("#add-date-regiao").val()
		})
			.done(function (data) {
				console.log(data);
				if (data != 1) {
					alert(data);
				} else {
					location.reload(true);
				}
			});
	} else{
		alert("Insira os IDs");
	}
}

function get_friends() {
	$.post("../../Controller/request_handler.php", {
		func: "get_friends"
	}).done(function (data) {
		// console.log(data);
		// location.reload(true);
		let response = JSON.parse(data);

		for (let i = 0; i < response.length; i++) {
			let aux_key = 'escort_id';
			console.log(getCookie('is_escort'));
			if (getCookie("is_escort") == 1) {
				aux_key = 'client_id';
			}
			$.post("../../Controller/get_profile.php", {target_id: response[i][aux_key]}).done(function (new_data) {
				console.log(new_data);
				let this_response = JSON.parse(new_data)['profile'];
				let aux_str = "<div class='inline'>\n" +
					"<div style='background-image: url(../img/" + this_response['picture_file'] + ");background-size: cover;background-repeat: no-repeat;width: 145px;height: 145px;background-position: center;'></div>\n" +
					"<p class='negrito'>#" + this_response['id'] + "</p>" +
					"<p>" + this_response['name'] + "</p>\n" +
					"<p class='simbolo'>";

				if (this_response['gender'].toLowerCase() == "masculino") {
					aux_str = aux_str + '♂ ';
				} else if (this_response['gender'].toLowerCase() == "feminino") {
					aux_str = aux_str + '♀ ';
				} else {
					aux_str = aux_str + '⚲ ';
				}

				aux_str = aux_str + this_response['gender_identity'] + " </p>\n" +
					"</div>";
				$("#colocar-perfis-aqui").append(aux_str);
			});
		}
	})
}


function get_regions(){
	$.post('../../Controller/get_regions.php').done(function (data){
		let response = JSON.parse(data);
		if (response['success']){
			for (let i = 0; i < response['msg'].length; i++){
				$("[name='region-dropdown']").append("<option value='" + response['msg'][i]['region_id'] + "'>" + response['msg'][i]['estado'] + ' - ' + response['msg'][i]['regiao'] + '</option>');
			}
		}
	});
}

function preencher_coisas(){
	let response = joao;
	for(let i = 0; i < response.length; i++) {
		let this_response = response[i];
		let aux_str = "#edit_date_regiao_" + this_response['id'] +" > option";
		$(aux_str).each(function(){
			if($(this).val() == this_response['region']){
				$(this).attr('selected', 'selected');
			}
		});
	}
	$("#add-date-id1").val(getCookie('user_id'));
	$("input[value = '" + getCookie('user_id') + "']").attr("hidden", "hidden");
}

var joao;

function atualizar_date(id) {
	$.post("../../Controller/update_date.php", {
		func: 'update',
		date_id: id,
		user_id1: $("#edit-date-user1-" + id).val(),
		user_id2: $("#edit-date-user2-" + id).val(),
		date_data: $("#edit-date-data-" + id).val(),
		date_regiao: $("#edit_date_regiao_" + id).val()
	}).done(function (data) {
		console.log(data);
		location.reload(true);
	});
}

function remover_date(id){
	$.post("../../Controller/update_date.php", {
		func: 'delete',
		date_id: id
	}).done(function (data) {
		console.log(data);
		location.reload(true);
	});
}

$.post("../../Controller/get_dates.php", {}).done(function(data){
	let response = JSON.parse(data);
	joao = response;
	for(let i = 0; i < response.length; i++){
		let this_response = response[i];
		let aux_str = "<form id='edit-date-" + this_response['id'] + "'>\n" +
			"<input type='text' maxlength='4' minlength='1' id='edit-date-user1-" + this_response['id'] + "' style='width: 2em' placeholder='ID' value='" + this_response['user1'] + "'/>\n" +
			"<input type='text' maxlength='4' minlength='1' id='edit-date-user2-" + this_response['id'] + "' style='width: 2em' placeholder='ID' value='" + this_response['user2'] + "'/>\n" +
			"<input type='date' id='edit-date-data-" + this_response['id'] + "' value='" + this_response['day'] + "'/>\n" +
			"<select id='edit_date_regiao_" + this_response['id'] + "' name='region-dropdown'>\n" +
			"</select></form><div>\n" +
			"<button class='botao botao-medio' onclick='atualizar_date(" + this_response['id'] + ")' id='atualizar_date_" + this_response['id'] + "'>Atualizar date</button>\n" +
			"<button class='botao botao-medio' onclick='remover_date(" + this_response['id'] + ")' id='remover_date_" + this_response['id'] + "'>Remover date</button>\n" +
			"</div>";
		$("#div_date").append(aux_str);
	}
	get_regions();

	// favor ignorar
	setTimeout(preencher_coisas, 200);
	setTimeout(preencher_coisas, 500);
	setTimeout(preencher_coisas, 1000);
	setTimeout(preencher_coisas, 10000);
});


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

get_friends();