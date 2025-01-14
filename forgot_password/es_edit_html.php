<!-- Incluindo o conteúdo gerado pelo PHP -->
<?php include 'es_edit.php'; ?>

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

    <link rel="stylesheet" href="es_edit.css">

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
            <li><a onclick="window.location.href='../login/login_html.php'">Voltar!</a></li>
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