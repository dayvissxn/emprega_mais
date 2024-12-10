<?php
session_start();
header('Content-Type: application/json');

// Verifica se o usuário está logado e se as variáveis de sessão estão definidas
if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['nome_completo'])) {
    echo json_encode(['status' => 'error', 'message' => 'Usuário não autenticado.']);
    exit();
}

$id_usuario = $_SESSION['id_usuario'];
$nome_completo = isset($_SESSION['nome_completo']) ? $_SESSION['nome_completo'] : 'Nome não definido';
$cpf = isset($_SESSION['cpf']) ? $_SESSION['cpf'] : '';  
$telefone = isset($_SESSION['telefone']) ? $_SESSION['telefone'] : '';
$data_nascimento = isset($_SESSION['data_nascimento']) ? $_SESSION['data_nascimento'] : '';
$genero = isset($_SESSION['genero']) ? $_SESSION['genero'] : '';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$experiencia_antecessora = isset($_SESSION['experiencia_antecessora']) ? $_SESSION['experiencia_antecessora'] : '';
$caminho_curriculo = isset($_SESSION['caminho_curriculo']) ? $_SESSION['caminho_curriculo'] : '';
$caminho_fotoperfil = isset($_SESSION['caminho_fotoperfil']) ? $_SESSION['caminho_fotoperfil'] : '';

// Conectar ao banco de dados
$conn = mysqli_connect("localhost", "root", "12345", "emprega_mais");
if (!$conn) {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao conectar ao banco de dados: ' . mysqli_connect_error()]);
    exit();
}

// Recupera dados do formulário
$id_vaga = $_POST['id_vaga'];

// Gerar o nome da tabela da vaga
$sql_get_nome_vaga = "SELECT nome, tipo, disponivel, quantidade_vagas, escolaridade, empresa, localidade, carga_horaria, descricao_vaga FROM vagas WHERE id = $id_vaga";
$result_nome_vaga = $conn->query($sql_get_nome_vaga);
$row_vaga = $result_nome_vaga->fetch_assoc();
$nome_vaga = $row_vaga['nome'];

// Criar nome da tabela da vaga
$nome_tabela_vaga = "vaga_" . $id_vaga . "_" . preg_replace('/[^a-zA-Z0-9_]/', '', str_replace(' ', '_', $nome_vaga));

// Verifica se a tabela da vaga já existe
$sql_check_table = "CREATE TABLE IF NOT EXISTS $nome_tabela_vaga (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    nome_completo VARCHAR(100) NOT NULL,
    cpf VARCHAR(14) NOT NULL,
    telefone VARCHAR(15) NOT NULL,
    data_nascimento TEXT NOT NULL,
    genero VARCHAR(10) NOT NULL,
    caminho_curriculo VARCHAR(255) DEFAULT NULL,
    caminho_fotoperfil VARCHAR(255) DEFAULT NULL,
    experiencia_antecessora TEXT NOT NULL,
    email VARCHAR(100) DEFAULT NULL,
    CONSTRAINT fk_usuario_$id_vaga FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE ON UPDATE CASCADE
)";

// Executa a criação da tabela da vaga
if ($conn->query($sql_check_table) !== TRUE) {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao criar tabela: ' . $conn->error]);
    exit();
}

// Verifica se o usuário já está inscrito na vaga
$sql_check_inscrito = "SELECT * FROM $nome_tabela_vaga WHERE id_usuario = '$id_usuario'";
$result_inscrito = $conn->query($sql_check_inscrito);

if ($result_inscrito->num_rows > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Você já está inscrito nesta vaga.']);
} else {
    // Insere os dados do candidato na tabela da vaga
    $sql_insert_candidato = "INSERT INTO $nome_tabela_vaga (id_usuario, nome_completo, cpf, telefone, data_nascimento, genero, email, experiencia_antecessora, caminho_curriculo, caminho_fotoperfil)
        VALUES ('$id_usuario', '$nome_completo', '$cpf', '$telefone', '$data_nascimento', '$genero', '$email', '$experiencia_antecessora', '$caminho_curriculo', '$caminho_fotoperfil')";

    if ($conn->query($sql_insert_candidato) === TRUE) {
        // Insere os dados da vaga na tabela personalizada do usuário
        $cpf_modificado = str_replace(['.', '-'], '_', $cpf);
        $nome_tabela_usuario = "usuario_" . $id_usuario . "_" . $cpf_modificado;

        // Cria a tabela do usuário, se ainda não existir
        $sql_create_table_usuario = "CREATE TABLE IF NOT EXISTS $nome_tabela_usuario (
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
            CONSTRAINT fk_vaga_{$id_usuario} FOREIGN KEY (id_vaga) REFERENCES vagas(id) ON DELETE CASCADE ON UPDATE CASCADE
        )";

        if ($conn->query($sql_create_table_usuario) === TRUE) {
            // Insere os dados da vaga na tabela do usuário
            $sql_insert_vaga_usuario = "INSERT INTO $nome_tabela_usuario (id_vaga, nome, tipo, disponivel, quantidade_vagas, escolaridade, empresa, localidade, carga_horaria, descricao_vaga)
                VALUES ('$id_vaga', '{$row_vaga['nome']}', '{$row_vaga['tipo']}', '{$row_vaga['disponivel']}', '{$row_vaga['quantidade_vagas']}', '{$row_vaga['escolaridade']}', '{$row_vaga['empresa']}', '{$row_vaga['localidade']}', '{$row_vaga['carga_horaria']}', '{$row_vaga['descricao_vaga']}')";

            if ($conn->query($sql_insert_vaga_usuario) === TRUE) {
                // Define uma variável de sessão para indicar que a inscrição foi bem-sucedida
                $_SESSION['inscrito_' . $id_vaga] = true;
                echo json_encode(['status' => 'success', 'message' => 'Inscrição realizada com sucesso.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Erro ao inserir os dados da vaga na tabela do usuário: ' . $conn->error]);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Erro ao criar a tabela do usuário: ' . $conn->error]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erro ao candidatar-se: ' . $conn->error]);
    }
}

$conn->close();
?>
