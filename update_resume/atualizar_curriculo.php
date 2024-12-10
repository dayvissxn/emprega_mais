<?php
session_start();

// Verificação correta das variáveis de sessão
if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['nome_completo'])) {
    header("Location: ../login/login.php");
    exit();
}

$logado = $_SESSION['nome_completo'];
$primeiro_nome = explode(' ', $logado)[0]; // Pega a primeira parte do nome completo

include('ac_conexao.php'); // Inclua a conexão com o banco de dados

$id_usuario = $_SESSION['id_usuario'];

// Query para buscar os dados do usuário no banco de dados
$sql = "SELECT experiencia_antecessora, caminho_fotoperfil, caminho_curriculo FROM usuarios WHERE id = '$id_usuario'";
$result = mysqli_query($mysqli, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $dados_usuario = mysqli_fetch_assoc($result);
    $experiencia_antecessora = $dados_usuario['experiencia_antecessora'];
    $caminho_fotoperfil = $dados_usuario['caminho_fotoperfil'];
    $caminho_curriculo = $dados_usuario['caminho_curriculo']; 
    $nome_arquivo = basename($caminho_curriculo); 
} else {
    // Caso não encontre o usuário, redireciona para a página de login
    header("Location: ../login/login.php");
    exit();
}

mysqli_close($mysqli);
?>


<!doctype html>
<html lang="pt-br">

<head>
    <!-- Metadados -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CODIGO DA FONTE -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <!-- FIM DO CODIGO DA FONTE  -->
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="#" media="screen">
    <!-- Adicionar Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- Fim do código para Font Awesome -->
    <!-- Título da página (aparece na aba) -->
    <title>Atualizar currículo</title>

    
<style>

body {
    margin: 0;
    padding: 0;
    display: flex;
    height: 100vh;
    width: 100vw;
    font-family: 'Ubuntu', sans-serif;
    background: linear-gradient(to right, #ffffff 30%, #003079);
}

.container_left {
    width: 30%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: flex-end;
    padding-top: 5%;
    align-self: flex-start;
    
}


.foto_nome_perfil {
    display: flex; /* Alinha os itens horizontalmente */
    align-items: center; /* Centraliza verticalmente o ícone e o nome */
    margin-top: 55px;
    margin-bottom: 45px;
}

.foto_nome_perfil i{
    font-size: 50px; /* Tamanho do ícone */
    color: #35383F;/* Cor do ícone */
    margin-left: 4px;
 
}

.foto_nome_perfil img {
    max-width: 50px; /* Define uma largura máxima */
    min-width: 50px;
    max-height: 50px; /* Define uma altura máxima */
    min-height: 50px;
    width: auto; /* Mantém a proporção da imagem */
    height: auto; /* Mantém a proporção da imagem */
    border-radius: 50%; /* Para fazer a imagem ficar circular */
    margin-left: 3px;
    border: 3px  solid #35383F;
}

.nome-usuario {
    font-size: 28px; /* Tamanho da fonte do nome */
    font-weight: bold; /* Deixa o nome em negrito */
    font-weight: 500;
    color: #35383F;
    margin-left: 24px;
}

/* Conteúdo do button-container */
.button-container {
    display: block;
    background-color: transparent;
    min-width: 300px;
    z-index: 1;
    margin-top: 40px;
    margin-right: 17px;
   
}


/* Links do button-container */
.button-container a {
    color: #35383F;
    padding: 12px 16px;
    font-size: 20px;
    text-decoration: none;
    display: block;
    
}

/* Mudança de cor ao passar o mouse */
.button-container a:hover {
    background-color: #f1f1f1;
    color: #35383F;
    border-radius: 8.89px;
}


/* Ajuste para alinhar os ícones com o texto */
.button-container a {
    display: flex;
    align-items: center;
    font-weight: 500;
}

.button-container a i {
    margin-right: 27px; /* Espaçamento entre o ícone e o texto */
    font-size: 22px; /* Tamanho do ícone */
    color: #35383F;

}

/* Especifico para separar texto do icon*/
.button-container .alterar_dados i {
    margin-right: 23px; /* Ajuste o valor conforme necessário */
}


.button-container .atualizar_curriculo i{
    margin-left: 3px; /* Ajuste o valor conforme necessário */
    margin-right: 30px; /* Ajuste o valor conforme necessário */
    
}


.button-container .excluir_conta i {
    margin-right: 30px; /* Ajuste o valor conforme necessário */
}


/* direita */
.container_right {
    width: 70%;
    display: flex;
    justify-content: center;
    align-items: center;
}


.container_right .white-box {
    background-color: #ffffff;
    border-radius: 35.56px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1), 
                0 6px 20px rgba(0, 0, 0, 0.1);
    margin-right: 50px;
    width: 600px;
    height: 630px;
    display: flex;
    justify-content: flex-start; /* Alinha o conteúdo no topo do contêiner */
    align-items: center;
    flex-direction: column;
    padding-top: 20px; /* Espaço entre o topo do contêiner e o conteúdo */
    padding-bottom: 10px; /* Espaço entre o topo do contêiner e o conteúdo */
}

