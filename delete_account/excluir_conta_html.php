<!-- Incluindo o conteúdo gerado pelo PHP -->
<?php include 'excluir_conta.php'; ?>

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
    <!-- Adicionar Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- Fim do código para Font Awesome -->
    <!-- Título da página (aparece na aba) -->
    <title>Excluir conta</title>

    <link rel="stylesheet" href="excluir_conta.css">

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

            <a href="../home_loggedin/logged_in_html.php" class="house"><i class="fa-solid fa-house"></i>Página inicial</a>

            <a href="../change_personal_data/alterar_dados_pessoais_html.php" class="alterar_dados"><i class="fa-solid fa-user-edit"></i>Alterar dados pessoais</a>

            <a href="../update_resume/atualizar_curriculo_html.php" class="atualizar_curriculo"><i class="fa-solid fa-file-alt"></i>Atualizar currículo</a>

            <a href="../change_password/alterar_senha_html.php" class="alterar_senha"><i class="fa-solid fa-key"></i>Alterar senha</a>

            <a href="../delete_account/excluir_conta_html.php" class="excluir_conta"><i class="fa-solid fa-trash"></i>Excluir minha conta</a>

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