function update_profile() {
	var form = "<form action='../src/update_profile.php' method='post'>" +
		"\n<input type='hidden' name='name' value='" + $("#nome").val() + "'>" +
		"\n<input type='hidden' name='cpf' value='" + $("#cpf").val() + "'>" +
		"\n<input type='hidden' name='gender' value='" + $("#genero :selected").val() + "'>" +
		"\n<input type='hidden' name='gender_identity' value='" + $("#id-genero :selected").val() + "'>" +
		"\n<input type='hidden' name='email' value='" + $("#email").val() + "'>" +
		"\n<input type='hidden' name='password' value='" + $("#senha").val() + "'>" +
		"\n<input type='hidden' name='contact' value='" + $("#contato").val() + "'>" +
		"\n<input type='hidden' name='region' value='" + $("#regiao").val() + "'>" +
		"\n<input type='hidden' name='price' value='" + $("#preco").val() + "'>" +
		"\n<input type='hidden' name='is_escort' value='" + $("input[name=\"tipo-usuario\"]").val() + "'>" +
		"\n<input type='hidden' name='fetish' value='" ;

	let i = 0;
	$("input[name=\"fetiche-box\"]:checked").each(function () {
		i++;
		if(i > 1) {
			form = form + ',';
		}
		form = form + $(this).val();
	})

	form = form + "'>" + "\n</form>";

	// console.log(form);
	$(form).appendTo('body').submit();
}

function hide_price(hide) {
	if (hide){
		$("#preco_div").attr('hidden', true);
		$("#offered-fetish").attr('hidden', true);
		$("#desired-fetish").removeAttr('hidden');
	} else{
		$("#preco_div").removeAttr('hidden');
		$("#desired-fetish").attr('hidden', true);
		$("#offered-fetish").removeAttr('hidden');
	}
}

$.post('../src/get_regions.php').done(function (data){
	let response = JSON.parse(data);
	if (response['success']){
		for (let i = 0; i < response['msg'].length; i++){
			$('#regiao').append('<option value="' + response['msg'][i]['region_id'] + '">' + response['msg'][i]['estado'] + ' - ' + response['msg'][i]['regiao'] + '</option>');
		}
	}
});