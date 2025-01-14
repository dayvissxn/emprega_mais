<?php
// Conexão com o banco de dados
require 'c_conexao.php';

// Verifica se o ID da vaga e o ID do usuário foram passados na URL
if (isset($_GET['id']) && isset($_GET['id_vaga'])) {
    $id = (int) $_GET['id'];
    $id_vaga = (int) $_GET['id_vaga'];

    // Consulta para buscar o nome da vaga
    $sql_vaga = "SELECT nome FROM vagas WHERE id = ?";
    $stmt_vaga = $conn->prepare($sql_vaga);
    $stmt_vaga->bind_param("i", $id_vaga);
    $stmt_vaga->execute();
    $result_vaga = $stmt_vaga->get_result();

    if ($result_vaga->num_rows > 0) {
        $vaga = $result_vaga->fetch_assoc();
        // Monta o nome da tabela de candidatos
        $candidatos_table_name = "vaga_" . $id_vaga . "_" . preg_replace('/[^a-zA-Z0-9_]/', '', str_replace(' ', '_', $vaga['nome']));
    } else {
        echo "<p>Vaga não encontrada.</p>";
        exit;
    }

    // Consulta para buscar os dados do usuário na tabela usuarios
    $sql = "SELECT nome_completo, cpf, data_nascimento, telefone, email, genero, caminho_fotoperfil, experiencia_antecessora, caminho_curriculo
            FROM usuarios WHERE id = ?";

    // Preparando a consulta
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    // Executa a consulta
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nome_completo = $row['nome_completo'];
        $cpf = $row['cpf'];
        $data_nascimento = $row['data_nascimento'];
        $telefone = $row['telefone'];
        $email = $row['email'];
        $genero = $row['genero'];
        $caminho_fotoperfil = $row['caminho_fotoperfil'];
        $experiencia_antecessora = $row['experiencia_antecessora'];
        $caminho_curriculo = $row['caminho_curriculo'];
    } else {
        echo "<p>Candidato não encontrado.</p>";
        exit;
    }
} else {
    echo "<p>ID do candidato ou ID da vaga não especificados.</p>";
    exit;
}
