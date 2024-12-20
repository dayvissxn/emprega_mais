<?php
session_start();

// Verifica se o usuário está logado e se as variáveis de sessão estão definidas
if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['nome_completo'])) {
    header("Location: ../login/login.php");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];
$nome_completo = $_SESSION['nome_completo'];
$cpf = isset($_SESSION['cpf']) ? $_SESSION['cpf'] : '';
$telefone = isset($_SESSION['telefone']) ? $_SESSION['telefone'] : '';
$data_nascimento = isset($_SESSION['data_nascimento']) ? $_SESSION['data_nascimento'] : '';
$genero = isset($_SESSION['genero']) ? $_SESSION['genero'] : '';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$experiencia_antecessora = isset($_SESSION['experiencia_antecessora']) ? $_SESSION['experiencia_antecessora'] : '';
$caminho_curriculo = isset($_SESSION['caminho_curriculo']) ? $_SESSION['caminho_curriculo'] : '';
$caminho_fotoperfil = isset($_SESSION['caminho_fotoperfil']) ? $_SESSION['caminho_fotoperfil'] : '';

// Conectar ao banco de dados (use sua conexão existente)
include('../login/conexao_login.php');

// Query para buscar os dados do usuário no banco de dados
$sql = "SELECT caminho_fotoperfil FROM usuarios WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $dados_usuario = $result->fetch_assoc();
    $caminho_fotoperfil = $dados_usuario['caminho_fotoperfil'];
} else {
    // Caso não encontre o usuário, redireciona para a página de login
    header("Location: ../login/login.php");
    exit();
}

// Verifica se o ID da vaga está definido
if (isset($_GET['id_vaga'])) {
    $id_vaga = $_GET['id_vaga'];

    // Gerar o nome da tabela da vaga
    $sql_get_nome_vaga = "SELECT nome FROM vagas WHERE id = ?";
    $stmt_nome_vaga = $mysqli->prepare($sql_get_nome_vaga);
    $stmt_nome_vaga->bind_param("i", $id_vaga);
    $stmt_nome_vaga->execute();
    $result_nome_vaga = $stmt_nome_vaga->get_result();

    if ($result_nome_vaga->num_rows > 0) {
        $row_vaga = $result_nome_vaga->fetch_assoc();
        $nome_vaga = $row_vaga['nome'];

        // Criar nome da tabela
        $nome_tabela = "vaga_" . $id_vaga . "_" . preg_replace('/[^a-zA-Z0-9_]/', '', str_replace(' ', '_', $nome_vaga));

        // Verifica se a tabela da vaga já existe
        $sql_check_table = "CREATE TABLE IF NOT EXISTS $nome_tabela (
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

        // Executa a criação da tabela
        if ($mysqli->query($sql_check_table) !== TRUE) {
            die("Erro ao criar tabela: " . $mysqli->error);
        }
    } else {
        die("Erro: ID da vaga não encontrado.");
    }
    $stmt_nome_vaga->close();
}

$mysqli->close();
?>




<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CODIGO DA FONTE -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <!-- FIM DO CODIGO DA FONTE  -->
     
    <!-- Adicionar Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- Fim do código para Font Awesome -->

    <link rel="stylesheet" type="text/css"  media="screen">
    <title>Logged in</title>

    <style>

*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Ubuntu", sans-serif;
    font-weight: 700;
}

