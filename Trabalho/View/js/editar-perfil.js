function update_profile() {
	var form = "<form action='../../Controller/update_profile.php' method='post'>" +
		"\n<input type='hidden' name='name' value='" + $("#nome").val() + "'>" +
		"\n<input type='hidden' name='gender' value='" + $("#genero :selected").val() + "'>" +
		"\n<input type='hidden' name='gender_id' value='" + $("#id-genero :selected").val() + "'>" +
		"\n<input type='hidden' name='email' value='" + $("#email").val() + "'>" +
		"\n<input type='hidden' name='password' value='" + $("#senha").val() + "'>" +
		"\n<input type='hidden' name='contact' value='" + $("#contato").val() + "'>" +
		"\n<input type='hidden' name='region' value='" + $("#regiao").val() + "'>" +
		"\n<input type='hidden' name='price' value='" + $("#preco").val() + "'>" +
		"\n<input type='hidden' name='is_escort' value='" + $("input[name=\"tipo-usuario\"]").val() + "'>" +
		"\n</form>";

	// console.log(form);
	$(form).appendTo('body').submit();
}

function preencher_coisas(response){
	$("#nome").val(response['name']);

	$("#genero > option").each(function(){
		if($(this).val().toLowerCase() == response['gender'].toLowerCase()){
			$(this).attr('selected', 'selected');
		}
	});

	$("#id-genero > option").each(function(){
		if($(this).val().toLowerCase() == response['gender_identity'].toLowerCase()){
			$(this).attr('selected', 'selected');
		}
	});

	$("#email").val(response['email']);

	$("#contato").val(response['contact']);

	$("#regiao > option").each(function(){
		if($(this).val() == response['region']){
			$(this).attr('selected', 'selected');
		}
	});

	$("#preco").val(response['price']);

	if(response['is_escort'] == 1){
		$("#tipo-usuario-acompanhante").attr('checked', true);
		hide_price(false);
	}else{
		$("#tipo-usuario-cliente").attr('checked', true);
		hide_price(true);
	}
}

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
	get_profile();
});

function get_profile() {
	$.post("../../Controller/get_profile.php", {target_id: getCookie('profile_id')})
		.done(function (data) {
			console.log(data);
			let response = JSON.parse(data);
			preencher_coisas(response['profile']);
		});
}