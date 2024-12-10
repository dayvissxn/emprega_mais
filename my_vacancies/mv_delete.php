<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login/login.php");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

// Verifica se o ID da vaga foi enviado via POST
if (!isset($_POST['id_vaga'])) {
    echo "ID da vaga não fornecido.";
    exit();
}

$id_vaga = $_POST['id_vaga'];

// Conectar ao banco de dados
$conn = mysqli_connect("localhost", "root", "12345", "emprega_mais");

if (!$conn) {
    die("Erro ao conectar ao banco de dados: " . mysqli_connect_error());
}

// Busca o nome da vaga para criar o nome da tabela correspondente
$sql_get_nome_vaga = "SELECT nome FROM vagas WHERE id = ?";
$stmt = $conn->prepare($sql_get_nome_vaga);
$stmt->bind_param("i", $id_vaga);
$stmt->execute();
$result_nome_vaga = $stmt->get_result();

if ($result_nome_vaga->num_rows > 0) {
    $row_vaga = $result_nome_vaga->fetch_assoc();
    $nome_vaga = $row_vaga['nome'];
} else {
    echo "Vaga não encontrada.";
    $stmt->close();
    $conn->close();
    exit();
}

// Gerar o nome da tabela da vaga
$nome_tabela_vaga = "vaga_" . $id_vaga . "_" . preg_replace('/[^a-zA-Z0-9_]/', '', str_replace(' ', '_', $nome_vaga));

// Verifica se o usuário está inscrito na vaga
$sql_check_inscrito = "SELECT * FROM $nome_tabela_vaga WHERE id_usuario = ?";
$stmt_check = $conn->prepare($sql_check_inscrito);
$stmt_check->bind_param("i", $id_usuario);
$stmt_check->execute();
$result_inscrito = $stmt_check->get_result();

if ($result_inscrito->num_rows > 0) {
    // Deleta o registro do usuário da tabela da vaga
    $sql_delete = "DELETE FROM $nome_tabela_vaga WHERE id_usuario = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $id_usuario);

    if ($stmt_delete->execute()) {
        // Recupera o CPF do usuário para criar o nome da tabela correspondente
        $sql_get_cpf_usuario = "SELECT cpf FROM usuarios WHERE id = ?";
        $stmt_cpf = $conn->prepare($sql_get_cpf_usuario);
        $stmt_cpf->bind_param("i", $id_usuario);
        $stmt_cpf->execute();
        $result_cpf = $stmt_cpf->get_result();

        if ($result_cpf->num_rows > 0) {
            $row_usuario = $result_cpf->fetch_assoc();
            $cpf_usuario = $row_usuario['cpf'];
            $cpf_modificado = str_replace(['.', '-'], '_', $cpf_usuario);
            $nome_tabela_usuario = "usuario_" . $id_usuario . "_" . $cpf_modificado;

            // Deletar a vaga da tabela do usuário
            $sql_delete_usuario_vaga = "DELETE FROM $nome_tabela_usuario WHERE id_vaga = ?";
            $stmt_delete_usuario_vaga = $conn->prepare($sql_delete_usuario_vaga);
            $stmt_delete_usuario_vaga->bind_param("i", $id_vaga);

            if ($stmt_delete_usuario_vaga->execute()) {
                // Inscrição cancelada com sucesso
                header("Location: minhas_vagas.php?msg=inscricao_deletada");
                exit();
            } else {
                echo "Erro ao cancelar a inscrição na tabela do usuário: " . $stmt_delete_usuario_vaga->error;
            }
        } else {
            echo "Usuário não encontrado.";
        }
    } else {
        echo "Erro ao cancelar a inscrição: " . $stmt_delete->error;
    }
} else {
    echo "Você não está inscrito nesta vaga.";
}

// Fechar as instruções e a conexão
$stmt->close();
$stmt_check->close();
if (isset($stmt_delete)) {
    $stmt_delete->close();
}
if (isset($stmt_delete_usuario_vaga)) {
    $stmt_delete_usuario_vaga->close();
}
$conn->close();
?>
