<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['nome_completo'])) {
    unset($_SESSION['id_usuario']);
    unset($_SESSION['nome_completo']);
    header("Location: ../login/login.php");
    exit();
}

$logado = $_SESSION['nome_completo'];
$primeiro_nome = explode(' ', $logado)[0];
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
    header("Location: ../login/login.php");
    exit();
}

// Fechar a declaração
$stmt->close();

$error_message = '';

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $senha_antiga = $_POST['senha'];
    $nova_senha = $_POST['nova_senha'];
    $confirmar_senha = $_POST['confirmarsenha'];

    // Verificar se as senhas são iguais
    if ($nova_senha !== $confirmar_senha) {
        $error_message = "As novas senhas não coincidem.";
    } else {
        // Consulta para verificar a senha antiga no banco de dados
        $sql_code = "SELECT senha FROM usuarios WHERE id = ?";
        $stmt = $mysqli->prepare($sql_code);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $stmt->bind_result($senha_atual);
        $stmt->fetch();
        $stmt->close();

        // Verificar se a senha antiga está correta
        if ($senha_antiga === $senha_atual) {
            // Atualizar a nova senha no banco de dados
            $sql_update = "UPDATE usuarios SET senha = ? WHERE id = ?";
            $stmt_update = $mysqli->prepare($sql_update);
            $stmt_update->bind_param("si", $nova_senha, $id_usuario);

            if ($stmt_update->execute()) {
                header("Location: alterar_senha_html.php?message=Senha alterada com sucesso!");
                exit();
            } else {
                $error_message = "Erro ao atualizar a senha. Tente novamente.";
            }

            $stmt_update->close();
        } else {
            $error_message = "A senha antiga está incorreta.";
        }
    }
}
