<?php
// Configuração do banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "h_almoco";

// Cria a conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se a conexão foi estabelecida com sucesso
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verifica se foi enviado algum dado através do método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera os valores enviados pelo formulário
    $linha = $_POST["linha"];
    $horario = $_POST["horario"];

    // Insere os valores na tabela do banco de dados
    $sql =  "UPDATE h_almoco.almoco SET linha='$linha', horario= '$horario' WHERE linha = '$linha'";
   
    if ($conn->query($sql) === TRUE) {
        echo "Dados inseridos com sucesso";
    } else {
        echo "Erro ao inserir dados: " . $conn->error;
    }
}

// Fecha a conexão com o banco de dados
$conn->close();
?>