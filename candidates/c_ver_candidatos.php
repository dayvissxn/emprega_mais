<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CODIGO DA FONTE -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <!-- FIM DO CODIGO DA FONTE  -->

    <!-- Adicionar Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- Fim do código para Font Awesome -->

    <!-- Adicionar bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Fim do código para bootstrap -->

    <title>Candidatos inscritos</title>

<style>
* {
    margin: 0;
    padding: 0;
    font-family: 'Ubuntu', sans-serif;
}
body {
    margin: 0;
    height: 100vh; /* Certifique-se de que a altura do body ocupe toda a altura da viewport */
    background-color: #003079;
    background: linear-gradient(to right, #cecdcd, #00307993, #cecdcd);
    font-family: 'Ubuntu', sans-serif;
    display: flex;
    justify-content: flex-start; /* Alinha o conteúdo no topo do contêiner */
    align-items: center; /* Centraliza a tabela verticalmente */
    flex-direction: column;
    
}

.infos {
    width: 80%; /* Define a largura da tabela para 80% da largura da tela */
    max-width: 1000px; /* Define um máximo de largura para a tabela */
    margin-top: 60px;

}

.vaga-id {
    color: #FFFFFF;
    font-weight: 700;
    font-size: 20px;
    margin-bottom: -5px;
    
}

.nome-id {
    color: #35383F;
    font-weight: 500;
    font-size: 30px;
    margin-bottom: -10px;
}

.empresa-id {
    color: #35383F;
    padding-bottom: 16px;
    font-weight: 300;
    font-size: 20px;
    border-bottom: 2px solid #35383F;
}

form{
    display: flex;
    width: 80%; /* Define a largura da tabela para 80% da largura da tela */
    max-width: 1000px; /* Define um máximo de largura para a tabela */

}

.caixa_pesquisar {
    display: flex;
    align-items: center;
    width: 695px;
    height: 45px;
    padding: 0 5px; 
    border: none;
    background-color: #fff;
    border-radius: 5px;
    box-sizing: border-box;
}

.input_pesquisar {
    border: none;
    padding: 0 5px; 
    margin: 0px 10px 0px 5px;
    flex-grow: 1;
    height: 30px;
    background-color: #ffff;
    font-size: 15px;
    width: 100%;
}

.caixa_pesquisar i {
    margin-left: 5px;
    color: #808080;
}

.botao_buscar {
    display: flex;
    margin-left: 40px;
}

.botao_buscar button {
    font-weight: 500;
    padding: 5px 93px;
    font-size: 25px; 
    background-color: #003079; 
    color: #ffffff; 
    border: none; 
    border-radius: 8.89px; 
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1), 
                0 6px 20px rgba(0, 0, 0, 0.1);
    cursor: pointer;

}

.botao_buscar button:hover {
    background-color: #0056b3; /* Cor de fundo dos botões ao passar o mouse */
    color: #FFE500;
}

table{
    margin-top: 50px;
    width: 80%; /* Define a largura da tabela para 80% da largura da tela */
    max-width: 1000px; /* Define um máximo de largura para a tabela */

}

.table th, .table td {
  vertical-align: middle; /* Alinha verticalmente ao meio */
 
}

/* Cor do fundo cabeçalho */
thead {
    background-color: #FFFFFF; /* Cor de fundo azul */
    text-align: center;
}

/* Cor do fundo impares */
.table-striped tbody tr:nth-of-type(odd) {
    background-color: #759DC2; /* Cor azul */
}

/* Cor do fundo pares */
.table-striped tbody tr:nth-of-type(even) {
    background-color: #FFFFFF; /* Cor branca */
   
}

/* Cor da linhas das tabelas e bordas */
.table-bordered {
    border: 1px solid #000; /* Cor da borda da tabela */
}

.table-bordered th,
.table-bordered td, 
.table-bordered tr {
    border: 1px solid #000; /* Cor da borda das células */
    padding: 3px 15px; 
}

