<?php
session_start();

// Verifica se o usuário está logado e se as variáveis de sessão estão definidas
if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['nome_completo'])) {
    header("Location: ../login/login.php");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];
$nome_completo = $_SESSION['nome_completo'];
$cpf = isset($_SESSION['cpf']) ? $_SESSION['cpf'] : '';
$telefone = isset($_SESSION['telefone']) ? $_SESSION['telefone'] : '';
$data_nascimento = isset($_SESSION['data_nascimento']) ? $_SESSION['data_nascimento'] : '';
$genero = isset($_SESSION['genero']) ? $_SESSION['genero'] : '';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$experiencia_antecessora = isset($_SESSION['experiencia_antecessora']) ? $_SESSION['experiencia_antecessora'] : '';
$caminho_curriculo = isset($_SESSION['caminho_curriculo']) ? $_SESSION['caminho_curriculo'] : '';
$caminho_fotoperfil = isset($_SESSION['caminho_fotoperfil']) ? $_SESSION['caminho_fotoperfil'] : '';

// Conectar ao banco de dados (use sua conexão existente)
include('../login/conexao_login.php');

// Query para buscar os dados do usuário no banco de dados
$sql = "SELECT caminho_fotoperfil, tipo_usuario FROM usuarios WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $dados_usuario = $result->fetch_assoc();
    $caminho_fotoperfil = $dados_usuario['caminho_fotoperfil'];
    $tipo_usuario = $dados_usuario['tipo_usuario']; // Adiciona o tipo de usuário
} else {
    // Caso não encontre o usuário, redireciona para a página de login
    header("Location: ../login/login_html.php");
    exit();
}

// Verifica se o ID da vaga está definido
if (isset($_GET['id_vaga'])) {
    $id_vaga = $_GET['id_vaga'];

    // Gerar o nome da tabela da vaga
    $sql_get_nome_vaga = "SELECT nome FROM vagas WHERE id = ?";
    $stmt_nome_vaga = $mysqli->prepare($sql_get_nome_vaga);
    $stmt_nome_vaga->bind_param("i", $id_vaga);
    $stmt_nome_vaga->execute();
    $result_nome_vaga = $stmt_nome_vaga->get_result();

    if ($result_nome_vaga->num_rows > 0) {
        $row_vaga = $result_nome_vaga->fetch_assoc();
        $nome_vaga = $row_vaga['nome'];

        // Criar nome da tabela
        $nome_tabela = "vaga_" . $id_vaga . "_" . preg_replace('/[^a-zA-Z0-9_]/', '', str_replace(' ', '_', $nome_vaga));

        // Verifica se a tabela da vaga já existe
        $sql_check_table = "CREATE TABLE IF NOT EXISTS $nome_tabela (
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
            CONSTRAINT fk_usuario_$id_vaga FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE ON UPDATE CASCADE
        )";

        // Executa a criação da tabela
        if ($mysqli->query($sql_check_table) !== TRUE) {
            die("Erro ao criar tabela: " . $mysqli->error);
        }
    } else {
        die("Erro: ID da vaga não encontrado.");
    }
    $stmt_nome_vaga->close();
}

$mysqli->close();
