<?php
session_start();
include('ec_conexao.php'); // Certifique-se de que este arquivo contém a conexão com o banco de dados

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_usuario = $_SESSION['id_usuario'];
    $senha_digitada = $_POST['senha'];

    // Query para buscar a senha e o CPF do usuário no banco de dados
    $sql = "SELECT senha, cpf FROM usuarios WHERE id = '$id_usuario'";
    $result = mysqli_query($mysqli, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $dados_usuario = mysqli_fetch_assoc($result);
        $senha_armazenada = $dados_usuario['senha'];
        $cpf_usuario = $dados_usuario['cpf']; // Obtenha o CPF

        // Verificar se a senha digitada corresponde à senha armazenada
        if ($senha_digitada === $senha_armazenada) { // Comparação direta
            // Senha correta, prosseguir com a exclusão
            // Exclui o usuário
            $sql = "DELETE FROM usuarios WHERE id = '$id_usuario'";
            if (mysqli_query($mysqli, $sql)) {
                // Exclui a tabela correspondente ao usuário
                $cpf_modificado = str_replace(['.', '-'], '_', $cpf_usuario); // Formata o CPF
                $nome_tabela = "usuario_" . $id_usuario . "_" . $cpf_modificado; // Nome da tabela

                $sql_delete_table = "DROP TABLE IF EXISTS $nome_tabela";
                mysqli_query($mysqli, $sql_delete_table); // Tenta excluir a tabela

                // Se a exclusão do usuário for bem-sucedida, deslogar o usuário e redirecioná-lo
                unset($_SESSION['id']);
                unset($_SESSION['nome_completo']);
                session_destroy(); // Destrói a sessão

                // Redirecionar para uma página de confirmação ou página inicial
                header("Location: ../login/login.php");
                exit();
            } else {
                $_SESSION['mensagem'] = "Erro ao excluir a conta: " . mysqli_error($mysqli);
                $_SESSION['tipo_mensagem'] = "erro";
                header("Location: excluir_conta.php");
                exit();
            }
        } else {
            // Senha incorreta, exibir mensagem de erro
            $_SESSION['mensagem'] = "Senha incorreta. Por favor, tente novamente.";
            $_SESSION['tipo_mensagem'] = "erro";
            header("Location: excluir_conta.php");
            exit();
        }
    } else {
        $_SESSION['mensagem'] = "Erro ao buscar a conta. Por favor, tente novamente.";
        $_SESSION['tipo_mensagem'] = "erro";
        header("Location: excluir_conta.php");
        exit();
    }

    mysqli_close($mysqli);
} else {
    header("Location: excluir_conta.php");
    exit();
}
?>
