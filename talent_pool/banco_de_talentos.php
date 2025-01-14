<?php
// Conexão com o banco de dados
$conn = mysqli_connect("localhost", "root", "12345", "emprega_mais");
if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
}

// Verifica se o parâmetro de pesquisa foi enviado
$pesquisa = isset($_GET['pesquisar']) ? $_GET['pesquisar'] : '';

// Monta a query de seleção com base no campo de pesquisa
$sql = "SELECT id, nome_completo, cpf, data_nascimento, genero FROM usuarios";
if (!empty($pesquisa)) {
    // Adiciona a cláusula WHERE para buscar em nome_completo, cpf, data_nascimento ou genero
    $sql .= " WHERE nome_completo LIKE '%$pesquisa%' 
                            OR cpf LIKE '%$pesquisa%' 
                            OR data_nascimento LIKE '%$pesquisa%' 
                            OR genero LIKE '%$pesquisa%'";
}

$result = $conn->query($sql);


if ($result->num_rows > 0) {

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

    $index = 1; // Contador para a numeração das linhas
    while ($row = $result->fetch_assoc()) {
        echo '<tr>
                                <th scope="row">' . $index . '</th>
                                <td>' . htmlspecialchars($row['nome_completo']) . '</td>
                                <td>' . htmlspecialchars($row['cpf']) . '</td>
                                <td>' . htmlspecialchars($row['data_nascimento']) . '</td>
                                <td>' . htmlspecialchars($row['genero']) . '</td>
                                <td>
                                    <!-- Botão de Excluir -->
                                    <form action="bdt_delete.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="id" value="' . $row['id'] . '">
                                        <button type="submit" class="excluir" onclick="return confirm(\'Tem certeza de que deseja excluir esta conta? Essa ação não poderá ser desfeita!\')">Excluir</button>
                                    </form>
                    
                                    <!-- Botão de Ver -->
                                    <a href="../talent_pool/bdt_perfil_candidato_html.php?id=' . $row['id'] . '" class="btn visualizar" role="button">Visualizar</a>
                                </td>
                            </tr>';
        $index++; // Incrementa o contador
    }

    echo '</tbody></table>';
} else {
    echo "0 results";
}


$conn->close();
