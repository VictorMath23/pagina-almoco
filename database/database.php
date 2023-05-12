<?php
// Configuração do banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mfg";

// Cria a conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Consulta os horários de almoço
$query = "SELECT linha, horario, revezamento FROM mfg.almoco_manufatura order by linha asc";
$result = $conn->query($query);

// Cria um array para armazenar os horários de almoço
$horarios = array();

if ($result->num_rows > 0) {
    // Percorre cada linha do resultado da consulta e adiciona ao array de horários
    while($row = $result->fetch_assoc()) {
        $horarios[] = array(
            'linha' => $row['linha'],
            'horario' => $row['horario'],
            'revezamento' => $row['revezamento']
        );
    }
}

// Retorna os horários de almoço em formato JSON
header('Content-Type: application/json');
echo json_encode($horarios);

if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $horarios = $_POST['horario'];
  $revezas = $_POST['reveza'];

  foreach($horarios as $key => $horario){
    $linha = $_POST['linha'][$key];
    $reveza = $revezas[$key];

    // Verifica se ocorreu um erro ao conectar
    if ($conn->connect_error) {
      die('Erro de conexão (' . $conn->connect_errno . ') '
      .$conn->connect_error);
    }
    
    // Verifica se a linha já existe na tabela
    $query = "SELECT COUNT(*) FROM mfg.almoco_manufatura WHERE linha = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $linha);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if($count == 0){
      // Se a linha não existir, faz um insert
      $query = "INSERT INTO mfg.almoco_manufatura (linha, horario, revezamento) VALUES (?, ?, ?)";
      $stmt =$conn->prepare($query);
      $stmt->bind_param('sss', $linha, $horario, $reveza);
      $stmt->execute();

      // Mensagem de validação
      echo "<script>alert('Linha inserida com sucesso!')</script>";
     
      
    } else {
      // Se a linha existir, verifica se o revezamento é diferente do valor atual
      $query = "SELECT revezamento, horario FROM mfg.almoco_manufatura WHERE linha = ?";
      $stmt = $conn->prepare($query);
      $stmt->bind_param('s', $linha);
      $stmt->execute();
      $stmt->bind_result($atual_revezamento,$atual_horario);
      $stmt->fetch();
      $stmt->close();
      
      if(($atual_revezamento != $reveza) || ($atual_horario != $horario)) {
        // Se o revezamento for diferente, faz um update
        $query = "UPDATE mfg.almoco_manufatura 
        SET 
            horario = IF(? = '', horario, ?),
            revezamento = IF(? = '', revezamento, ?)
        WHERE linha = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sssss', $horario, $horario, $reveza, $reveza, $linha);
        $stmt->execute();  
        
        // Mensagem de validação
        echo "<script>alert('Linha inserida com sucesso!')</script>";
      }
      // Se o revezamento for igual, não faz nada
      
    }    
  }
}
// Fecha a conexão com o banco de dados
$conn->close();
?>
