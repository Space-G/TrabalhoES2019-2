$.post('../src/search.php', { gender => '', gender_identity => ''}).done(function(data){
	let response = JSON.parse(data);
	let escorts = response['escorts'];

	for (let i = 0; i < escorts.length; i++){
		$('#result').append("<a onclick='set_cookie(" + escorts[i]['id'] + ")'><img width='50%' src='../img/" + escorts[i]['picture_file'] + "'></a><p>" + escorts[i]['name'] + "</p>")
	}
})

function set_cookie(cookie){

}