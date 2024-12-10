<?php
session_start();
include('adp_conexao.php');

if (isset($_SESSION['id_usuario'])) {
    $id_usuario = $_SESSION['id_usuario'];
    $cpf = $_SESSION['cpf']; // Certifique-se de que o CPF está na sessão
    $pastaFotoPerfil = "../usuarios/$cpf/fotoPerfil/";

    if (!file_exists($pastaFotoPerfil)) {
        mkdir($pastaFotoPerfil, 0777, true);
    }

    if (isset($_FILES['fotoPerfil']) && $_FILES['fotoPerfil']['error'] == UPLOAD_ERR_OK) {
        $caminho_foto = $pastaFotoPerfil . basename($_FILES['fotoPerfil']['name']);
        move_uploaded_file($_FILES['fotoPerfil']['tmp_name'], $caminho_foto);

        $sql = "UPDATE usuarios SET caminho_fotoperfil = ? WHERE id = ?";
        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($stmt, 'si', $caminho_foto, $id_usuario);
        mysqli_stmt_execute($stmt);

        $_SESSION['mensagem'] = "Foto de perfil atualizada com sucesso!";
    }
    header("Location: alterar_dados_pessoais.php");
    exit();

    // Exemplo de validação de tamanho e tipo de imagem
    $maxSize = 2 * 1024 * 1024; // 2MB
    $allowedTypes = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'];

    if ($_FILES['fotoPerfil']['size'] > $maxSize) {
        echo "A imagem deve ter menos de 2MB.";
    }

    if (!in_array($_FILES['fotoPerfil']['type'], $allowedTypes)) {
        echo "Formato de imagem não suportado.";
    }
}
?>
