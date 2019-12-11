function adicionar_date(){
	$.post("../../Controller/update_date.php", {
		func: 'add',
		add_date_id1: $("#add-date-id1").val(),
		add_date_id2: $("#add-date-id2").val(),
		add_date_data: $("#add-date-data").val(),
		add_date_regiao: $("#add-date-regiao").val()
	})
		.done(function (data) {
			console.log(data);
			// location.reload(true);
		});
}

$.post("../../Controller/list_profiles.php", {}).done(function(data){
	let response = JSON.parse(data)[0];
	// console.log(response);
	for(let i = 0; i < response.length; i++){
		let aux_str = "<div class='inline'>\n" +
			"<div style='background-image: url(../img/" + response[i]['picture_file'] + ");background-size: cover;background-repeat: no-repeat;width: 145px;height: 145px;background-position: center;'></div>\n" +
			"<p>#" + response[i]['id'] + "</p>\n" +
			"<p>" + response[i]['name'] + "</p>\n" +
			"<p>";

		if(response[i]['gender'].toLowerCase() == "masculino"){
			aux_str = aux_str +'♂ ';
		}else if (response[i]['gender'].toLowerCase() == "feminino"){
			aux_str = aux_str + '♀ ';
		}else{
			aux_str = aux_str + '⚲ ';
		}

		aux_str = aux_str +  response[i]['gender_identity'] + " </p>\n" +
			"</div>";
		$("#colocar-perfis-aqui").append(aux_str);
	}
});

$.post('../../Controller/get_regions.php').done(function (data){
	let response = JSON.parse(data);
	if (response['success']){
		for (let i = 0; i < response['msg'].length; i++){
			$('#add-date-regiao').append('<option value="' + response['msg'][i]['region_id'] + '">' + response['msg'][i]['estado'] + ' - ' + response['msg'][i]['regiao'] + '</option>');
		}
	}
});