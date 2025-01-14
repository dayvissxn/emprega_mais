<!-- Incluindo o conteúdo gerado pelo PHP -->
<?php include 'atualizar_curriculo.php'; ?>

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

    <link rel="stylesheet" href="atualizar_curriculo.css">

    
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