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

    <title>Banco de talentos</title>

    <link rel="stylesheet" href="banco_de_talentos.css">


</head>
<body>
    <div class="container_left">
        <div class="configurar_vagas">
            <h1>Configurar vagas</h1>
        </div>
        <div class="button-container"> 

            <a href="../create_vacancy/criar_vaga.html" class="criar_vaga_btn"><i class="fa-regular fa-square-plus"></i>Criar vaga</a>

            <a href="../update_vacancy/atualizar_vaga_html.php" class="atualizar_vaga_btn"><i class="fa-regular fa-pen-to-square"></i>Atualizar vaga</a>
            
            <a href="../candidates/candidatos_html.php" class="candidatos_btn"><i class="fa-regular fa-clipboard"></i>Candidatos</a>

            <a href="#" class="banco_de_talentos_btn"><i class="fa-solid fa-user"></i>Banco de talentos</a>

            <a href="../home_loggedin/logged_in_html.php" class="voltar_btn"><i class="fa-regular fa-circle-left"></i>Voltar</a>

        </div>
    </div>
    <div class="container_right">

        <!-- Inicio Caixa de pesquisa -->
            <form method="GET" action="">
                  
                <div class="caixa_pesquisar">
                    <i class="fa fa-search"></i>
                    <input class="input_pesquisar" type="text" placeholder="Pesquisar" name="pesquisar" id="pesquisar">        
                </div>           
                            
                <div class="botao_buscar">
                    <button type="submit">Buscar</button>
                </div>
                
            </form>
            <!-- Fim Caixa de pesquisa -->

            <!-- Incluindo o conteúdo gerado pelo PHP -->
            <?php include 'banco_de_talentos.php'; ?>

    </div>
</body>
</html>
