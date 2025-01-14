<?php
// Conexão com o banco de dados
$conn = mysqli_connect("localhost", "root", "12345", "emprega_mais");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Captura os valores dos campos de pesquisa
$vaga = isset($_GET['vaga']) ? $_GET['vaga'] : '';
$empresa = isset($_GET['empresa']) ? $_GET['empresa'] : '';

// Cria a query SQL com base nos valores de pesquisa
$sql = "SELECT id, nome, tipo, disponivel, quantidade_vagas, escolaridade, empresa, localidade, carga_horaria, descricao_vaga FROM vagas WHERE 1=1";

// Adiciona filtros à query se os valores forem fornecidos
if ($vaga != '') {
    $sql .= " AND nome LIKE '%$vaga%'";
}
if ($empresa != '') {
    $sql .= " AND empresa LIKE '%$empresa%'";
}

$result = $conn->query($sql);

// Verifica e exibe os resultados da pesquisa
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='white-box'>";
        echo "<form action='../login/login_html.php' method='GET'>";
        echo "<div class='nome_empresa'>";
        echo "<div class='nome'>";
        echo "<input type='text' id='nome_" . $row["id"] . "' name='nome' value='" . $row["nome"] . "' readonly>";
        echo "</div>";
        echo "<div class='empresa'>";
        echo "<input type='text' id='empresa_" . $row["id"] . "' name='empresa' value='" . $row["empresa"] . "' readonly>";
        echo "</div>";
        echo "</div>";

        echo "<div class='l_qv_d'>";
        echo "<div class='localidade'>";
        echo "<i class='fa-solid fa-location-dot'></i>";
        echo "<input type='text' id='localidade_" . $row["id"] . "' name='localidade' value='" . $row["localidade"] . "' readonly>";
        echo "</div>";
        echo "<div class='quantidade_vagas'>";
        echo "<i class='fa-solid fa-users'></i>";
        echo "<input type='text' id='quantidade_vagas_" . $row["id"] . "' name='quantidade_vagas' value='" . $row["quantidade_vagas"] . "' readonly>";
        echo "</div>";
        echo "<div class='disponivel'>";
        echo "<i class='fa-solid fa-circle-exclamation'></i>";
        echo "<input type='text' id='disponivel_" . $row["id"] . "' name='disponivel' value='" . $row["disponivel"] . "' readonly>";
        echo "</div>";
        echo "</div>";

        echo "<div class='t_e_ch'>";
        echo "<div class='tipo'>";
        echo "<i class='fa-solid fa-file-contract'></i>";
        echo "<input type='text' id='tipo_" . $row["id"] . "' name='tipo' value='" . $row["tipo"] . "' readonly>";
        echo "</div>";
        echo "<div class='escolaridade'>";
        echo "<i class='fa-solid fa-graduation-cap'></i>";
        echo "<input type='text' id='escolaridade_" . $row["id"] . "' name='escolaridade' value='" . $row["escolaridade"] . "' readonly>";
        echo "</div>";
        echo "<div class='carga_horaria'>";
        echo "<i class='fa-solid fa-clock'></i>";
        echo "<input type='text' id='carga_horaria_" . $row["id"] . "' name='carga_horaria' value='" . $row["carga_horaria"] . "' readonly>";
        echo "</div>";
        echo "</div>";

        echo "<div class='descricao_vaga'>";
        echo "<textarea id='descricao_vaga_" . $row["id"] . "' name='descricao_vaga' readonly>" . $row["descricao_vaga"] . "</textarea>";
        echo "</div>";

        echo "<div class='botao_candidatar'>";
        echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
        echo "<button type='submit' class='candidatar'>Candidatar-se a vaga</button>";
        echo "</div>";
        echo "</form>";
        echo "</div>";
    }
} else {
    echo "Nenhuma vaga encontrada.";
}

$conn->close();
