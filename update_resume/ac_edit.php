<?php
session_start();

// Verificação correta das variáveis de sessão
if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['cpf'])) {
    header("Location: ../login/login.php");
    exit();
}

include('ac_conexao.php'); // Inclua a conexão com o banco de dados

$id_usuario = $_SESSION['id_usuario'];
$cpf = $_SESSION['cpf']; // Certifique-se de que o CPF está armazenado na sessão

// Inicialize variáveis
$experiencia_antecessora = isset($_POST['experiencia']) ? trim($_POST['experiencia']) : '';
$caminho_curriculo = isset($_POST['caminho_curriculo']) ? $_POST['caminho_curriculo'] : '';

// Processamento do upload do currículo
if (isset($_FILES['enviarcurriculo']) && $_FILES['enviarcurriculo']['error'] == UPLOAD_ERR_OK) {
    // Define o caminho da pasta de usuários
    $pastaUsuarios = "../usuarios/";
    $pastaCPF = $pastaUsuarios . $cpf . "/curriculo/";

    // Verifica se a pasta "usuarios" existe, se não, cria a pasta
    if (!file_exists($pastaUsuarios)) {
        mkdir($pastaUsuarios, 0777, true);
    }

    // Verifica se a pasta com o CPF existe, se não, cria a pasta com o CPF
    if (!file_exists($pastaUsuarios . $cpf)) {
        mkdir($pastaUsuarios . $cpf, 0777, true);
    }

    // Verifica se a subpasta "curriculo" existe, se não, cria a pasta
    if (!file_exists($pastaCPF)) {
        mkdir($pastaCPF, 0777, true);
    }

    // Define o caminho completo do arquivo dentro da subpasta "curriculo"
    $caminho_curriculo = $pastaCPF . basename($_FILES["enviarcurriculo"]["name"]);

    // Move o arquivo para o diretório especificado
    if (move_uploaded_file($_FILES['enviarcurriculo']['tmp_name'], $caminho_curriculo)) {
        // O arquivo foi salvo com sucesso
    } else {
        // Tratamento de erro ao mover o arquivo
        echo "Erro ao salvar o arquivo. Tente novamente.";
        exit();
    }
}

// Atualizar a experiência anterior e o caminho do currículo no banco de dados
$sql = "UPDATE usuarios SET experiencia_antecessora = ?, caminho_curriculo = ? WHERE id = ?";
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt, 'ssi', $experiencia_antecessora, $caminho_curriculo, $id_usuario);

if (mysqli_stmt_execute($stmt)) {
    $_SESSION['mensagem'] = "Dados atualizados com sucesso!";
    $_SESSION['tipo_mensagem'] = "sucesso";
} else {
    $_SESSION['mensagem'] = "Erro ao atualizar dados: " . mysqli_error($mysqli);
    $_SESSION['tipo_mensagem'] = "erro";
}

// Fechar a conexão
mysqli_stmt_close($stmt);
mysqli_close($mysqli);

// Redirecionar para uma página de sucesso ou onde você desejar
header("Location: atualizar_curriculo.php"); // Altere para a página que deseja redirecionar após a atualização
exit();
?>
