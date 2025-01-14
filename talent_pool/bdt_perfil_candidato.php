<?php
// Conexão com o banco de dados
require 'bdt_conexao.php';

// Verifica se a conexão está estabelecida
if (!$conn) {
    die("Erro ao conectar com o banco de dados: " . mysqli_connect_error());
}

// Verifica se o ID do candidato foi passado na URL
if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    // Consulta para buscar os dados do usuário na tabela 'usuarios'
    $sql = "SELECT nome_completo, cpf, data_nascimento, telefone, email, genero, caminho_fotoperfil, experiencia_antecessora, caminho_curriculo
            FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    // Executa a consulta
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Define as variáveis de usuário
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
    echo "<p>ID do candidato não especificado.</p>";
    exit;
}

// Libera resultados e fecha a consulta
$stmt->close();
$conn->close();

// Exibe os dados do usuário
