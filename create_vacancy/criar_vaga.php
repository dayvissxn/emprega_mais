<?php
$conexao = mysqli_connect("localhost", "root", "12345", "emprega_mais");

// Checar conexão
if (!$conexao) {
    die("NÃO CONECTADO: " . mysqli_connect_error());
}

// Verifica se a requisição é POST (indicando que o formulário foi submetido)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Prepara a instrução SQL para evitar SQL injection
    $stmt = $conexao->prepare("INSERT INTO vagas (nome, tipo, disponivel, quantidade_vagas, escolaridade, empresa, localidade, carga_horaria, descricao_vaga) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $nome, $tipo, $disponivel, $quantidade_vagas, $escolaridade, $empresa, $localidade, $carga_horaria, $descricao_vaga);

    // Define os valores dos parâmetros
    $nome = $_POST['nome'];
    $tipo = $_POST['tipo'];
    $disponivel = $_POST['disponivel'];
    $quantidade_vagas = $_POST['quantidade_vagas'];
    $escolaridade = $_POST['escolaridade'];
    $empresa = $_POST['empresa'];
    $localidade = $_POST['localidade'];
    $carga_horaria = $_POST['carga_horaria'];
    $descricao_vaga = $_POST['descricao'];

// Executa a instrução SQL
if ($stmt->execute()) {
    // Recupera o ID da vaga recém-criada
    $vaga_id = $conexao->insert_id;

    // Cria o nome da nova tabela usando o ID e o nome da vaga
    $nome_tabela = "vaga_" . $vaga_id . "_" . preg_replace('/[^a-zA-Z0-9_]/', '', str_replace(' ', '_', $nome));

    // Instrução SQL para criar uma nova tabela
    $sql_create_table = "CREATE TABLE IF NOT EXISTS $nome_tabela (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        id_usuario INT NOT NULL,
        nome_completo VARCHAR(100) NOT NULL,
        cpf VARCHAR(14) NOT NULL,
        telefone VARCHAR(15) NOT NULL,
        data_nascimento TEXT NOT NULL,
        genero VARCHAR(10) NOT NULL,
        caminho_curriculo VARCHAR(255) DEFAULT NULL,
        caminho_fotoperfil VARCHAR(255) DEFAULT NULL,
        experiencia_antecessora TEXT NOT NULL,
        email VARCHAR(100) DEFAULT NULL,
        CONSTRAINT fk_usuario_{$vaga_id} FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE ON UPDATE CASCADE
    )";

    // Executa a instrução para criar a tabela
    if ($conexao->query($sql_create_table) === TRUE) {
        $message = "VAGA CRIADA COM SUCESSO!";
    } else {
        $message = "Vaga criada, mas erro ao criar tabela: " . $conexao->error;
    }
} else {
    $message = "Erro ao salvar os dados no banco de dados: " . $stmt->error;
}

// Fecha a instrução
$stmt->close();

// Redireciona com uma mensagem de sucesso ou erro
header("Location: criar_vaga.html?message=" . urlencode($message));
exit();
}

// Fecha a conexão com o banco de dados
$conexao->close();
?>