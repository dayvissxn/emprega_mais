<?php
session_start();
require_once 'es_conexao.php';

if (!isset($_SESSION['id_usuario'])) {
    // Se o ID do usuário não estiver na sessão, redirecionar para a página de login
    header("Location: ../login/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Remove password_hash() para armazenar a senha em texto claro
    $nova_senha = $_POST['nova_senha'];
    $id_usuario = $_SESSION['id_usuario'];

    // Atualizar a senha no banco de dados
    $stmt = $conn->prepare("UPDATE usuarios SET senha = ? WHERE id = ?");
    $stmt->bind_param("si", $nova_senha, $id_usuario);
    
    if ($stmt->execute()) {
        // Senha alterada com sucesso
        echo "<script>alert('Senha alterada com sucesso!'); window.location.href='../login/login.php';</script>";
        session_destroy(); // Destroi a sessão após a alteração da senha
    } else {
        echo "<script>alert('Erro ao alterar a senha. Tente novamente.'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
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
    <title>Criar senha</title>

<style>
    body{
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    font-family: 'Ubuntu', sans-serif;
    background: linear-gradient(to right, #ffff, #003079);
}

.white-box {
    background-color: #ffffff;
    border-radius: 35.56px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1), 
                0 6px 20px rgba(0, 0, 0, 0.1);
    width: 500px;
    height: 460px;
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

.campo {
    margin-top: 30px;
    margin-bottom: 30px;
    width: calc(100% - 25px); 
}

.campo label {
    margin-bottom: 5px;
    margin-left: 5px;
    color: #A7A7A7;
    display: inline-block;
    font-weight: 500;
    width: 100%;
    font-size: 20px;
}

.campo input[type="password"] {
    padding: 10px;
    width: 100%;
    height: 15px; /* Ajuste a altura conforme necessário */
    border: none;
    box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.082);
    background-color: #EEEEEE;
    display: block;
    border-radius: 8.89px;
    font-family: 'Ubuntu', sans-serif;
    margin-right: 100px;
    
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
    padding: 10px 40px; /* Preenchimento interno dos botões */
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

li{
    text-align: center;
    list-style-type: none;
    margin-top: 13px;
    
}
a{
    color: #0056b3;
    text-decoration: none;
    cursor: pointer;
    font-weight: 500;
 
}

a:hover{
    color: #FFE500;
}

.erro-box {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
    padding: 15px;
    width: 80%;
    max-width: 320px;
    text-align: center;
    z-index: 9999;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    font-size: 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-radius: 8px;
}

/* Estilo para o botão de fechar (X) */
.erro-box button {
    background: none;
    border: none;
    color: #721c24;
    font-weight: bold;
    font-size: 23px;
    cursor: pointer;
}

.overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 9998;
}

</style>

</head>
<body>

    <div class="white-box">
        <h1 id="titulo">Criar senha</h1>
       
        <form method="POST" onsubmit="return validarSenhas()">
            <div class="campo">                        
                <label for="nova_senha">Nova senha<span class="asterisco">*</span></label>
                <input type="password" name="nova_senha" id="nova_senha" required>
            </div>
            <div class="campo">
                <label for="confirmarsenha">Confirme a senha<span class="asterisco">*</span><span id="mensagemErro" class="erro"></span></label>
                <input type="password" name="confirmarsenha" id="confirmarsenha" required>
            </div> <!-- Fim Senhas -->
            <div class="botao_atualizar">
                <button type="submit">Atualizar</button>
            </div>
            <li><a onclick="window.location.href='../login/login.php'">Voltar!</a></li>
        </form>
    </div>

<script>
    function validarSenhas() {
        var senha = document.getElementById('nova_senha').value;
        var confirmarSenha = document.getElementById('confirmarsenha').value;
        var mensagemErro = document.getElementById('mensagemErro');

        if (senha !== confirmarSenha) {
            mensagemErro.textContent = " Senhas diferentes.";
            return false;
        }

        mensagemErro.textContent = ""; // Limpar a mensagem de erro se as senhas forem iguais
        return true;
    }

    // Função para exibir o modal com uma mensagem
    function showModal(message) {
        var modal = document.getElementById("myModal");
        var modalMessage = document.getElementById("modalMessage");
        modalMessage.textContent = message;
        modal.style.display = "block";

        // Fecha o modal quando o usuário clica no "x"
        var span = document.getElementsByClassName("close")[0];
        span.onclick = function() {
            modal.style.display = "none";
        };

        // Fecha o modal quando o usuário clica fora do modal
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        };
    }

    // Verifica se há uma mensagem passada pelo PHP via query string
    window.onload = function() {
        var urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('message')) {
            showModal(urlParams.get('message'));
        }
    };
</script>
</body>
</html>