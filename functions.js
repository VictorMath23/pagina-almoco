// Seleciona todos os botões "submit" na página e adiciona um evento "click" a eles
var submitButtons = document.querySelectorAll('input[type="submit"]');
submitButtons.forEach(function (button) {
    button.addEventListener("click", function (event) {
        // Impede que o formulário seja enviado normalmente
        event.preventDefault();

        // Obtém o tr pai do botão clicado
        var tr = event.target.closest("tr");

        // Obtém os inputs de cada td dentro do tr
        var timeInput = tr.querySelector('input[name="horario[]"]');
        var linhaInput = tr.querySelector('input[name="linha[]"]');
        var revezaSelect = tr.querySelector('select[name="reveza[]"]');

        // Cria um objeto FormData com os valores dos inputs
        var formData = new FormData();
        formData.append("horario[]", timeInput.value);
        formData.append("linha[]", linhaInput.value);
        formData.append("reveza[]", revezaSelect.value);

        // Faz uma requisição Ajax usando o método POST
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "database/database.php");
        xhr.onload = function () {
            // Exibe a resposta da requisição no console
            console.log(xhr.responseText);
        };
        xhr.send(formData);

        // Exibe uma mensagem de sucesso após o envio do formulário
        swal("Horario da " + linhaInput.value + " definido com sucesso!");

        var formData = new FormData();
        formData.append("horario[]", timeInput.value);
        formData.append("linha[]", linhaInput.value);
        formData.append("reveza[]", revezaSelect.value);

        // Faz uma requisição Ajax usando o método POST
        $.ajax({
            url: "http://localhost/pagina-almoco_/database/database.php",
            type: "GET",
            success: function (data) {
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Erro: " + textStatus);
            }
        });
    });
});
