function adicionar_regiao(){
	$.post("../../Controller/update_region.php", {
		func: 'add',
		estado: $("#new-region-estado").val(),
		regiao: $("#new-region-regiao").val()
	})
		.done(function (data) {
			console.log(data);
			location.reload(true);
		});
}

$.post("../../Controller/get_regions.php", {}).done(function(data){
	let response = JSON.parse(data);
	if(response['success']){
		for(let i = 0; i < response['msg'].length; i++){
			let aux_str = "<div><input type='text' maxlength='2' minlength='2' id='new-region-estado-" + response['msg'][i]['region_id'] + "' style='width: 2em' value='" + response['msg'][i]['estado'] + "'/>\n" +
				"<input type='text' id='new-region-regiao-" + response['msg'][i]['region_id'] + "' value='" + response['msg'][i]['regiao'] + "'/>\n" +
				"</div><div>" +
				"<button class='botao botao-medio' onclick='atualizar_regiao(" + response['msg'][i]['region_id'] + ")' id='atualizarRegiao'>Atualizar região</button>\n" +
				"<button class='botao botao-medio' onclick='remover_regiao(" + response['msg'][i]['region_id'] + ")' id='removerRegiao'>Remover região</button></div>";
			$("#region-list").append(aux_str)
		}
	}
})

function atualizar_regiao(id){
	let new_estado = "#new-region-estado-" + id;
	let new_region = "#new-region-regiao-" + id;

	$.post("../../Controller/update_region.php", {
		func: 'change',
		region_id: id,
		estado: $(new_estado).val(),
		regiao: $(new_region).val()
	}).done(function (data) {
		console.log(data);
		location.reload(true);
	});
}