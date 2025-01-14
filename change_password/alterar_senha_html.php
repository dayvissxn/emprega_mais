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
    <title>Alterar senha</title>

    <link rel="stylesheet" href="alterar_senha.css">

</head>

<body>

    <!-- Incluindo o conteúdo gerado pelo PHP -->
    <?php include 'alterar_senha.php'; ?>

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

            <a href="../home_loggedin/logged_in_html.php" class="house"><i class="fa-solid fa-house"></i>Página inicial</a>

            <a href="../change_personal_data/alterar_dados_pessoais_html.php" class="alterar_dados"><i class="fa-solid fa-user-edit"></i>Alterar dados pessoais</a>

            <a href="../update_resume/atualizar_curriculo_html.php" class="atualizar_curriculo"><i class="fa-solid fa-file-alt"></i>Atualizar currículo</a>

            <a href="../change_password/alterar_senha_html.php" class="alterar_senha"><i class="fa-solid fa-key"></i>Alterar senha</a>

            <a href="../delete_account/excluir_conta_html.php" class="excluir_conta"><i class="fa-solid fa-trash"></i>Excluir minha conta</a>

        </div>
    </div>
    <div class="container_right">
        <div class="white-box">
            <h1 id="titulo">Alterar senha</h1>
            <br>
            <form method="POST" action="alterar_senha_html.php" onsubmit="return validarSenhas()">
                <div class="campo">
                    <label for="senha">Senha antiga<span class="asterisco">*</span></label>
                    <input type="password" name="senha" id="senha" required>
                </div>
                <div class="campo">
                    <label for="nova_senha">Nova senha<span class="asterisco">*</span></label>
                    <input type="password" name="nova_senha" id="nova_senha" required>
                </div>
                <div class="campo">
                    <label for="confirmarsenha">Confirme a senha<span class="asterisco">*</span>
                        <span id="mensagemErro" class="erro"></span>
                    </label>
                    <input type="password" name="confirmarsenha" id="confirmarsenha" required>
                </div>
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