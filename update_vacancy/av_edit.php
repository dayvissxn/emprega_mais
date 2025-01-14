<?php
$conn = mysqli_connect("localhost", "root", "12345", "emprega_mais");
if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT id, nome, tipo, disponivel, quantidade_vagas, escolaridade, empresa, localidade, carga_horaria, descricao_vaga FROM vagas WHERE id='$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "<div class='white-box'>";
        echo "<form action='av_update.php' method='POST'>";
        echo "<div class='titulo_id'>";
        echo "<label>ID:</label><input type='text' name='id' value='" . $row["id"] . "' readonly>";
        echo "</div>";

        echo "<fieldset class='grupo'>";
        echo "<div class='campo'>";
        echo "<label for='nome_" . $row["id"] . "'>Nome:</label><input type='text' id='nome_" . $row["id"] . "' name='nome' value='" . $row["nome"] . "'>";
        echo "</div>";

        echo "<div class='campo'>";
        echo "<label for='tipo_" . $row["id"] . "'>Tipo:</label><input type='text' id='tipo_" . $row["id"] . "' name='tipo' value='" . $row["tipo"] . "'>";
        echo "</div>";
        echo "</fieldset>";

        echo "<fieldset class='grupo'>";
        echo "<div class='campo'>";
        echo "<label for='disponivel_" . $row["id"] . "'>Disponivel:</label><input type='text' id='disponivel_" . $row["id"] . "' name='disponivel' value='" . $row["disponivel"] . "'>";
        echo "</div>";

        echo "<div class='campo'>";
        echo "<label for='quantidade_vagas_" . $row["id"] . "'>Quantidade vagas:</label><input type='text' id='quantidade_vagas_" . $row["id"] . "' name='quantidade_vagas' value='" . $row["quantidade_vagas"] . "'>";
        echo "</div>";
        echo "</fieldset>";

        echo "<fieldset class='grupo'>";
        echo "<div class='campo'>";
        echo "<label for='escolaridade_" . $row["id"] . "'>Escolaridade:</label><input type='text' id='escolaridade_" . $row["id"] . "' name='escolaridade' value='" . $row["escolaridade"] . "'>";
        echo "</div>";

        echo "<div class='campo'>";
        echo "<label for='empresa_" . $row["id"] . "'>Empresa:</label><input type='text' id='empresa_" . $row["id"] . "' name='empresa' value='" . $row["empresa"] . "'>";
        echo "</div>";
        echo "</fieldset>";

        echo "<fieldset class='grupo'>";
        echo "<div class='campo'>";
        echo "<label for='localidade_" . $row["id"] . "'>Localidade:</label><input type='text' id='localidade_" . $row["id"] . "' name='localidade' value='" . $row["localidade"] . "'>";
        echo "</div>";

        echo "<div class='campo'>";
        echo "<label for='carga_horaria_" . $row["id"] . "'>Carga horária:</label><input type='text' id='carga_horaria_" . $row["id"] . "' name='carga_horaria' value='" . $row["carga_horaria"] . "'>";
        echo "</div>";
        echo "</fieldset>";

        echo "<div class='descricao_vaga'>";
        echo "<label for='descricao_vaga_" . $row["id"] . "'>Descrição da vaga:</label><textarea id='descricao_vaga_" . $row["id"] . "' name='descricao_vaga'>" . $row["descricao_vaga"] . "</textarea>";
        echo "</div>";

        echo "<div class='botoes'>";
        echo "<button type='submit' class='salvar'>Salvar</button>";
        echo "<button type='button' class='cancelar' onclick='window.history.back()'>Cancelar</button>";
        echo "</div>";
        echo "</form>";
        echo "</div>";
    } else {
        echo "Vaga não encontrada.";
    }
} else {
    echo "ID da vaga não especificado.";
}

$conn->close();
