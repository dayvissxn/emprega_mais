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

    <!-- Adicionar Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- Fim do código para Font Awesome -->

    <title>Atualizar vaga</title>

    <link rel="stylesheet" href="atualizar_vaga.css">

    <script>
        function confirmDelete(event) {
            if (!confirm('Você tem certeza que deseja excluir esta vaga?')) {
                event.preventDefault();
            }
        }
    </script>

</head>

<body>
    <div class="container_left">
        <div class="configurar_vagas">
            <h1>Configurar vagas</h1>
        </div>
        <div class="button-container">

            <a href="../create_vacancy/criar_vaga.html" class="criar_vaga_btn"><i class="fa-regular fa-square-plus"></i>Criar vaga</a>

            <a href="#" class="atualizar_vaga_btn"><i class="fa-solid fa-pen-to-square"></i>Atualizar vaga</a>

            <a href="../candidates/candidatos_html.php" class="candidatos_btn"><i class="fa-regular fa-clipboard"></i>Candidatos</a>

            <a href="../talent_pool/banco_de_talentos_html.php" class="banco_de_talentos_btn"><i class="fa-regular fa-user"></i>Banco de talentos</a>

            <a href="../home_loggedin/logged_in_html.php" class="voltar_btn"><i class="fa-regular fa-circle-left"></i>Voltar</a>

        </div>
    </div>
    <div class="container_right">

        <!-- Incluindo o conteúdo gerado pelo PHP -->
        <?php include 'atualizar_vaga.php'; ?>

    </div>
</body>

</html>