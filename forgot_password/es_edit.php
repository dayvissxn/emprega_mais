<?php
session_start();
require_once 'es_conexao.php';

if (!isset($_SESSION['id_usuario'])) {
    // Se o ID do usuário não estiver na sessão, redirecionar para a página de login
    header("Location: ../login/login_html.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Remove password_hash() para armazenar a senha em texto claro
    $nova_senha = $_POST['nova_senha'];
    $id_usuario = $_SESSION['id_usuario'];

    // Atualizar a senha no banco de dados
    $stmt = $conn->prepare("UPDATE usuarios SET senha = ? WHERE id = ?");
    $stmt->bind_param("si", $nova_senha, $id_usuario);

    if ($stmt->execute()) {
        // Senha alterada com sucesso
        echo "<script>alert('Senha alterada com sucesso!'); window.location.href='../login/login_html.php';</script>";
        session_destroy(); // Destroi a sessão após a alteração da senha
    } else {
        echo "<script>alert('Erro ao alterar a senha. Tente novamente.'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
