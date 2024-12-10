<?php
$conn = mysqli_connect("localhost", "root", "12345", "emprega_mais");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Recuperar o nome da vaga antes de excluí-la
    $sql_nome_vaga = "SELECT nome FROM vagas WHERE id='$id'";
    $result = $conn->query($sql_nome_vaga);

    if ($result->num_rows > 0) {
        // Obter o nome da vaga
        $row = $result->fetch_assoc();
        $nome_vaga = $row['nome'];

        // Gerar o nome da tabela correspondente à vaga
        $nome_tabela = "vaga_" . $id . "_" . preg_replace('/[^a-zA-Z0-9_]/', '', str_replace(' ', '_', $nome_vaga));

        // Excluir a vaga
        $sql_delete_vaga = "DELETE FROM vagas WHERE id='$id'";
        if ($conn->query($sql_delete_vaga) === TRUE) {
            echo "Vaga excluída com sucesso.";

            // Agora exclua a tabela correspondente
            $sql_delete_tabela = "DROP TABLE IF EXISTS $nome_tabela";
            if ($conn->query($sql_delete_tabela) === TRUE) {
                echo "Tabela correspondente $nome_tabela excluída com sucesso.";
            } else {
                echo "Erro ao excluir a tabela correspondente: " . $conn->error;
            }

        } else {
            echo "Erro ao excluir a vaga: " . $conn->error;
        }

    } else {
        echo "Vaga não encontrada.";
    }

    $conn->close();
    header("Location: atualizar_vaga.php");
    exit();
} else {
    echo "ID da vaga não especificado.";
}
?>