body {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

/* Inicio HEADER */
header { 
    display: flex;
    justify-content: space-around;
    align-items: center;
    height: 100px;
    max-width: 1100px;
    width: 100%; 
    background-color: #ffffff;
    margin: 0 auto; 
}

header h1{
    font-size: 40px;
    text-align: center;
}

.logo_header img {
    width: 250px;  /* Define a largura da imagem */
    height: 180px; /* Define a altura da imagem */
}
  
header nav {
    display: flex;
    justify-content: space-between;
    width: 30%;
}

header a {
    color: #003079;
    text-decoration: none;
    font-size: 22px;
    display: inline-block;
}

header nav ul {
    display: flex;
    list-style-type: none;
    width: 100%;
    justify-content: space-around;
}



.vagas:hover {
    opacity: 0.6; 
}

.sobre_nos:hover {
    opacity: 0.6; 
}


/* Container do dropdown */
.dropdown {
    position: relative;
    display: inline-block;
}

/* Estilo do botão */
.dropbtn {
    font-size: 16px;
    border: none;
    cursor: pointer;
    border-radius: 50%;
}

.dropbtn i {
    color: #003079;
    font-size: 60px;
   
}

.dropbtn img {
    max-width: 60px; /* Define uma largura máxima */
    min-width: 60px;
    max-height: 60px; /* Define uma altura máxima */
    min-height: 60px;
    width: auto; /* Mantém a proporção da imagem */
    height: auto; /* Mantém a proporção da imagem */
    border-radius: 50%; /* Para fazer a imagem ficar circular */
    border: 3px  solid #003079;

}

/* Conteúdo do dropdown */
.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 200px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1), 
                0 6px 20px rgba(0, 0, 0, 0.1);
    z-index: 1;
    border-radius: 8.89px;
    overflow: hidden;
   
}

/* Links do dropdown */
.dropdown-content a {
    color: #35383F;
    padding: 12px 16px;
    font-size: 18px;
    text-decoration: none;
    display: block;
}

/* Mudança de cor ao passar o mouse */
.dropdown-content a:hover {
    background-color: #f1f1f1;
}

/* Mostrar o dropdown ao passar o mouse sobre o botão */
.dropdown:hover .dropdown-content {
    display: block;
}

/* Mudança de cor do botão ao passar o mouse */
.dropdown:hover .dropbtn {
    background-color: transparent;
}

/* Ajuste para alinhar os ícones com o texto */
.dropdown-content a {
    display: flex;
    align-items: center;
    font-weight: 300;
}

.dropdown-content a i {
    margin-right: 20px; /* Espaçamento entre o ícone e o texto */
    font-size: 18px; /* Tamanho do ícone */
    color: #003079;

}

/* Fim HEADER */

/* Inicio BANNER */
banner {
    display: flex;
    justify-content: center; /* Centraliza horizontalmente */
    align-items: center;    /* Centraliza verticalmente */
    height: 180px;
    background-color: #003079;
}

.container_banner {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 180px;
    width: 900px;

}
.icon_banner {
    margin: 0px; 
}

.icon_banner {
    position: relative; /* Para posicionar o texto dentro deste contêiner */
}

.icon_banner img {
    display: block;
    height: 180px;
    width: 1100px;
    margin-right: 25px;
}

.texto_banner {
    position: absolute;
    top: 53%;
    left: 65%;
    transform: translate(-50%, -50%); /* Centraliza o texto na imagem */
    color: white; /* Define a cor do texto */
    text-align: center;

}



.texto_banner h1 {
    font-size: 44px;
    margin-bottom: -22px; 
    margin-left: 5px;  
}

.texto_banner h2 {
    font-size: 90px;

}

.texto_banner h1,
.texto_banner h2 {
    margin: 0;
}

.texto_banner h1 {
    margin-bottom: -15px; 
    margin-left: -10px; 
            
}
/* Fim BANNER */

/* Inicio MAIN */
main {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #eee;
    width: 100%;
}

.container_main {
    display: flex;
    justify-content: center;
    flex-direction: column;
    align-self: flex-start;
    padding: 15px;
    width: 100%;
    max-width: 1100px;
    background-color: #eee;
    box-sizing: border-box;
}

/* Inicio Caixa de pesquisa */
.container_buscar {
    display: flex;
    padding-top: 25px;
    height: 120px;
    width: 100%; 
    background-color: #ffffff;
    border-radius: 15px;
    box-sizing: border-box;
    margin: 0 auto;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1), 
                0 6px 20px rgba(0, 0, 0, 0.1);

}

.campo_buscar{
    width: 45%;
    display: flex;
    flex-direction: column;
    margin-left: 15px;
    box-sizing: border-box;

}