#titulo {
    font-family: "Ubuntu", sans-serif;
    font-weight: 700;
    text-align: center;
    color: #1F1F1F;
    font-size: 40px; /* Ajuste o tamanho da fonte conforme necessário */
    margin-bottom: 60px; /* Adiciona espaço abaixo do título */
} 

.campo {
    margin-bottom: 30px;
    width: calc(100% - 25px); 
}

.campo label {
    margin-bottom: 5px;
    margin-left: 5px;
    color: #A7A7A7;
    display: block;
    font-weight: 500;
    width: 100%;
    font-size: 20px;
}

.campo input[type="file"] {
    padding: 10px;
    width: 100%;
    height: 15px; /* Ajuste a altura conforme necessário */
    border: none;
    box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.082);
    background-color: #EEEEEE;
    display: block;
    border-radius: 8.89px;
    font-family: 'Ubuntu', sans-serif;
    margin-bottom: 20px;
    
}

.campo_curriculo{
    margin-top: -20px;
    margin-bottom: 40px;
    margin-left: 5px;

}

.curriculo_atual {
    color: #A7A7A7;
    font-weight: 400;
    font-size: 15px;
    justify-content: center;
}

.nome_curriculo {
    color: #A7A7A7;
    font-weight: 400;
    font-size: 15px;
    justify-content: center;
}

.campoexperiencia label {
    margin-bottom: 5px;
    margin-left: 5px;
    color: #A7A7A7;
    display: block;
    font-weight: 500;
    width: 100%;
    font-size: 20px;
}

textarea {
    padding: 8px;
    height: 190px;
    resize: none; /* Impede que o usuário redimensione o textarea */
    border: none;
    box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.082);
    background-color: #EEEEEE;
    display: block;
    width: 400px; /* Largura total */
    border-radius: 8.89px;
    font-size: 14px;
    font-family: 'Ubuntu', sans-serif;
}

.botao_atualizar {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    margin-top: 50px; /* Empurra o botão para a parte inferior do contêiner */

}

.botao_atualizar button {
    font-weight: 700;
    padding: 10px 50px; /* Preenchimento interno dos botões */
    font-size: 20px; /* Tamanho da fonte dos botões */
    background-color: #003079; /* Cor de fundo dos botões */
    color: #ffffff; /* Cor do texto dos botões */
    border: none; /* Remove a borda dos botões */
    border-radius: 8.89px; /* Borda arredondada dos botões */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.397); /* Adiciona sombra */
    cursor: pointer;
}

.botao_atualizar button:hover {
    background-color: #0056b3; /* Cor de fundo dos botões ao passar o mouse */
    color: #FFE500;
}

/* Estilos existentes */

/* Estilos responsivos */
@media (max-width: 820px) {
    body {
        flex-direction: column; /* Muda para coluna em telas menores */
    }

    .container_left, .container_right {
        width: 100%; /* Ocupa a largura total em telas menores */
    }

    .container_left {
        padding: 20px; /* Ajusta o padding conforme necessário */
        align-items: flex-start;
    }

    .container_right {
        margin-top: 20px; /* Adicione margem conforme necessário */
        justify-content: flex-start;
        padding: 20px;
    }
}


/* Estilização do modal */
.modal {
    display: none; 
    position: fixed; 
    z-index: 1; 
    left: 0;
    top: 0;
    width: 100%; 
    height: 100%; 
    overflow: auto; 
    background-color: rgb(0,0,0); 
    background-color: rgba(0,0,0,0.4); 
   
}

.modal-conteudo {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 4px;
    border: 1px solid #888;
    width: 80%; 
    margin-right: 535px;
    max-width: 300px;
    border-radius: 10px;
    font-family: "Ubuntu", sans-serif;
    font-weight: 700;
    position: relative;
    text-align: center;
    
  
}

