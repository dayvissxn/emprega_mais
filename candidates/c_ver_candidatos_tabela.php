<!-- Tabela de usuários -->
<?php
// Tabela de candidatos
$candidatos_table_name = "vaga_" . $id_vaga . "_" . preg_replace('/[^a-zA-Z0-9_]/', '', str_replace(' ', '_', $vaga['nome']));

// Verifica se o parâmetro de pesquisa foi enviado
$pesquisa = isset($_GET['pesquisar']) ? $_GET['pesquisar'] : '';
$sql = "
    SELECT u.id, u.nome_completo, u.cpf, u.data_nascimento, u.genero 
    FROM $candidatos_table_name AS c
    JOIN usuarios AS u ON c.id_usuario = u.id
";
if (!empty($pesquisa)) {
    // Adiciona a cláusula WHERE para buscar em nome_completo, cpf, data_nascimento ou genero, referenciando as tabelas corretamente
    $sql .= " WHERE u.nome_completo LIKE '%$pesquisa%' 
            OR u.cpf LIKE '%$pesquisa%' 
            OR u.data_nascimento LIKE '%$pesquisa%' 
            OR u.genero LIKE '%$pesquisa%'";
}

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    echo '<table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">NOME COMPLETO</th>
                <th scope="col">CPF</th>
                <th scope="col">DATA DE NASCIMENTO</th>
                <th scope="col">GÊNERO</th>
                <th scope="col">AÇÕES</th>
            </tr>
        </thead>
        <tbody>';

    $index = 1;
    while ($row = $result->fetch_assoc()) {
        if (isset($row['id'])) {
            echo '<tr>
                <th scope="row">' . $index . '</th>
                <td>' . htmlspecialchars($row['nome_completo']) . '</td>
                <td>' . htmlspecialchars($row['cpf']) . '</td>
                <td>' . htmlspecialchars($row['data_nascimento']) . '</td>
                <td>' . htmlspecialchars($row['genero']) . '</td>
                <td>
                    <a href="../candidates/c_perfil_candidato_html.php?id=' . htmlspecialchars($row['id']) . '&id_vaga=' . htmlspecialchars($id_vaga) . '" class="btn visualizar" role="button">Visualizar</a>
                </td>
            </tr>';
            $index++;
        }
    }

    echo '</tbody></table>';

    // Botão de Voltar
    echo '<div class="voltar">
        <a href="../candidates/candidatos_html.php" class="voltar_btn">
            <i class="fa-regular fa-circle-left"></i> Voltar
        </a>
    </div>';
} else {
    echo "<p>0 resultados.</p>";
}

$conn->close();

?>