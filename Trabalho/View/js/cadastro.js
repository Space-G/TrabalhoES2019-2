function cadastrar() {
	var form = "<form action='../../Controller/cadastro.php' method='post'>" +
		"\n<input type='hidden' name='name' value='" + $("#nome").val() + "'>" +
		"\n<input type='hidden' name='email' value='" + $("#email").val() + "'>" +
		"\n<input type='hidden' name='password' value='" + $("#senha").val() + "'>" +
		"\n<input type='hidden' name='cpf' value='" + $("#cpf").val() + "'>" +
		"\n<input type='hidden' name='gender' value='" + $("#genero :selected").val() + "'>" +
		"\n<input type='hidden' name='gender_id' value='" + $("#id-genero :selected").val() + "'>" +
		"\n<input type='hidden' name='contact' value='" + $("#contato").val() + "'>" +
		"\n<input type='hidden' name='region' value='" + $("#regiao").val() + "'>" +
		"\n<input type='hidden' name='is_escort' value='" + $("input[name=\"tipo-usuario\"]").val() + "'>" +
		"\n<input type='hidden' name='price' value='" + $("#preco").val() + "'>" +
		"\n</form>";

	// console.log(form);
	$(form).appendTo('body').submit();
}

function hide_price(hide) {
	if (hide){
		$("#preco_div").attr('hidden', true);
	} else{
		$("#preco_div").removeAttr('hidden');
	}
}

$.post('../../Controller/get_regions.php').done(function (data){
	let response = JSON.parse(data);
	if (response['success']){
		for (let i = 0; i < response['msg'].length; i++){
			$('#regiao').append('<option value="' + response['msg'][i]['region_id'] + '">' + response['msg'][i]['estado'] + ' - ' + response['msg'][i]['regiao'] + '</option>');
		}
	}
});