<?php
// Conexão com o banco de dados
$conn = mysqli_connect("localhost", "root", "12345", "emprega_mais");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verifica se o ID foi enviado
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Primeiro, busca o CPF do usuário para gerar o nome da tabela
    $sql_get_cpf = "SELECT cpf FROM usuarios WHERE id = ?";
    $stmt_get_cpf = $conn->prepare($sql_get_cpf);
    $stmt_get_cpf->bind_param("i", $id);
    $stmt_get_cpf->execute();
    $stmt_get_cpf->bind_result($cpf);

    // Obtém o CPF e libera o resultado
    if ($stmt_get_cpf->fetch()) {
        $stmt_get_cpf->close(); // Fecha o statement
       
        // Modifica o CPF para gerar o nome da tabela
        $cpf_modificado = str_replace(['.', '-'], '_', $cpf);
        $nome_tabela = "usuario_" . $id . "_" . $cpf_modificado;

        // Agora, exclui a tabela do usuário
        $sql_drop_table = "DROP TABLE IF EXISTS $nome_tabela";
        if ($conn->query($sql_drop_table) === TRUE) {
            echo "Tabela do usuário excluída com sucesso!";
        } else {
            echo "Erro ao excluir a tabela do usuário: " . $conn->error;
        }
    } else {
        echo "Usuário não encontrado.";
        $stmt_get_cpf->close();
        $conn->close();
        exit();
    }

    // Query de exclusão do usuário
    $sql = "DELETE FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo "Usuário excluído com sucesso!";
    } else {
        echo "Erro ao excluir o usuário: " . $conn->error;
    }
    
    $stmt->close();
    header("Location: banco_de_talentos.php");
    exit();
} else {
    echo "ID do usuário não informado.";
}

$conn->close();
?>