.campo_empresa{
    width: 35%;
    display: flex;
    flex-direction: column;
    margin-left: 15px;
    box-sizing: border-box;
}

.campo_buscar label{
    font-size: 20px;
    font-weight: 500;
    margin-left: 5px;
    color: #35383F;
}
.caixa_buscar {
    display: flex;
    align-items: center;
    margin-top: 5px;
    width: 100%;

    height: 45px;
    padding: 0 5px; 
    border: none;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.541);
    background-color: #EEEEEE;
    border-radius: 8.89px;
    box-sizing: border-box;
}

.input_vaga {
    border: none;
    padding: 0 5px; 
    margin: 0px 10px 0px 5px;
    flex-grow: 1;
    height: 30px;
    background-color: #EEEEEE;
    font-size: 15px;
    width: 100%;
}

i {
    margin-right: 5px;
    color: #35383F;
}

.campo_empresa label{
    font-size: 20px;
    font-weight: 500;
    margin-left: 5px;
    color: #35383F;
}
.caixa_empresa {
    display: flex;
    align-items: center;
    margin-top: 5px;
    width: 100%;
    height: 45px;
    padding: 0 5px; 
    border: none;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.541);
    background-color: #EEEEEE;
    border-radius: 8.89px;
}

.input_empresa {
    border: none;
    padding: 0 5px; 
    width: 100%;
    margin: 0px 10px 0px 5px;
    flex-grow: 1;
    height: 30px;
    background-color: #EEEEEE;
    font-size: 15px;
}

.botao_buscar_vagas {
    display: flex;
    width: 20%;
    margin-left: 15px;
}

.botao_buscar_vagas button {
    font-weight: 700;
    margin-top: 30px;
    width: 90%;
    height: 45px;
    font-size: 20px; 
    background-color: #003079; 
    color: #ffffff; 
    border: none; 
    border-radius: 8.89px; 
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.397); 
    cursor: pointer;

}

.botao_buscar_vagas button:hover {
    background-color: #0056b3; /* Cor de fundo dos botões ao passar o mouse */
    color: #FFE500;
}

/* Media queries para telas menores */
@media (max-width: 768px) {
    .container_buscar {
        flex-direction: column;
        padding-top: 15px;
        padding-bottom: 15px;
        height: auto;
    }

    .campo_buscar, .campo_empresa, .botao_buscar_vagas {
        width: 95%;
        margin-right: 0;
    }

    .campo_empresa {
        margin-top: 5px;
    }
    .caixa_buscar, .caixa_empresa {
        width: 100%;
        height: 40px;
    }

    .botao_buscar_vagas button {
        width: 100%;
        height: 40px;
        margin-top: 20px;
    }
}
/* Fim Caixa de pesquisa */

/* Inicio Caixa de vagas */
.container_vagas {
    display: flex;
    flex-wrap: wrap;
    justify-items: stretch;
    background-color: #eee;
    box-sizing: border-box;
    margin: 0 auto;
    margin-top: 40px;
    justify-content: space-between;
    width: 100%;

}
.container_vagas h1 {
    width: 100%;
    margin-top: 0px;
    margin-left: 10px;
    font-size: 30px;
    color: #35383F;
}

.container_vagas .white-box {
    background-color: #ffffff;
    border-radius: 15px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1), 
                0 6px 20px rgba(0, 0, 0, 0.1);
    width: 500px;
    height: 355px;
    display: flex;
    justify-content: flex-start; /* Alinha o conteúdo no topo do contêiner */
    align-items: left;
    flex-direction: column;
    padding: 20px; /* Espaço entre o topo do contêiner e o conteúdo */
    margin-top: 30px;
    margin-bottom: 30px;
    transition: transform 0.1s ease;
}

.container_vagas .white-box:hover {
    transform: scale(1.02); /* Aumenta o botão em 10% ao passar o mouse */
}

input, textarea {
    border: none;
    resize: none;
    font-weight: 500;
    background-color: transparent;

}

