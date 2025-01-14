<?php
include('conexao_login.php');

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['cpf']) && isset($_POST['senha'])) {
        if (strlen($_POST['cpf']) == 0) {
            $error_message = "Preencha seu CPF";
        } else if (strlen($_POST['senha']) == 0) {
            $error_message = "Preencha sua Senha";
        } else {
            $cpf = $mysqli->real_escape_string($_POST['cpf']);
            $senha = $mysqli->real_escape_string($_POST['senha']);

            $sql_code = "SELECT * FROM usuarios WHERE cpf = '$cpf' AND senha = '$senha'";
            $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

            $quantidade = $sql_query->num_rows;

            if ($quantidade == 1) {
                $usuario = $sql_query->fetch_assoc();

                if (!isset($_SESSION)) {
                    session_start();
                }

                $_SESSION['id_usuario'] = $usuario['id'];
                $_SESSION['nome_completo'] = $usuario['nome_completo'];
                $_SESSION['cpf'] = $usuario['cpf'];
                $_SESSION['telefone'] = $usuario['telefone'];
                $_SESSION['data_nascimento'] = $usuario['data_nascimento'];
                $_SESSION['genero'] = $usuario['genero'];
                $_SESSION['email'] = $usuario['email'];
                $_SESSION['experiencia_antecessora'] = $usuario['experiencia_antecessora'];
                $_SESSION['caminho_curriculo'] = $usuario['caminho_curriculo'];
                $_SESSION['caminho_fotoperfil'] = $usuario['caminho_fotoperfil'];

                header("Location: ../home_loggedin/logged_in_html.php");
                exit(); // Certifique-se de que a execução do script pare após o redirecionamento
            } else {
                $error_message = "Falha ao logar! CPF ou Senha incorretos";
            }
        }
    }
}
