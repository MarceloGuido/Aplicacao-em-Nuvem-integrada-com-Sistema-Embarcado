<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2024 - Aplicação em Nuvem integrada com Sistema Embarcado</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .dashboard {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            width: 80%;
            max-width: 1200px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .card h3 {
            margin: 0;
            font-size: 24px;
        }

        .card .value {
            font-size: 36px;
            font-weight: bold;
            margin: 10px 0;
        }

        .clock, .calendar {
            font-size: 48px;
            color: #555;
            font-weight: bold;
        }

    </style>
</head>

<body>
    <div class="container-fluid p-4 text-light bg-dark">
        <div class="row">
            <div class="col-8">
                <h2>Coleta de dados a partir do ESP32</h2>
            </div>
            <div class="col-2">
                <a href="javascript:void(0)" id="saveButton">
                    <button type="button" class="btn btn-secondary">Salvar Dados</button>
                </a>
            </div>
            <div class="col-1">
                <a href="../iot/"><button type="button" class="btn btn-secondary"><i class="bi bi-house"></i></button></a>
            </div>
        </div>
    </div>
    <div><p></p></div>
    <div class="dashboard">
        <div class="card">
            <h3>Temperatura</h3>
            <div class="value" id="temperatura">0°C</div>
        </div>
        <div class="card">
            <h3>Umidade</h3>
            <div class="value" id="umidade">0%</div>
        </div>
        <div class="card">
            <h3>Data</h3>
            <div class="calendar" id="data">--/--/----</div>
        </div>
        <div class="card">
            <h3>Hora</h3>
            <div class="clock" id="clock">--:--</div>
        </div>
    </div>

    <script>
        function updateDashboard() {
            fetch('LeJSON.php', { method: 'GET' })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('temperatura').textContent = data.temperatura + "°C";
                    document.getElementById('umidade').textContent = data.umidade + "%";
                    document.getElementById('data').textContent = data.data;
                    document.getElementById('clock').textContent = data.hora;
                })
                .catch(error => console.error('Erro ao buscar dados:', error));
        }

        setInterval(updateDashboard, 10000);
        updateDashboard();

        document.getElementById('saveButton').addEventListener('click', function() {
            // Coleta os dados do dashboard
            const temperatura = document.getElementById('temperatura').textContent.replace('°C', '');
            const umidade = document.getElementById('umidade').textContent.replace('%', '');
            const data = document.getElementById('data').textContent;
            const hora = document.getElementById('clock').textContent;

            // Envia os dados via POST para o PHP salvar no banco
            fetch('gravabanco.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    'temperatura': temperatura,
                    'umidade': umidade,
                    'data': data,
                    'hora': hora
                })
            })
            .then(response => response.text())
            .then(data => {
                alert(data);  // Exibe a resposta do PHP (sucesso ou erro)
            })
            .catch(error => console.error('Erro ao salvar os dados:', error));
        });
    </script>
</body>
</html>
