<?php
$id_usuario = $_SESSION['id_usuario'];
$cpf = $_SESSION['cpf'];

// Conectar ao banco de dados
$conn = mysqli_connect("localhost", "root", "12345", "emprega_mais");
if (!$conn) {
    die("Erro ao conectar ao banco de dados: " . mysqli_connect_error());
}

// Modifica o CPF para gerar o nome da tabela personalizada do usuário
$cpf_modificado = str_replace(['.', '-'], '_', $cpf);
$nome_tabela_usuario = "usuario_" . $id_usuario . "_" . $cpf_modificado;

// Verifica se a tabela do usuário existe
$sql_check_table = "SHOW TABLES LIKE '$nome_tabela_usuario'";
$result_check_table = $conn->query($sql_check_table);

if ($result_check_table->num_rows == 0) {
    echo "Nenhuma vaga cadastrada para este usuário.";
} else {
    $sql = "
                SELECT v.id, v.nome, v.tipo, v.disponivel, v.quantidade_vagas, v.escolaridade, v.empresa, v.localidade, v.carga_horaria, v.descricao_vaga 
                FROM $nome_tabela_usuario AS u
                JOIN vagas AS v ON u.id_vaga = v.id
            ";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='white-box'>";
            echo "<form method='POST' action='mv_delete.php'>";
            echo "<div class='titulo_id'>";
            echo "<input type='hidden' name='id' value='" . $row["id"] . "' readonly>";
            echo "</div>";

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

            echo "<div class='botao_cancelar'>";
            echo "<input type='hidden' name='id_vaga' value='" . $row["id"] . "'>";
            echo "<button type='submit' class='cancelar' onclick='return confirmarExclusao(this)'>Cancelar inscrição</button>";
            echo "</div>";
            echo "</form>";
            echo "</div>";
        }
    } else {
        echo "Nenhuma vaga cadastrada para este usuário.";
    }
}

$conn->close();
