<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2024 - Aplicação em Nuvem integrada com Sistema Embarcado</title>
    <!-- https://getbootstrap.com/docs/5.2/getting-started/download/#cdn-via-jsdelivr -->
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- https://icons.getbootstrap.com/ -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>
    <div class="container-fluid p-4 text-light bg-dark">
        <div class="row">
            <div class="col-11">
                <h2>Teste de conexão com o Banco de Dados</h2>
            </div>
            <div class="col-1">
            <a href="../iot/"><button type="button" class="btn btn-secondary"><i class="bi bi-house"></i></button></a>
            </div>
        </div>
    </div>
    <div class="container p-2">
        <table class="table table-striped table-striped-columns">
            <tbody>
                <?php
                header("refresh: 5;");

                // Conexão com o banco de dados
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "db_iot";
                
                try {
                    // Cria a conexão
                    $conn = new mysqli($servername, $username, $password, $dbname);
                    
                    // Verifica se a conexão falhou
                    if ($conn->connect_error) {
                        throw new Exception("Falha na conexão: " . $conn->connect_error);
                    }
                
                    // Tenta executar a query
                    $sql = "SELECT * FROM tbl_dc"; // Verifique se a tabela existe
                    $result = $conn->query($sql);
                
                    // Verifica se houve erro na consulta
                    if ($result === false) {
                        throw new Exception("Erro na execução da consulta: " . $conn->error);
                    }
                
                   // Exibe uma mensagem amigável ao usuário
                   echo "<h2>Conexão com o banco de dados ok !!!";
                    
                } catch (Exception $e) {
                    // Exibe uma mensagem amigável ao usuário
                    echo "<h2>Ocorreu um erro ao acessar o banco de dados.<BR>Por favor, tente novamente mais tarde.";
                    // Se necessário, logue o erro real em um arquivo ou em um banco de dados
                    error_log($e->getMessage()); // Registra o erro completo no log de erros
                } finally {
                    // Fecha a conexão com o banco de dados, se estiver aberta
                    if ($conn) {
                        $conn->close();
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>
