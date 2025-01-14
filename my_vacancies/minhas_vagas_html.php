<!-- Incluindo o conteúdo gerado pelo PHP -->
<?php include 'minhas_vagas.php'; ?>

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

    <title>Candidatos</title>

    <link rel="stylesheet" href="minhas_vagas.css">

    <script>
    function confirmarExclusao(botao) {
        if (confirm("Tem certeza que deseja cancelar sua inscrição na vaga?")) {
            // Enviar o formulário se o usuário confirmar
            botao.closest('form').submit();
        }
    }
    </script>

    
</head>
<body>
    <div class="container_left">
        <div class="configurar_vagas">
            <h1>Minhas vagas</h1>
        </div>
        <div class="button-container"> 

            <a href="../home_loggedin/logged_in_html.php" class="voltar_btn"><i class="fa-regular fa-circle-left"></i>Voltar</a>

        </div>
    </div>
    <div class="container_right">

        <!-- Incluindo o conteúdo gerado pelo PHP -->
        <?php include 'mv_vagas.php'; ?>

    </div>
</body>
</html>