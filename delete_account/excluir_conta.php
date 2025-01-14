<?php
session_start();

if ((!isset($_SESSION['id_usuario']) == true) and (!isset($_SESSION['nome_completo']) == true)) {
    unset($_SESSION['id_usuario']);
    unset($_SESSION['nome_completo']);
    header("Location: ../login/login.php");
    exit();
}


$logado = $_SESSION['nome_completo'];
$primeiro_nome = explode(' ', $logado)[0]; // Pega a primeira parte do nome completo
$id_usuario = $_SESSION['id_usuario'];

// Conectar ao banco de dados (use sua conexão existente)
include('../login/conexao_login.php');

// Query para buscar os dados do usuário no banco de dados
$sql = "SELECT caminho_fotoperfil FROM usuarios WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $dados_usuario = $result->fetch_assoc();
    $caminho_fotoperfil = $dados_usuario['caminho_fotoperfil'];
} else {
    // Caso não encontre o usuário, redireciona para a página de login
    header("Location: ../login/login_html.php");
    exit();
}

// Fechar a declaração
$stmt->close();
?>