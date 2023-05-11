<?php
// Configuração do banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "h_almoco";

// Cria a conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se ocorreu um erro ao conectar
if ($conn->connect_error) {
    die('Erro de conexão (' . $conn->connect_errno . ') '
        .$conn->connect_error);
  }
  
  // Verifica se a tabela está vazia
  $query = "SELECT COUNT(*) FROM h_almoco.almoco";
  $result = $conn->query($query);
  $row = $result->fetch_row();
  if ($row[0] == 0) {
    // Se a tabela estiver vazia, faz um insert
    $query = "INSERT INTO h_almoco.almoco (linha, horario) VALUES (?, ?)";
    $stmt =$conn->prepare($query);
    $stmt->bind_param('ss', $_POST['linha'], $_POST['horario']);
    $stmt->execute();
  } else {
    // Se a tabela não estiver vazia, faz um update
    $query = "UPDATE h_almoco.almoco SET horario = ? WHERE linha = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $_POST['horario'], $_POST['linha']);
    $stmt->execute();
  }
  
  // Fecha a conexão com o banco de dados
  $conn->close();
  
  ?>