input, textarea[readonly] {
    border: none;
}
input, textarea[readonly]:focus {
    outline: none;
    border: none;
}

.nome_empresa{
    display: flex;
    flex-direction: column;
    width: 100%;
    margin: 0px;

}

.nome input {
    width: 100%;
    border: none;
    font-size: 23px;
    color: #35383F;
  
}

.empresa input {
    width: 97%;
    border: none;
    font-size: 16px;
    margin-left: 9px;
    color: #808080;
   
}

.l_qv_d {
    display: flex;
    width: 100%;
    margin-top: 40px;

}

.l_qv_d input {
    font-size: 13px;
    margin-left: 5px;
    margin-bottom: 10px;
    color: #35383F;
}

.l_qv_d i {
    font-size: 16px;
    color: #35383F;
      
}

.localidade input{
    width: 70%;

}

.quantidade_vagas input{
    width: 70%;

}

.disponivel input{
    width: 82%;

}

.t_e_ch {
    display: flex;
    width: 100%;
    margin-top: 10px;
    margin-bottom: 15px;

}

.t_e_ch input {
    font-size: 13px;
    margin-left: 5px;
    
    color: #35383F;
}

.t_e_ch i {
    font-size: 16px;
    color: #35383F;
      
}

.tipo input{
    width: 75%;

}

.escolaridade input{
    width: 75%;
}

.carga_horaria input{
    width: 75%;

}

.descricao_vaga textarea {
    width: 100%;
    height: 85px;
    margin-top: 25px;
    resize: none;
    display: block;
    font-size: 15px;
    color: #35383F;
}

.botao_candidatar {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    margin-top: 10px;

}

.botao_candidatar .candidatar {
    font-weight: 700;
    width: 100%;
    height: 50px;
    font-size: 20px; /* Tamanho da fonte dos botões */
    background-color: #003079; /* Cor de fundo dos botões */
    color: #ffffff; /* Cor do texto dos botões */
    border: none; /* Remove a borda dos botões */
    border-radius: 8.89px; /* Borda arredondada dos botões */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.397); /* Adiciona sombra */
    cursor: pointer;
    margin-top: 5px;
}

.botao_candidatar .candidatar:hover {
    background-color: #0056b3; /* Cor de fundo dos botões ao passar o mouse */
    color: #FFE500;
}

.botao_candidatar .inscrito {
    font-weight: 700;
    width: 100%;
    height: 50px;
    font-size: 20px; /* Tamanho da fonte dos botões */
    background-color: #ffffff; /* Cor de fundo dos botões */
    color: #003079; /* Cor do texto dos botões */
    border: 3px solid #003079; /* Remove a borda dos botões */
    border-radius: 8.89px; /* Borda arredondada dos botões */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.397); /* Adiciona sombra */
    cursor: pointer;
    margin-top: 5px;
}
@media screen and (max-width: 1029px){
    .container_vagas {
        display: flex;
        justify-content: center;
    }
    .container_vagas h1 {
        text-align: center;
    }

    .container_vagas .white-box {
        width: 100%;
    }
}

@media screen and (max-width: 424px){
    .container_vagas .white-box {
        height: 390px;
    }
}
/* Fim Caixa de vagas */
/* Fim MAIN */

/* Inicio FOOTER */
footer {
    display: flex;
    flex-direction: column;
    width: 100%;
    box-sizing: border-box;
    letter-spacing: 1px;
    background-color: #003079;
    
}
a {
    text-decoration: none;
}
.container_footer {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    padding: 3rem 3.5rem;
    background-color: #003079;
    height: 180px;
    width: 100%;
    max-width: 1100px;
    margin: 0 auto;

}

.logo_footer img {

    width: 150px;  /* Define a largura da imagem */
    height: 50px; /* Define a altura da imagem */
    margin-bottom: 0.75rem;
    margin-left: 15px;
}

.social_media_footer {
    display: flex;
    gap: 2rem;
}

