<?php
session_start();

// Verificação correta das variáveis de sessão
if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['nome_completo'])) {
    header("Location: ../login/login.php");
    exit();
}

$logado = $_SESSION['nome_completo'];
$primeiro_nome = explode(' ', $logado)[0]; // Pega a primeira parte do nome completo

include('adp_conexao.php'); // Inclua a conexão com o banco de dados

$id_usuario = $_SESSION['id_usuario'];

// Query para buscar os dados do usuário no banco de dados
$sql = "SELECT nome_completo, email, data_nascimento, genero, telefone, caminho_fotoperfil FROM usuarios WHERE id = '$id_usuario'";
$result = mysqli_query($mysqli, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $dados_usuario = mysqli_fetch_assoc($result);
    
    $nome_completo = $dados_usuario['nome_completo'];
    $email = $dados_usuario['email'];
    $data_nascimento = $dados_usuario['data_nascimento'];
    $genero = $dados_usuario['genero'];
    $telefone = $dados_usuario['telefone'];
    $caminho_fotoperfil = $dados_usuario['caminho_fotoperfil'];
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
    <title>Alterar dados pessoais</title>

    
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
    margin-left: 4px;
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
    height: 640px;
    display: flex;
    justify-content: flex-start; /* Alinha o conteúdo no topo do contêiner */
    align-items: center;
    flex-direction: column;
    padding-top: 20px; /* Espaço entre o topo do contêiner e o conteúdo */
}

#titulo {
    font-family: "Ubuntu", sans-serif;
    font-weight: 700;
    text-align: center;
    color: #35383F;
    font-size: 40px; /* Ajuste o tamanho da fonte conforme necessário */
} 

.alterar_foto{
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    margin-bottom: 10px;
    
}

.foto_perfil img {
    max-width: 120px; /* Define uma largura máxima */
    min-width: 120px;
    max-height: 120px; /* Define uma altura máxima */
    min-height: 120px;
    width: auto; /* Mantém a proporção da imagem */
    height: auto; /* Mantém a proporção da imagem */
    border-radius: 50%; /* Para fazer a imagem ficar circular */
    margin-top: -20px;
    border: 3px  solid #0000008a;
}


nav {
    display: flex;
    margin-top: -10px;
    margin-bottom: 10px;

}

a {
    color: #003079;
    text-decoration: none;
    font-size: 15px;
    margin-right: 25px;

}

a:hover {
    transition: color 0.5s ease, background-color 0.5s ease;
    color: #FFE500;
}

nav ul {
    display: flex;
    list-style-type: none;

}

.dados{
    display: flex;
    flex-direction: column;
    margin: 0 auto;
    align-items: center;

}

.campo_nome {
    margin-bottom: 20px;

}

.campo_nome label {
    margin-bottom: 5px;
    margin-left: 5px;
    color: #A7A7A7;
    display: block;
    font-weight: 500;
    width: 100%;
    font-size: 20px;

}

.campo_nome input{
    padding: 10px;
    width: 400px;
    height: 15px; /* Ajuste a altura conforme necessário */
    border: none;
    box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.082);
    background-color: #EEEEEE;
    display: block;
    border-radius: 8.89px;
    font-family: 'Ubuntu', sans-serif;
}

.campo_email_data, .campo_genero_telefone{
    display: flex;
    margin-bottom: 20px;
    
}

.campo_email_data label, .campo_genero_telefone label{
    margin-bottom: 5px;
    margin-left: 25px;
    color: #A7A7A7;
    display: flex;
    font-weight: 500;
    width: 100%;
    font-size: 20px;
    
}

.campo_email_data input, .campo_genero_telefone input{
    padding: 10px;
    width: 170px;
    height: 15px; /* Ajuste a altura conforme necessário */
    border: none;
    box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.082);
    background-color: #EEEEEE;
    margin-right: 20px;
    margin-left: 20px;
    border-radius: 8.89px;
    font-family: 'Ubuntu', sans-serif;
    
}

.campo_genero_telefone select{
    padding: 10px;
    width: 190px;

    border: none;
    box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.082);
    background-color: #EEEEEE;
    margin-right: 20px;
    margin-left: 20px;
    border-radius: 8.89px;
    font-family: 'Ubuntu', sans-serif;
}

