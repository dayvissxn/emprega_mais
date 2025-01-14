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

    <!-- Adicionar bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Fim do código para bootstrap -->

    <title>Candidatos inscritos</title>

    <link rel="stylesheet" href="c_ver_candidatos.css">

</head>

<body>

    <!-- Incluindo o conteúdo gerado pelo PHP -->
    <?php include 'c_ver_candidatos_pesquisa.php'; ?>

    <!-- Caixa de pesquisa -->
    <form method="GET" action="">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id_vaga); ?>">
        <div class="caixa_pesquisar">
            <i class="fa fa-search"></i>
            <input class="input_pesquisar" type="text" placeholder="Pesquisar" name="pesquisar" id="pesquisar">
        </div>
        <div class="botao_buscar">
            <button type="submit">Buscar</button>
        </div>
    </form>

    <!-- Incluindo o conteúdo gerado pelo PHP -->
    <?php include 'c_ver_candidatos_tabela.php'; ?>

</body>

</html>