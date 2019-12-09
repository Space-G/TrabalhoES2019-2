function visitar_perfil(){
	$.post('../src/get_own_id.php').done(function(data){
		let response = JSON.parse(data)['own_id'];
		document.cookie = ("profile_id=" + response);
		document.location.href = '../Views/perfil.html';
	});
}