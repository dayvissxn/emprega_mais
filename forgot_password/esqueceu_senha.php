<?php
session_start();
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
    <title>Esqueceu sua senha</title>

    <style>

body {
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
    width: 600px;
    height: 600px;
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

.es_texto{
    text-align: center;
    font-size: 17px;
    color: #35383F;
    width: 450px;
    margin-bottom: 40px;
}

input{
    padding: 10px;
    width: 300px;
    height: 16px; /* Ajuste a altura conforme necessário */
    border: none;
    box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.082);
    background-color: #EEEEEE;
    display: block;
    border-radius: 8.89px;
    font-family: 'Ubuntu', sans-serif;
    margin-top:20px;
}
select{
    padding: 10px;
    width: 320px;
    height: 35px; /* Ajuste a altura conforme necessário */
    border: none;
    box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.082);
    background-color: #EEEEEE;
    display: block;
    border-radius: 8.89px;
    font-family: 'Ubuntu', sans-serif;
    margin-top:20px;
    cursor: pointer;
}

.botao_confirmar {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    margin-top: 80px; /* Empurra o botão para a parte inferior do contêiner */

}

.botao_confirmar button {
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

.botao_confirmar button:hover {
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
        <h1 id="titulo">Esqueceu sua senha?</h1>
        
        <p class="es_texto">Digite o seu CPF e selecione uma pergunta de segurança. A resposta à pergunta foi definida por você no momento da criação da conta. Após confirmar a resposta corretamente, será permitido criar uma nova senha.</p>
        
        <!-- Exibe a mensagem de erro, se existir -->
        <?php if (isset($_SESSION['erro'])): ?>
            <div class="overlay" id="overlay"></div>
            <div class="erro-box" id="erroBox">
                <?php echo $_SESSION['erro']; ?>
                <button onclick="fecharErro()">×</button>
            </div>
            <?php unset($_SESSION['erro']); // Remove a mensagem de erro após exibir ?>
        <?php endif; ?>

        <form class="esqueceu_senha" action="es_confirmar.php" method="POST">
            <input type="text" placeholder="CPF 123.456.789-00" name="cpf" id="cpf" pattern="\d{3}\.\d{3}\.\d{3}-\d{2}" title="Formato: 123.456.789-00" required>

            <select name="pergunta" id="pergunta" required>
                <option value="">Selecione uma pergunta</option>
                <option value="pergunta1">1 - Qual foi o nome da sua primeira escola?</option>
                <option value="pergunta2">2 - Qual era o nome do seu primeiro animal de estimação?</option>
                <option value="pergunta3">3 - Qual é o nome do seu filme favorito?</option>
                <option value="pergunta4">4 - Qual é o nome do seu melhor amigo de infância?</option>
            </select>

            <input type="text" placeholder="Digite sua resposta" name="resposta" id="resposta" required>

            <div class="botao_confirmar">
                <button type="submit">Confirmar</button>
            </div>
            <li><a onclick="window.location.href='../login/login.php'">Voltar ao login!</a></li>
        </form>
    </div>

    <!-- Script para fechar a mensagem de erro -->
    <script>
        function fecharErro() {
            document.getElementById('erroBox').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        }

        // Fechar ao clicar fora da caixa de erro (overlay)
        document.getElementById('overlay').addEventListener('click', fecharErro);
    </script>

</body>
</html>