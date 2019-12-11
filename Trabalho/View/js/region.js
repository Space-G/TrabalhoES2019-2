function adicionar_regiao(){
	$.post("../../Controller/add_region.php", {
		estado: $("#new-region-estado").val(),
		regiao: $("#new-region-regiao").val()
	})
		.done(function (data) {
			console.log(data);
			location.reload(true);
		});
}