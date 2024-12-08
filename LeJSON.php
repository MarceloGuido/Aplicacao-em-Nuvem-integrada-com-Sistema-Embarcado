<?php
// Configurar o cabeçalho para aceitar JSON
header("Content-Type: application/json; charset=UTF-8");

// Verificar se o arquivo de dados existe
$arquivo_json = 'dados_esp.json';
if (file_exists($arquivo_json)) {
    // Ler os dados do arquivo JSON
    $dados = file_get_contents($arquivo_json);

    // Retornar os dados como JSON
    echo $dados;
} else {
    // Caso o arquivo não exista, retornar um erro
    http_response_code(404);
    echo json_encode(["erro" => "Dados não encontrados."]);
}
?>