.social_media_footer .footer_link {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 2.5rem;
    width: 2.5rem;
    color: #ffffff;
    border-radius: 50%;
    transition: all 0.4s;
    
}
.social_media_footer .footer_link:hover {
    opacity: 0.8;
}
.social_media_footer i {
    font-size: 1.25rem;
    color: #eee;
    margin-left: 5px;
}
.social_media_footer i:hover {
    color: #FFE500;
}

#location {
    background-color: #c50000;
}

#instagram {
    background: linear-gradient(#7f37c9, #ff2992, #ff9807);
}

#facebook {
    background-color: #4267b3;
}

.lista_footer {
    display: flex;
    list-style: none;
    margin-top: 20px;
    font-size: 20px;
}

.lista_footer .footer_link {
    color: #fff;
    transition: all 0.4s;
}

.lista_footer .footer_link:hover {
    color: #FFE500;
}

#fl_ajuda {
    margin-left: 60px;
}

.copyright_footer {
    display: flex;
    justify-content: center;
    background-color: #041a3b;
    color: #ffffff;
    font-size: 0.9rem;
    padding: 1.3rem;
}

@media screen and (max-width: 768px){
    .container_footer {
        grid-template-columns: repeat(2, 1fr);
        height: 280px;

    }
    
}

@media screen and (max-width: 426px){
    .container_footer {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        flex-direction: column;
        grid-template-columns: repeat(1, 1fr);
        height: 370px;
        padding: 0;

    }
    #fl_ajuda {
        margin-left: 0px;
    }

    .contatos_footer {
        margin-top: 30px;
    }

    .lista_footer {
        margin-top: 40px;
    }
}
/* Fim FOOTER */
    </style>

