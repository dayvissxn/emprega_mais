<!-- Incluindo o conteúdo gerado pelo PHP -->
<?php include 'c_perfil_candidato.php'; ?>


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
    <title>Perfil do candidato</title>

    <link rel="stylesheet" href="c_perfil_candidato.css">

</head>

<body>
    <div class="container_left">

        <div class="button-container">
            <a href="javascript:void(0);" class="voltar_btn" onclick="window.history.back();">
                <i class="fa-regular fa-circle-left"></i>Voltar
            </a>
        </div>
    </div>

    <div class="container_right">
        <div class="white-box">

            <div class="foto_perfil">
                <img src="<?php echo htmlspecialchars($caminho_fotoperfil ?? 'img_candidates/foto_perfil_btn.png'); ?>" alt="Foto de Perfil">
            </div>


            <div class="dados">
                <!-- Campos de Dados Pessoais -->

                <!-- Dados do lado esquerdo nome, data... -->
                <div class="lado_esquerdo">

                    <label for="nomecompleto">Nome completo</label>
                    <input type="text" name="nomecompleto" id="nomecompleto" value="<?php echo $nome_completo; ?>" readonly>


                    <label for="datanascimento">Data de nascimento</label>
                    <input type="text" placeholder="dd/mm/aaaa" name="datanascimento" id="datanascimento" value="<?php echo date('d/m/Y', strtotime($data_nascimento)); ?>" readonly>

                    <label for="telefone">Telefone</label>
                    <input type="tel" placeholder="(99) 99999-9999" name="telefone" id="telefone" value="<?php echo $telefone; ?>" readonly>

                </div>


                <!-- Dados do lado direito cpf, email... -->
                <div class="lado_direito">

                    <label for="cpf">CPF</label>
                    <input type="text" placeholder="123.456.789-00" name="cpf" id="cpf" value="<?php echo $cpf; ?>" readonly>

                    <label for="email">E-mail</label>
                    <input type="email" name="email" id="email" value="<?php echo $email; ?>" readonly>

                    <label for="genero">Gênero</label>
                    <input type="text" id="genero" name="genero" value="<?php echo $genero; ?>" readonly>

                </div>

            </div>

            <div class="experiencia">
                <label for="experiencia">Experiências anteriores:</label>
                <textarea name="experiencia" id="experiencia" rows="10" cols="10" readonly><?php echo $experiencia_antecessora; ?></textarea>

                <form action="<?php echo $caminho_curriculo; ?>" target="_blank">
                    <div class="curriculo-container">
                        <i class="fa-regular fa-file"></i>
                        <button class="curriculo">VER CURRÍCULO</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

</body>

</html>