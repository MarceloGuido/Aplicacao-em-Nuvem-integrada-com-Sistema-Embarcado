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
                <h2>Listagem dos Dados Coletados</h2>
            </div>
            <div class="col-1">
            <a href="../iot/"><button type="button" class="btn btn-secondary"><i class="bi bi-house"></i></button></a>
            </div>
        </div>
    </div>
    <div class="container p-3 ">
        <h2>Acionamentos</h2>
    </div>
    <div class="container p-2">
        <table class="table table-striped table-striped-columns">
            <thead>
                <tr>
                    <th scope="col">Data</th>
                    <th scope="col">Hora</th>
                    <th scope="col">Temperatura</th>
                    <th scope="col">Umidade</th>
                </tr>
            </thead>
            <tbody>
                <?php
                header("refresh: 5;");
                //Código retirado de: https://www.w3schools.com/php/php_mysql_select.asp
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "db_IoT";

                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);
                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                //comando select na ordem decrescente pelo id
                $sql = "SELECT data, hora, temp, umidade FROM tbl_DC ORDER BY id";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while ($row = $result->fetch_assoc()) {
//                        echo "<tr><th scope='row'>" . $row["id"] . "</th><td>" . $row["data"] . "</th><td>" . $row["hora"] . "</th><td>" . $row["temp"] . $row["umidade"] ;
                        echo "<tr><th scope='row'>". $row["data"] . "</th><td>" . $row["hora"] . "</th><td>" . $row["temp"] . "</th><td>" . $row["umidade"] ;
}
                } else {
                    echo "<tr><th colspan='4' class='text-center p-5'><h2>Nenhum resultado</h2><th></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>
