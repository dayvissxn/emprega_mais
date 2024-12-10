<?php
session_start();
require_once 'es_conexao.php'; // Inclua o arquivo de conexão aqui

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cpf = $_POST['cpf'];
    $pergunta = $_POST['pergunta'];
    $resposta = $_POST['resposta'];

    // Verifica se uma pergunta foi selecionada
    if (empty($pergunta)) {
        $_SESSION['erro'] = 'Por favor, selecione uma pergunta.';
        header('Location: esqueceu_senha.php');
        exit();
    }

    // Define a coluna da resposta com base na pergunta selecionada
    switch ($pergunta) {
        case 'pergunta1':
            $coluna_resposta = 'pergunta1';
            break;
        case 'pergunta2':
            $coluna_resposta = 'pergunta2';
            break;
        case 'pergunta3':
            $coluna_resposta = 'pergunta3';
            break;
        case 'pergunta4':
            $coluna_resposta = 'pergunta4';
            break;
        default:
            $_SESSION['erro'] = 'Pergunta inválida. Tente novamente.';
            header('Location: esqueceu_senha.php');
            exit();
    }

    // Verifica no banco de dados
    $stmt = $conn->prepare("SELECT id, $coluna_resposta AS resposta_correta FROM usuarios WHERE cpf = ?");
    $stmt->bind_param("s", $cpf);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verifica se a resposta está correta
        if (trim($row['resposta_correta']) === trim($resposta)) { // Utilizando trim() para evitar espaços
            $_SESSION['id_usuario'] = $row['id'];
            header("Location: es_edit.php");
            exit();
        } else {
            $_SESSION['erro'] = 'Resposta incorreta. Tente novamente.';
            header('Location: esqueceu_senha.php');
            exit();
        }
    } else {
        $_SESSION['erro'] = 'CPF inválido.';
        header('Location: esqueceu_senha.php');
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>
