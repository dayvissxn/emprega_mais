<?php
session_start();

// Verificação correta das variáveis de sessão
if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['nome_completo'])) {
    header("Location: ../login/login.php");
    exit();
}

$logado = $_SESSION['nome_completo'];
$primeiro_nome = explode(' ', $logado)[0]; // Pega a primeira parte do nome completo

include('adp_conexao.php'); // Inclua a conexão com o banco de dados

$id_usuario = $_SESSION['id_usuario'];

// Query para buscar os dados do usuário no banco de dados
$sql = "SELECT nome_completo, email, data_nascimento, genero, telefone, caminho_fotoperfil FROM usuarios WHERE id = '$id_usuario'";
$result = mysqli_query($mysqli, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $dados_usuario = mysqli_fetch_assoc($result);

    $nome_completo = $dados_usuario['nome_completo'];
    $email = $dados_usuario['email'];
    $data_nascimento = $dados_usuario['data_nascimento'];
    $genero = $dados_usuario['genero'];
    $telefone = $dados_usuario['telefone'];
    $caminho_fotoperfil = $dados_usuario['caminho_fotoperfil'];
} else {
    // Caso não encontre o usuário, redireciona para a página de login
    header("Location: ../login/login_html.php");
    exit();
}

mysqli_close($mysqli);
?>