

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

    <link rel="stylesheet" href="alterar_dados_pessoais.css">

</head>

<body>
    <!-- Incluindo o conteúdo gerado pelo PHP -->
    <?php include 'alterar_dados_pessoais.php'; ?>
    
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