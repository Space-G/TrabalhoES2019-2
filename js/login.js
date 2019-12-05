function login(){
    $.post('login.php', { email: $("#username").val(), password: $("#password").val()})
        .done(function (data) {
            let response = JSON.parse(data);
            if (response['success']){
                window.location.href = "./home.html";
            } else{
                alert("Erro");
            }
    });
}