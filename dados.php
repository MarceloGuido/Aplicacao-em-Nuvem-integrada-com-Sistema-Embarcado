<?php
header('Content-Type: application/json');

// Arquivo para armazenar os dados
$arquivo_dados = 'dados_esp.json';

// Verifica o método da requisição
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe os dados enviados pelo ESP32 no corpo da requisição
    $input = file_get_contents('php://input');
    $dados = json_decode($input, true);

    // Valida o JSON recebido
    if (json_last_error() === JSON_ERROR_NONE && isset($dados['temperatura'], $dados['umidade'], $dados['data'], $dados['hora'])) {
        // Salva os dados em um arquivo JSON
        file_put_contents($arquivo_dados, json_encode($dados));
        echo json_encode(["status" => "Dados salvos com sucesso."]);
    } else {
        http_response_code(400); // Bad Request
        echo json_encode(["erro" => "JSON inválido ou campos ausentes."]);
    }
    exit;
}

// Se for GET, retorna os últimos dados armazenados
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (file_exists($arquivo_dados)) {
        // Lê os dados do arquivo JSON
        $dados = file_get_contents($arquivo_dados);
        echo $dados;
    } else {
        http_response_code(404); // Not Found
        echo json_encode(["erro" => "Nenhum dado encontrado."]);
    }
    exit;
}

// Método não permitido
http_response_code(405); // Method Not Allowed
echo json_encode(["erro" => "Método não permitido."]);
exit;
?>
