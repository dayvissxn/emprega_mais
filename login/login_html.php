<!-- Incluindo o conteúdo gerado pelo PHP -->
<?php include 'login.php'; ?>

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

    <title>Login </title>

    <link rel="stylesheet" href="login.css">

</head>

<body>
    <div class="painel" id="painel">
        <div class="forma-painel entrar">
            <form action="" method="POST">
                <h1>Entrar</h1>
                <span>Insira as informações</span>
                <?php
                if (!empty($error_message)) {
                    echo '<div class="error-message">' . $error_message . '</div>';
                }
                ?>
                <input type="text" name="cpf" placeholder="CPF 123.456.789.00" pattern="\d{3}\.\d{3}\.\d{3}-\d{2}" title="Formato: 123.456.789-00" />
                <input type="password" name="senha" placeholder="Senha" />
                <a href="../forgot_password/esqueceu_senha_html.php">Esqueceu sua Senha?</a>
                <button type="submit">Entrar</button>
            </form>
        </div>
        <div class="painel-inscrever">
            <div class="inscrever">
                <div class="inscrever-painel inscrever-direita">
                    <h1>Olá, tudo bem?</h1>
                    <p>
                        Registre-se com seus dados para ter acesso às vagas
                    </p>
                    <a onclick="window.location.href='../create_account/register.html'">
                        <button class="hidden" id="register"> Criar conta</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>