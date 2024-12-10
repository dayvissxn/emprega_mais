<?php
$conexao = mysqli_connect("localhost", "root", "12345", "emprega_mais");

// Checar conexão
if (!$conexao) {
    die("NÃO CONECTADO: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cpf = $_POST['cpf'];
    $cpf = mysqli_real_escape_string($conexao, $cpf);
    $sql = "SELECT cpf FROM usuarios WHERE cpf='$cpf'";
    $retorno = mysqli_query($conexao, $sql);

    if (mysqli_num_rows($retorno) > 0) {
        $message = "CPF JÁ CADASTRADO!";
    } else {
        // Verifica se o arquivo foi enviado
        if (isset($_FILES["enviarcurriculo"]) && $_FILES["enviarcurriculo"]["error"] == 0) {
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
            $caminhoArquivo = $pastaCPF . basename($_FILES["enviarcurriculo"]["name"]);

            // Tenta mover o arquivo enviado para a pasta de currículos
            if (!move_uploaded_file($_FILES["enviarcurriculo"]["tmp_name"], $caminhoArquivo)) {
                $message = "Erro ao enviar o currículo.";
                header("Location: register.html?message=" . urlencode($message));
                exit();
            }
        } else {
            $caminhoArquivo = null;
        }

        // Prepara a instrução SQL para evitar SQL injection
        $stmt = $conexao->prepare("INSERT INTO usuarios (nome_completo, cpf, senha, telefone, data_nascimento, genero, caminho_curriculo, experiencia_antecessora, pergunta1, pergunta2, pergunta3, pergunta4) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssssss", $nome_completo, $cpf, $senha, $telefone, $data_nascimento, $genero, $caminhoArquivo, $experiencia_antecessora, $pergunta1, $pergunta2, $pergunta3, $pergunta4);

        // Define os valores dos parâmetros
        $nome_completo = $_POST['nomecompleto'];
        $senha = $_POST['senha'];
        $telefone = $_POST['telefone'];
        $data_nascimento = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['datanascimento'])));
        $genero = $_POST['genero'];
        $experiencia_antecessora = $_POST['experiencia'];
        $pergunta1 = $_POST['pergunta1'];
        $pergunta2 = $_POST['pergunta2'];
        $pergunta3 = $_POST['pergunta3'];
        $pergunta4 = $_POST['pergunta4'];

        // Executa a instrução SQL
        if ($stmt->execute()) {
            $usuario_id = $conexao->insert_id;

            $cpf_modificado = str_replace(['.', '-'], '_', $cpf);

            $nome_tabela = "usuario_" . $usuario_id . "_" . $cpf_modificado;

            $sql_create_table = "CREATE TABLE IF NOT EXISTS $nome_tabela (
                id INT(11) AUTO_INCREMENT PRIMARY KEY,
                id_vaga INT NOT NULL,
                nome TEXT,
                tipo TEXT,
                disponivel TEXT,
                quantidade_vagas TEXT,
                escolaridade TEXT,
                empresa TEXT,
                localidade TEXT,
                carga_horaria TEXT,
                descricao_vaga TEXT,
                CONSTRAINT fk_vaga_{$usuario_id} FOREIGN KEY (id_vaga) REFERENCES vagas(id) ON DELETE CASCADE ON UPDATE CASCADE 
            )";

            if ($conexao->query($sql_create_table) === TRUE) {
                $message = "CONTA CRIADA COM SUCESSO!";
                if ($caminhoArquivo) {
                    $message .= " O currículo foi enviado com sucesso!";
                }
            } else {
                $message = "" . $conexao->error;
            }
        } else {
            $message = "" . $stmt->error;
        }

        $stmt->close();
    }

    header("Location: register.html?message=" . urlencode($message));
    exit();
}

$conexao->close();
?>