.sucesso {
    border: 1px solid #c3e6cb;
    background-color: #d4edda;
    color: #155724;
    font-weight: 700;
    
}

.erro {
    border: 1px solid #f5c6cb;
    background-color: #f8d7da;
    color: #721c24;
    font-weight: 700;
}

/* Estilização do botão fechar (X) */
.fechar {
    color: #003079;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
    padding: 8px;
}

.fechar:hover,
.fechar:focus {
    color: #FFE500;
    text-decoration: none;
    cursor: pointer;
}

    </style>

</head>
<body>
    <div class="container_left">
        
        <div class="button-container">

            <div class="foto_nome_perfil">
                <?php if (isset($caminho_fotoperfil) && !empty($caminho_fotoperfil)): ?>
                    <img src="<?php echo htmlspecialchars($caminho_fotoperfil); ?>" alt="Foto de Perfil">
                <?php else: ?>
                    <i class="fa-regular fa-circle-user"></i>
                <?php endif; ?>

                <span class="nome-usuario"><?php echo htmlspecialchars($primeiro_nome); ?></span>
            </div>

            <a href="../home_loggedin/logged_in.php" class="house"><i class="fa-solid fa-house"></i>Página inicial</a>

            <a href="../change_personal_data/alterar_dados_pessoais.php" class="alterar_dados"><i class="fa-solid fa-user-edit"></i>Alterar dados pessoais</a>

            <a href="../update_resume/atualizar_curriculo.php" class="atualizar_curriculo"><i class="fa-solid fa-file-alt"></i>Atualizar currículo</a>

            <a href="../change_password/alterar_senha.php" class="alterar_senha"><i class="fa-solid fa-key"></i>Alterar senha</a>

            <a href="../delete_account/excluir_conta.php" class="excluir_conta"><i class="fa-solid fa-trash"></i>Excluir minha conta</a>

        </div>
    </div>
    <div class="container_right">
        <div class="white-box">
            <h1 id="titulo">Atualizar currículo</h1>
            <br>

            <!-- Modal -->
            <?php if (isset($_SESSION['mensagem'])): ?>
                <div id="modalMensagem" class="modal">
                    <div class="modal-conteudo <?php echo $_SESSION['tipo_mensagem']; ?>">
                        <span class="fechar" id="fecharModal">&times;</span>
                        <p><?php echo $_SESSION['mensagem']; ?></p>
                    </div>
                </div>
                <?php
                unset($_SESSION['mensagem']);
                unset($_SESSION['tipo_mensagem']);
                ?>
            <?php endif; ?>

            <form class="dados" action="ac_edit.php" method="post" enctype="multipart/form-data">
                <div class="campo">
                    <label for="enviarcurriculo">Anexar currículo (PDF ou DOCX)</label>
                    <input type="file" name="enviarcurriculo" id="enviarcurriculo" accept=".pdf, .docx">
                </div><!-- Fim currículo -->

                <!-- Exibe o nome do arquivo existente, se houver -->
                <?php if (!empty($nome_arquivo)): ?>
                    <div class="campo_curriculo">
                        <p class="curriculo_atual">Currículo atual: <a class="nome_curriculo" href="<?php echo $caminho_curriculo; ?>" target="_blank"><?php echo $nome_arquivo; ?></a></p>
                    </div>
                    <!-- Campo oculto para enviar o caminho do currículo -->
                    <input type="hidden" name="caminho_curriculo" value="<?php echo $caminho_curriculo; ?>">
                <?php endif; ?>

                <div class="campoexperiencia">
                    <label for="experiencia">Experiências anteriores:</label>
                    <textarea name="experiencia" id="experiencia" rows="10" cols="50" required><?php echo htmlspecialchars($experiencia_antecessora); ?></textarea>
                </div><!-- Fim experiencia -->
                <div class="botao_atualizar">
                    <button type="submit">Atualizar</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal para exibir mensagens -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p id="modalMessage"></p>
        </div>
    </div>

    <script>
    // Mostrar o modal
    window.onload = function() {
        var modal = document.getElementById("modalMensagem");
        var fechar = document.getElementById("fecharModal");

        modal.style.display = "block";

        // Fechar o modal quando clicar no "X"
        fechar.onclick = function() {
            modal.style.display = "none";
        }

        // Fechar o modal se o usuário clicar fora do modal
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    };
    </script>
</body>
</html>