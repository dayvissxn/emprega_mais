<?php
session_start();
include('adp_conexao.php');

if (isset($_SESSION['id_usuario'])) {
    $id_usuario = $_SESSION['id_usuario'];

    $sql = "SELECT caminho_fotoperfil FROM usuarios WHERE id = ?";
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id_usuario);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $caminho_foto);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($caminho_foto && file_exists($caminho_foto)) {
        unlink($caminho_foto);
    }

    $sql = "UPDATE usuarios SET caminho_fotoperfil = NULL WHERE id = ?";
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id_usuario);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $_SESSION['mensagem'] = "Foto de perfil removida com sucesso!";
    header("Location: alterar_dados_pessoais.php");
    exit();
}
?>
