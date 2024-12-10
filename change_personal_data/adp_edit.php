<?php
session_start();
include('adp_conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verifica se o ID do usuário está na sessão
    if (isset($_SESSION['id_usuario'])) {
        $id_usuario = $_SESSION['id_usuario']; // Mantém consistência com o nome da sessão

        // Sanitizar os dados de entrada para evitar problemas de segurança
        $nome_completo = mysqli_real_escape_string($mysqli, trim($_POST['nomecompleto']));
        $email = mysqli_real_escape_string($mysqli, trim($_POST['email']));
        $data_nascimento = mysqli_real_escape_string($mysqli, date('Y-m-d', strtotime(str_replace('/', '-', $_POST['datanascimento']))));
        $genero = mysqli_real_escape_string($mysqli, trim($_POST['genero']));
        $telefone = mysqli_real_escape_string($mysqli, trim($_POST['telefone']));

        // Usar prepared statements para evitar SQL Injection
        $sql = "UPDATE usuarios SET nome_completo = ?, email = ?, data_nascimento = ?, genero = ?, telefone = ? WHERE id = ?";
        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($stmt, 'sssssi', $nome_completo, $email, $data_nascimento, $genero, $telefone, $id_usuario);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['mensagem'] = "Dados atualizados com sucesso!";
            $_SESSION['tipo_mensagem'] = "sucesso";
        } else {
            $_SESSION['mensagem'] = "Erro ao atualizar dados: " . mysqli_error($mysqli);
            $_SESSION['tipo_mensagem'] = "erro";
        }

        // Fechar a declaração preparada e a conexão
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        // Redirecionar de volta para a página de alteração de dados
        header("Location: alterar_dados_pessoais.php");
        exit();
    } else {
        $_SESSION['mensagem'] = "Sessão expirada. Faça login novamente.";
        $_SESSION['tipo_mensagem'] = "erro";
        header("Location: ../login/login.php");
        exit();
    }
}
?>
