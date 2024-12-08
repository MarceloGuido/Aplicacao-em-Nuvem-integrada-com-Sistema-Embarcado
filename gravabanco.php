<?php
// Conexão com o banco de dados MySQL (alterar conforme necessário)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_iot";  // Nome do banco de dados

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verificar se os dados foram passados corretamente
if (isset($_POST['temperatura']) && isset($_POST['umidade']) && isset($_POST['data']) && isset($_POST['hora'])) {
    // Obter dados via POST
    $temperatura = $_POST['temperatura'];
    $umidade = $_POST['umidade'];
    $data = $_POST['data'];
    $hora = $_POST['hora'];

    // Usando prepared statement para evitar SQL Injection
    $stmt = $conn->prepare("INSERT INTO tbl_dc (temp, umidade, data, hora) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $temperatura, $umidade, $data, $hora);

    // Executar a query
    if ($stmt->execute()) {
        echo "Dados salvos com sucesso!";
    } else {
        echo "Erro ao salvar os dados: " . $stmt->error;
    }

    // Fechar a conexão
    $stmt->close();
} else {
    echo "Erro: Dados não recebidos corretamente.";
}

$conn->close();
?>