.visualizar {
    font-weight: 500;
    padding: 3.5px 17px; /* Preenchimento interno dos botões */
    font-size: 15px; /* Tamanho da fonte dos botões */
    background-color: #0F921C;
    color: #ffffff; /* Cor do texto dos botões */
    border: none; /* Remove a borda dos botões */
    border-radius: 8.89px; /* Borda arredondada dos botões */
    cursor: pointer;
    text-decoration: none;
    margin-left: 15px;

}

.visualizar:hover {
    background-color: #37B944; /* Cor de fundo dos botões ao passar o mouse */
    color: #FFE500;
}

.voltar{
    justify-content: center;
    align-items: flex-start;
    width: 52.5%;
    margin-top: 20px; 
}
.voltar:hover{
    
}

.voltar a i {
    margin-right: 10px; 
}

.voltar_btn {
    color: #35383F; /* Cor padrão do botão */
    text-decoration: none; /* Remove o sublinhado */
    font-weight: 500;
    font-size: 25px;
    padding: 10px 13px;
}

.voltar_btn:hover {
    color: #35383F;
    text-decoration: none; /* Remove o sublinhado */
    background-color: #f1f1f138;
    border-radius: 8.89px;
}
</style>

</head>
<body>

<?php
// Conexão com o banco de dados
$conn = mysqli_connect("localhost", "root", "12345", "emprega_mais");
if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
}

// Verifica se o id da vaga foi enviado via GET
$id_vaga = isset($_GET['id']) ? $_GET['id'] : '';

if (!empty($id_vaga)) {
    // Busca as informações da vaga com base no ID
    $sql_vaga = "SELECT id, nome, empresa FROM vagas WHERE id = ?";
    $stmt = $conn->prepare($sql_vaga);
    $stmt->bind_param("i", $id_vaga);
    $stmt->execute();
    $result_vaga = $stmt->get_result();

    if ($result_vaga->num_rows > 0) {
        $vaga = $result_vaga->fetch_assoc();
        echo "<div class='infos'>";
            echo "<p class='vaga-id'>ID da vaga: " . htmlspecialchars($vaga['id']) . "</p>";
            echo "<p class='nome-id'>Vaga: " . htmlspecialchars($vaga['nome']) . "</p>";  
            echo "<p class='empresa-id'>Empresa: " . htmlspecialchars($vaga['empresa']) . "</p>";
        echo "</div>";
    } else {
        echo "<p>Vaga não encontrada.</p>"; // Mensagem clara se a vaga não for encontrada
    }
    $stmt->close();
}
?>

<!-- Caixa de pesquisa -->
<form method="GET" action="">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id_vaga); ?>">
    <div class="caixa_pesquisar">
        <i class="fa fa-search"></i>
        <input class="input_pesquisar" type="text" placeholder="Pesquisar" name="pesquisar" id="pesquisar">        
    </div>           
    <div class="botao_buscar">
        <button type="submit">Buscar</button>
    </div>
</form>


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
    // Adiciona a cláusula WHERE para buscar em nome_completo, cpf, data_nascimento ou genero
    $sql .= " WHERE nome_completo LIKE '%$pesquisa%' 
            OR cpf LIKE '%$pesquisa%' 
            OR data_nascimento LIKE '%$pesquisa%' 
            OR genero LIKE '%$pesquisa%'";
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
                    <a href="../candidates/c_perfil_candidato.php?id=' . htmlspecialchars($row['id']) . '&id_vaga=' . htmlspecialchars($id_vaga) . '" class="btn visualizar" role="button">Visualizar</a>
                </td>
            </tr>';
            $index++;
        }
    }

    echo '</tbody></table>';

    // Botão de Voltar
    echo '<div class="voltar">
        <a href="../candidates/candidatos.php" class="voltar_btn">
            <i class="fa-regular fa-circle-left"></i> Voltar
        </a>
    </div>';
} else {
    echo "<p>0 resultados.</p>";
}

$conn->close();



?>

</body>
</html>
