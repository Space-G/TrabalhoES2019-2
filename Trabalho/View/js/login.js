function login(){
    $.post('../src/login.php', { email: $("#username").val(), password: $("#password").val()})
        .done(function (data) {
        	console.log(data);
            let response = JSON.parse(data);
            if (response['success']){
                window.location.href = "./home.html";
            } else{
                alert("Erro");
            }
    });
}