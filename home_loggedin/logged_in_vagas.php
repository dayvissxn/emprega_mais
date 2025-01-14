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
        // Gerar o nome da tabela da vaga
        $id_vaga = $row["id"];
        $nome_vaga = $row["nome"];
        $nome_tabela = "vaga_" . $id_vaga . "_" . preg_replace('/[^a-zA-Z0-9_]/', '', str_replace(' ', '_', $nome_vaga));

        // Verifica se o usuário já está inscrito na vaga
        $sql_check_inscrito = "SELECT * FROM $nome_tabela WHERE id_usuario = '$id_usuario'";
        $result_inscrito = $conn->query($sql_check_inscrito);

        echo "<div class='white-box'>";
        echo "<form action='li_candidatar.php' method='POST'>";
        echo "<input type='hidden' name='id_vaga' value='" . $id_vaga . "'>";
        echo "<input type='hidden' name='id_usuario' value='" . $id_usuario . "'>";

        echo "<div class='nome_empresa'>";
        echo "<div class='nome'>";
        echo "<input type='text' id='nome_" . $id_vaga . "' name='nome' value='" . $row["nome"] . "' readonly>";
        echo "</div>";
        echo "<div class='empresa'>";
        echo "<input type='text' id='empresa_" . $id_vaga . "' name='empresa' value='" . $row["empresa"] . "' readonly>";
        echo "</div>";
        echo "</div>";

        echo "<div class='l_qv_d'>";
        echo "<div class='localidade'>";
        echo "<i class='fa-solid fa-location-dot'></i>";
        echo "<input type='text' id='localidade_" . $id_vaga . "' name='localidade' value='" . $row["localidade"] . "' readonly>";
        echo "</div>";
        echo "<div class='quantidade_vagas'>";
        echo "<i class='fa-solid fa-users'></i>";
        echo "<input type='text' id='quantidade_vagas_" . $id_vaga . "' name='quantidade_vagas' value='" . $row["quantidade_vagas"] . "' readonly>";
        echo "</div>";
        echo "<div class='disponivel'>";
        echo "<i class='fa-solid fa-circle-exclamation'></i>";
        echo "<input type='text' id='disponivel_" . $id_vaga . "' name='disponivel' value='" . $row["disponivel"] . "' readonly>";
        echo "</div>";
        echo "</div>";

        echo "<div class='t_e_ch'>";
        echo "<div class='tipo'>";
        echo "<i class='fa-solid fa-file-contract'></i>";
        echo "<input type='text' id='tipo_" . $id_vaga . "' name='tipo' value='" . $row["tipo"] . "' readonly>";
        echo "</div>";
        echo "<div class='escolaridade'>";
        echo "<i class='fa-solid fa-graduation-cap'></i>";
        echo "<input type='text' id='escolaridade_" . $id_vaga . "' name='escolaridade' value='" . $row["escolaridade"] . "' readonly>";
        echo "</div>";
        echo "<div class='carga_horaria'>";
        echo "<i class='fa-solid fa-clock'></i>";
        echo "<input type='text' id='carga_horaria_" . $id_vaga . "' name='carga_horaria' value='" . $row["carga_horaria"] . "' readonly>";
        echo "</div>";
        echo "</div>";

        echo "<div class='descricao_vaga'>";
        echo "<textarea id='descricao_vaga_" . $id_vaga . "' name='descricao_vaga' readonly>" . $row["descricao_vaga"] . "</textarea>";
        echo "</div>";

        echo "<div class='botao_candidatar'>";
        // Altera o botão com base na inscrição
        if ($result_inscrito->num_rows > 0) {
            echo "<button type='button' class='inscrito' disabled>Inscrito na vaga</button>";
        } else {
            echo "<button type='button' class='candidatar' onclick='candidatarVaga($id_vaga, $id_usuario, this)'>Candidatar-se a vaga</button>";
        }
        echo "</div>";
        echo "</form>";
        echo "</div>";
    }
} else {
    echo "Nenhuma vaga encontrada.";
}

$conn->close();