</head>
<body>
    <header> <!-- Inicio cabeçalho -->
        <div class="logo_header">
            <img src="img_home_page/empregamais.png" alt="logo">
        </div>
        <nav class="menu_header">
            <ul>
                <li><a class="vagas" href="#">Vagas</a></li>
                <li><a class="sobre_nos" href="#">Sobre nós</a></li>
            </ul>
        </nav>
        <div class="dropdown">
            <button class="dropbtn">
                <?php if (isset($caminho_fotoperfil) && !empty($caminho_fotoperfil)): ?>
                    <img src="<?php echo htmlspecialchars($caminho_fotoperfil); ?>" alt="Foto de Perfil">
                <?php else: ?>
                    <i class="fa-regular fa-circle-user"></i>
                <?php endif; ?>
            </button>
            <div class="dropdown-content">
                <a href="../change_personal_data/alterar_dados_pessoais.php"><i class="fa-solid fa-user"></i> Perfil</a>
                <a href="../my_vacancies/minhas_vagas.php"><i class="fa-solid fa-circle-check"></i> Minhas vagas</a>
                <a href="../create_vacancy/criar_vaga.html"><i class="fa-solid fa-cog"></i> Configurações</a>
                <a href="../home_page/inicio.php"><i class="fa-solid fa-right-from-bracket"></i> Sair</a>
            </div>
        </div>        
    </header><!-- Fim cabeçalho -->

    <banner><!-- Inicio foto texto oportun... -->
        <div class="container_banner">
            <div class="icon_banner">
                <img src="img_home_page/banner_img.png" alt="foto">
                <div class="texto_banner">
                    <h1>OPORTUNIDADE DE</h1>
                    <h2>EMPREGO</h2>
                </div>
            </div>
        </div>
    </banner><!-- Fim foto texto oportun... -->

    <main><!-- Inicio conteudo principal -->
        <div class="container_main">

            <!-- Inicio Caixa de pesquisa -->
            <form method="GET" action="">
                <div class="container_buscar">
                    <div class="campo_buscar">
                        <label for="vaga">Busque sua vaga</label>
                        <div class="caixa_buscar">
                            <input class="input_vaga" type="text" placeholder="Nome da vaga" name="vaga" id="vaga">
                            <i class="fa fa-search"></i>
                        </div>
                    </div>
                    <div class="campo_empresa">
                        <label for="empresa">Empresa</label>
                        <div class="caixa_empresa">
                            <input class="input_empresa" type="text" placeholder="Nome da empresa" name="empresa" id="empresa">
                            <i class="fa-solid fa-building"></i>
                        </div>  
                    </div>       
                    <div class="botao_buscar_vagas">
                        <button type="submit">Buscar vagas</button>
                    </div>
                </div>
            </form>
            <!-- Fim Caixa de pesquisa -->

            <div class="container_vagas"> <!-- Inicio vagas -->
                <h1>Vagas disponíveis</h1>
                <?php
                // Conexão com o banco de dados
                $conn = mysqli_connect("localhost", "root", "12345", "emprega_mais");
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Captura os valores dos campos de pesquisa
                $vaga = isset($_GET['vaga']) ? $_GET['vaga'] : '';
                $empresa = isset($_GET['empresa']) ? $_GET['empresa'] : '';

                // Cria a query SQL com base nos valores de pesquisa
                $sql = "SELECT id, nome, tipo, disponivel, quantidade_vagas, escolaridade, empresa, localidade, carga_horaria, descricao_vaga FROM vagas WHERE 1=1";

                // Adiciona filtros à query se os valores forem fornecidos
                if ($vaga != '') {
                    $sql .= " AND nome LIKE '%$vaga%'";
                }
                if ($empresa != '') {
                    $sql .= " AND empresa LIKE '%$empresa%'";
                }

                $result = $conn->query($sql);

                // Verifica e exibe os resultados da pesquisa
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Gerar o nome da tabela da vaga
                        $id_vaga = $row["id"];
                        $nome_vaga = $row["nome"];
                        $nome_tabela = "vaga_" . $id_vaga . "_" . preg_replace('/[^a-zA-Z0-9_]/', '', str_replace(' ', '_', $nome_vaga));

                        // Verifica se o usuário já está inscrito na vaga
                        $sql_check_inscrito = "SELECT * FROM $nome_tabela WHERE id_usuario = '$id_usuario'";
                        $result_inscrito = $conn->query($sql_check_inscrito);

                        echo "<div class='white-box'>";
                            echo "<form action='li_candidatar.php' method='POST'>";
                                echo "<input type='hidden' name='id_vaga' value='" . $id_vaga . "'>";
                                echo "<input type='hidden' name='id_usuario' value='" . $id_usuario . "'>";

                                echo "<div class='nome_empresa'>";
                                    echo "<div class='nome'>";
                                        echo "<input type='text' id='nome_" . $id_vaga . "' name='nome' value='" . $row["nome"] . "' readonly>";
                                    echo "</div>";
                                    echo "<div class='empresa'>";
                                        echo "<input type='text' id='empresa_" . $id_vaga . "' name='empresa' value='" . $row["empresa"] . "' readonly>";
                                    echo "</div>";
                                echo "</div>";

                                echo "<div class='l_qv_d'>";
                                    echo "<div class='localidade'>";
                                        echo "<i class='fa-solid fa-location-dot'></i>";
                                        echo "<input type='text' id='localidade_" . $id_vaga . "' name='localidade' value='" . $row["localidade"] . "' readonly>";
                                    echo "</div>";
                                    echo "<div class='quantidade_vagas'>";
                                        echo "<i class='fa-solid fa-users'></i>";
                                        echo "<input type='text' id='quantidade_vagas_" . $id_vaga . "' name='quantidade_vagas' value='" . $row["quantidade_vagas"] . "' readonly>";
                                    echo "</div>";
                                    echo "<div class='disponivel'>";
                                        echo "<i class='fa-solid fa-circle-exclamation'></i>";
                                        echo "<input type='text' id='disponivel_" . $id_vaga . "' name='disponivel' value='" . $row["disponivel"] . "' readonly>";
                                    echo "</div>";
                                echo "</div>";

                                echo "<div class='t_e_ch'>";
                                    echo "<div class='tipo'>";
                                        echo "<i class='fa-solid fa-file-contract'></i>";
                                        echo "<input type='text' id='tipo_" . $id_vaga . "' name='tipo' value='" . $row["tipo"] . "' readonly>";
                                    echo "</div>";
                                    echo "<div class='escolaridade'>";
                                        echo "<i class='fa-solid fa-graduation-cap'></i>";
                                        echo "<input type='text' id='escolaridade_" . $id_vaga . "' name='escolaridade' value='" . $row["escolaridade"] . "' readonly>";
                                    echo "</div>";
                                    echo "<div class='carga_horaria'>";
                                        echo "<i class='fa-solid fa-clock'></i>";
                                        echo "<input type='text' id='carga_horaria_" . $id_vaga . "' name='carga_horaria' value='" . $row["carga_horaria"] . "' readonly>";
                                    echo "</div>";
                                echo "</div>";

                                echo "<div class='descricao_vaga'>";
                                    echo "<textarea id='descricao_vaga_" . $id_vaga . "' name='descricao_vaga' readonly>" . $row["descricao_vaga"] . "</textarea>";
                                echo "</div>";

                                echo "<div class='botao_candidatar'>";
                                    // Altera o botão com base na inscrição
                                    if ($result_inscrito->num_rows > 0) {
                                        echo "<button type='button' class='inscrito' disabled>Inscrito na vaga</button>";
                                    } else {
                                        echo "<button type='button' class='candidatar' onclick='candidatarVaga($id_vaga, $id_usuario, this)'>Candidatar-se a vaga</button>";
                                    }
                                echo "</div>";
                            echo "</form>";
                        echo "</div>";
                    }
                } else {
                    echo "Nenhuma vaga encontrada.";
                }

                $conn->close();
                ?>
            </div> <!-- Fim vagas -->
        </div>
    </main><!-- Fim conteudo principal -->

    <footer><!-- Inicio rodapé -->
        <div class="container_footer">
            <div class="contatos_footer">
                <div class="logo_footer">
                    <img src="img_home_page/empregamaisfooter2.png" alt="logo">
                </div>
                <div class="social_media_footer">
                    <a href="https://maps.app.goo.gl/xKHmXhAcs7vcKfSS6" target="_blank" rel="noopener noreferrer" class="footer_link" id="location">
                        <i class="fa-solid fa-location-dot"></i>
                    </a>
                    <a href="https://www.facebook.com/profile.php?id=100069873004399" target="_blank" rel="noopener noreferrer" class="footer_link" id="facebook">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a href="https://www.instagram.com/magazine_nossa_loja?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank" rel="noopener noreferrer" class="footer_link" id="instagram">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                </div>
            </div>   
            <ul class="lista_footer">
                <li>
                    <a href="#" class="footer_link">Desenvolvedores</a>
                </li>
            </ul>
            <ul class="lista_footer">
                <li>
                    <a href="#" class="footer_link">Perguntas e Respostas</a>
                </li>
            </ul>
            <ul class="lista_footer">
                <li>
                    <a href="#" class="footer_link" id="fl_ajuda">Ajuda</a>
                </li>
            </ul>
        </div>
        <div class="copyright_footer">
            &#169 2024 Emprega mais
        </div>
    </footer><!-- Fim rodapé -->

    <script>
function candidatarVaga(id_vaga, id_usuario, botao) {
    // Cria um objeto XMLHttpRequest
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'li_candidatar.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    // Função chamada quando a requisição for completada
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Caso a requisição tenha sucesso, desabilitar o botão
            botao.disabled = true;
            botao.innerText = 'Inscrito na vaga';
            botao.className = 'inscrito';  // Altera a classe para estilizar
        } else {
            alert('Erro ao candidatar-se à vaga. Tente novamente.');
        }
    };

    // Envia a requisição com os dados da vaga e do usuário
    var params = 'id_vaga=' + id_vaga + '&id_usuario=' + id_usuario;
    xhr.send(params);
}
</script>

</body>
</html>