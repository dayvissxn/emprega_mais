<?php
    session_start();
    
    if ((!isset($_SESSION['id_usuario']) == true) and (!isset($_SESSION['nome_completo']) == true)) {
        unset($_SESSION['id_usuario']);
        unset($_SESSION['nome_completo']);
        header("Location: ../login/login.php");
        exit();
    }


    $logado = $_SESSION['nome_completo'];
    $primeiro_nome = explode(' ', $logado)[0]; // Pega a primeira parte do nome completo
    $id_usuario = $_SESSION['id_usuario'];

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

// Fechar a declaração
$stmt->close();
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
    <title>Excluir conta</title>


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
    margin-bottom: 150px;
    width: 500px;
    height: 460px;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;

}

#titulo {
    font-family: "Ubuntu", sans-serif;
    font-weight: 700;
    text-align: center;
    color: #1F1F1F;
    font-size: 40px; /* Ajuste o tamanho da fonte conforme necessário */
    margin-bottom: 40px; /* Adiciona espaço abaixo do título */
    margin-top: -10px; /* Adiciona espaço abaixo do título */
}

p {
    color: #A7A7A7;
    display: block;
    font-weight: 500;
    width: 100%;
    font-size: 23px;
    line-height: 1.5;
    text-align: center;
}

.campo_senha {
    display: flex;
    flex-direction: column;
    align-items: center;
    
}

.campo_senha label {
    margin-bottom: 5px;
    margin-right: 25px;
    color: #A7A7A7;
    display: inline-block;
    font-weight: 500;
    font-size: 17px;

}

.campo_senha input[type="password"] {
    padding: 10px;
    height: 15px; /* Ajuste a altura conforme necessário */
    border: none;
    box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.082);
    background-color: #EEEEEE;
    display: block;
    border-radius: 8.89px;
    font-family: 'Ubuntu', sans-serif;
    
}

.asterisco {
    color: red;
    margin-left: 5px;
}

.botao_excluir_conta {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    margin-top: 40px; /* Empurra o botão para a parte inferior do contêiner */

}

.botao_excluir_conta button {
    font-weight: 700;
    padding: 10px 35px; /* Preenchimento interno dos botões */
    font-size: 20px; /* Tamanho da fonte dos botões */
    background-color: #9A1B1B; /* Cor de fundo dos botões */
    color: #ffffff; /* Cor do texto dos botões */
    border: none; /* Remove a borda dos botões */
    border-radius: 8.89px; /* Borda arredondada dos botões */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.397); /* Adiciona sombra */
    cursor: pointer;
}

.botao_excluir_conta button:hover {
    background-color: #D81919; /* Cor de fundo dos botões ao passar o mouse */
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

/* Conteúdo da modal */
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
    font-size: 20px;
    position: relative;
    text-align: center;
    
}
p{
    font-size: 20px;
}
/* Estilo para sucesso */
.sucesso {
    border: 1px solid #c3e6cb;
    background-color: #d4edda;
    color: #155724;
    font-weight: 700;
}

/* Estilo para erro */
.erro {
    border: 1px solid #f5c6cb;
    background-color: #f8d7da;
    color: #721c24;
    font-weight: 700;
}

/* Estilização do botão fechar (X) */
.fechar {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
    padding: 8px;
}

.fechar:hover,
.fechar:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}


</style>

</head>
<body>

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
            <h1 id="titulo">Excluir conta?</h1>
            

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


            <form action="ec_delete.php" method="post">
                <p class="paragrafo">Isso excluirá sua conta permanentemente,<br> deseja seguir?</p>
                <br>
    
                <div class="campo_senha">
                    <label for="senha">Confirme sua senha:<span class="asterisco">*</span></label>
                    <input type="password" name="senha" id="senha" required>
                </div>
                <br>

                <div class="botao_excluir_conta">   
                    <button type="submit">Excluir conta!</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Scripts para controlar o modal
        window.onload = function() {
            var modal = document.getElementById("modalMensagem");
            var fechar = document.getElementById("fecharModal");

            // Mostrar o modal
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