.botao_atualizar {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    margin-top: 30px;

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

select{
    cursor: pointer;
}


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
        <h1 id="titulo">Alterar dados pessoais</h1>
        <br>

        <!-- Formulário para upload de foto de perfil -->
        <form id="formFotoPerfil" action="adp_atualizar_foto.php" method="post" enctype="multipart/form-data">
            <div class="foto_perfil">
                <img src="<?php echo htmlspecialchars($caminho_fotoperfil ?? 'img_change_personal_data/foto_perfil_btn.png'); ?>" alt="Foto de Perfil">
            </div>
            <input type="file" id="inputFoto" name="fotoPerfil" accept="image/*" style="display: none;">
        </form>

        <!-- Botões para alterar e remover foto -->
        <nav class="editar_foto">
            <ul>
                <li><a class="alterar" href="#" onclick="document.getElementById('inputFoto').click();">Alterar</a></li>
                <li><a class="remover" href="adp_remover_foto.php">Remover</a></li>
            </ul>
        </nav>


            <!-- Modal -->
            <?php if (isset($_SESSION['mensagem'])): ?>
                <div id="modalMensagem" class="modal">
                    <div class="modal-conteudo <?php echo isset($_SESSION['tipo_mensagem']) ? $_SESSION['tipo_mensagem'] : ''; ?>">
                        <span class="fechar" id="fecharModal">&times;</span>
                        <p><?php echo $_SESSION['mensagem']; ?></p>
                    </div>
                </div>
                <?php
                unset($_SESSION['mensagem']);
                unset($_SESSION['tipo_mensagem']);
                ?>
            <?php endif; ?>
            
        <form class="dados" action="adp_edit.php" method="post">
            <!-- Campos de Dados Pessoais -->
            <div class="campo_nome">
                <label for="nomecompleto">Nome completo</label>
                <input type="text" name="nomecompleto" id="nomecompleto" value="<?php echo $nome_completo; ?>" required>
            </div>

            <div class="campo_email_data">
                <div>
                    <label for="email">E-mail</label>
                    <input type="email" name="email" id="email" value="<?php echo $email; ?>">
                </div>

                <div>
                    <label for="datanascimento">Data de nascimento</label>
                    <input type="text" placeholder="dd/mm/aaaa" name="datanascimento" id="datanascimento" value="<?php echo date('d/m/Y', strtotime($data_nascimento)); ?>" pattern="^(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[0-2])/(19|20)\d{2}$" title="Formato: dd/mm/aaaa" required>
                </div>
            </div>

            <div class="campo_genero_telefone">
                <div>
                    <label for="genero">Gênero</label>
                    <select id="genero" name="genero" required>
                        <option selected disabled value="">Selecione o gênero</option>
                        <option value="Feminino" <?php echo ($genero == 'Feminino') ? 'selected' : ''; ?>>Feminino</option>
                        <option value="Masculino" <?php echo ($genero == 'Masculino') ? 'selected' : ''; ?>>Masculino</option>
                        <option value="Outro" <?php echo ($genero == 'Outro') ? 'selected' : ''; ?>>Outro</option>
                    </select>
                </div>

                <div>
                    <label for="telefone">Telefone</label>
                    <input type="tel" placeholder="(99) 99999-9999" name="telefone" id="telefone" value="<?php echo $telefone; ?>" pattern="\(\d{2}\) \d{5}-\d{4}" title="Formato: (99) 99999-9999" required>
                </div>
            </div>

            <!-- Botão de Atualização -->
            <div class="botao_atualizar">
                <button type="submit">Atualizar</button>
            </div>
        </form>
    </div>

   
    <!-- Scripts para controlar o modal -->
    <script>
    // Mostrar o modal
    window.onload = function() {
        var modal = document.getElementById("modalMensagem");
        var fechar = document.getElementById("fecharModal");

        if (modal) {
            modal.style.display = "block";
        }

        if (fechar) {
            fechar.onclick = function() {
                modal.style.display = "none";
            }
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    };

    // Submeter automaticamente o formulário de foto ao selecionar uma nova imagem
    document.getElementById('inputFoto').addEventListener('change', function() {
        document.getElementById('formFotoPerfil').submit();
    });
    </script>
</body>
</html>