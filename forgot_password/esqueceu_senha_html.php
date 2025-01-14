<!-- Incluindo o conteúdo gerado pelo PHP -->
<?php include 'esqueceu_senha.php'; ?>

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

    <link rel="stylesheet" href="esqueceu_senha.css">

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
            <?php unset($_SESSION['erro']); // Remove a mensagem de erro após exibir 
            ?>
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
            <li><a onclick="window.location.href='../login/login_html.php'">Voltar ao login!</a></li>
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