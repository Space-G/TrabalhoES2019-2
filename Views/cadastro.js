function cadastrar(){
    var form = "<form action='cadastro.php' method='post'>" +
        "<input type='hidden' name='nome' value='" + $("#nome").val() + "'>" +
        "<input type='hidden' name='cpf' value='" + $("#cpf").val() + "'>" +
        "<input type='hidden' name='genero' value='" + $("#genero :selected").val() + "'>" +
        "<input type='hidden' name='email' value='" + $("#email").val() + "'>" +
        "<input type='hidden' name='senha' value='" + $("#senha").val + "'>" +
        "<input type='hidden' name='is_escort' value='" + $("input[name=\"tipo-usuario\"]").val() + "'>";

    $("input[name=\"fetiches\"]:checked").each(function (i) {
        form = form + "<input type='hidden' name='fetiches' value='" + $("input[name=\"fetiches\"]:checked")[i].val() + "'>";
    })

    $("input[name=\"generos-desejados\"]:checked").each(function (i) {
        form = form + "<input type='hidden' name='generos_desejados' value='" + $("input[name=\"generos-desejados\"]:checked")[i].val() + "'>";
    })
    "</form>";

    $(form).appendTo('body').submit();
}