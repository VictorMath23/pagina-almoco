<?php
date_default_timezone_set('America/Sao_Paulo');


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mfg";


$conn = mysqli_connect($servername, $username, $password, $dbname);


if (!$conn) {
    die("Falha na conexão com o banco de dados: " . mysqli_connect_error());
}


for ($i = 1; $i <= 12; $i++) {
    $button_name = "linha{$i}";
    $horario_name = "horario{$i}";
    $linha_name = "Linha {$i}";

    if (isset($_POST[$button_name])) {
        $horario = $_POST[$horario_name];
        atualizar_horario($linha_name, $horario, $conn);
        break; 
    }
}

//atualiza o horário no banco
function atualizar_horario($linha, $horario, $conn) {
    $sql = "UPDATE almoco_manufatura SET horario = '$horario' WHERE linha = '$linha'";
    if (mysqli_query($conn, $sql)) {
        echo '<script>alert("Horário da ' . $linha . ' atualizado com sucesso!"); window.location.href = "http://localhost/Horario_almoco/index.html";</script>';
    } else {
        echo '<script>alert("Erro ao atualizar horário da ' . $linha . ': ' . mysqli_error($conn) . '"); window.location.href = "http://localhost/Horario_almoco/index.html";</script>';
    }
    

}


mysqli_close($conn);
?>
