<?php
// Certifique-se de que esta linha seja a primeira do arquivo
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['cpf'])) {
    header("Location: ../login/login.php");
    exit();
}
