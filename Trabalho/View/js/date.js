// function adicionar_date(){
// 	$.post("../../Controller/update_region.php", {
// 		func: 'add',
// 		estado: $("#new-region-estado").val(),
// 		regiao: $("#new-region-regiao").val()
// 	})
// 		.done(function (data) {
// 			console.log(data);
// 			location.reload(true);
// 		});
// }
//
// $.post("../../Controller/get_regions.php", {}).done(function(data){
// 	let response = JSON.parse(data);
// 	if(response['success']){
// 		for(let i = 0; i < response['msg'].length; i++){
// 			let aux_str = "<div><input type='text' maxlength='2' minlength='2' id='new-region-estado-" + response['msg'][i]['region_id'] + "' style='width: 2em' value='" + response['msg'][i]['estado'] + "'/>\n" +
// 				"<input type='text' id='new-region-regiao-" + response['msg'][i]['region_id'] + "' value='" + response['msg'][i]['regiao'] + "'/>\n" +
// 				"</div><div>" +
// 				"<button class='botao botao-medio' onclick='atualizar_date(" + response['msg'][i]['region_id'] + ")' id='atualizarRegiao'>Atualizar região</button>\n" +
// 				"<button class='botao botao-medio' onclick='remover_date(" + response['msg'][i]['region_id'] + ")' id='removerRegiao'>Remover região</button></div>";
// 			$("#region-list").append(aux_str)
// 		}
// 	}
// })
//
// function atualizar_date(id){
// 	let new_estado = "#new-region-estado-" + id;
// 	let new_region = "#new-region-regiao-" + id;
//
// 	$.post("../../Controller/update_region.php", {
// 		func: 'change',
// 		region_id: id,
// 		estado: $(new_estado).val(),
// 		regiao: $(new_region).val()
// 	}).done(function (data) {
// 		console.log(data);
// 		location.reload(true);
// 	});
// }
//
// function remover_date(id){
// 	$.post("../../Controller/update_region.php", {
// 		func: 'remove',
// 		region_id: id
// 	}).done(function (data) {
// 		console.log(data);
// 		location.reload(true);
// 	});
// }

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