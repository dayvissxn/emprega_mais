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

    <link rel="stylesheet" type="text/css" media="screen">
    <title>Pagina inicial</title>

    <link rel="stylesheet" href="inicio.css">

</head>

<body>
    <header> <!-- Inicio cabeçalho -->
        <div class="logo_header">
            <img src="img_home_page/empregamais.png" alt="logo">
        </div>
        <nav class="menu_header">
            <ul>
                <li><a class="vagas" href="#">Vagas</a></li>
                <li><a class="sobre_nos" href="#">Sobre nós</a></li>
            </ul>
        </nav>
        <div class="botoes_header">
            <button class="login" onclick="window.location.href='../login/login_html.php'">Login</button>
            <button class="cadastre_se" onclick="window.location.href='../create_account/register.html'">Cadastre-se</button>
        </div>
    </header><!-- Fim cabeçalho -->

    <banner><!-- Inicio foto texto oportun... -->
        <div class="container_banner">
            <div class="icon_banner">
                <img src="img_home_page/banner_img.png" alt="foto">
                <div class="texto_banner">
                    <h1>OPORTUNIDADE DE</h1>
                    <h2>EMPREGO</h2>
                </div>
            </div>
        </div>
    </banner><!-- Fim foto texto oportun... -->

    <main><!-- Inicio conteudo principal -->
        <div class="container_main">

            <!-- Inicio Caixa de pesquisa -->
            <form method="GET" action="">
                <div class="container_buscar">
                    <div class="campo_buscar">
                        <label for="vaga">Busque sua vaga</label>
                        <div class="caixa_buscar">
                            <input class="input_vaga" type="text" placeholder="Nome da vaga" name="vaga" id="vaga">
                            <i class="fa fa-search"></i>
                        </div>
                    </div>
                    <div class="campo_empresa">
                        <label for="empresa">Empresa</label>
                        <div class="caixa_empresa">
                            <input class="input_empresa" type="text" placeholder="Nome da empresa" name="empresa" id="empresa">
                            <i class="fa-solid fa-building"></i>
                        </div>
                    </div>
                    <div class="botao_buscar_vagas">
                        <button type="submit">Buscar vagas</button>
                    </div>
                </div>
            </form>
            <!-- Fim Caixa de pesquisa -->

            <div class="container_vagas"> <!-- Inicio vagas -->
                <h1>Vagas disponíveis</h1>

                <!-- Incluindo o conteúdo gerado pelo PHP -->
                <?php include 'inicio.php'; ?>

            </div> <!-- Fim vagas -->
        </div>
    </main><!-- Fim conteudo principal -->

    <footer><!-- Inicio rodapé -->
        <div class="container_footer">
            <div class="contatos_footer">
                <div class="logo_footer">
                    <img src="img_home_page/empregamaisfooter2.png" alt="logo">
                </div>
                <div class="social_media_footer">
                    <a href="https://maps.app.goo.gl/xKHmXhAcs7vcKfSS6" target="_blank" rel="noopener noreferrer" class="footer_link" id="location">
                        <i class="fa-solid fa-location-dot"></i>
                    </a>
                    <a href="https://www.facebook.com/profile.php?id=100069873004399" target="_blank" rel="noopener noreferrer" class="footer_link" id="facebook">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a href="https://www.instagram.com/magazine_nossa_loja?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank" rel="noopener noreferrer" class="footer_link" id="instagram">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                </div>
            </div>
            <ul class="lista_footer">
                <li>
                    <a href="#" class="footer_link">Desenvolvedores</a>
                </li>
            </ul>
            <ul class="lista_footer">
                <li>
                    <a href="#" class="footer_link">Perguntas e Respostas</a>
                </li>
            </ul>
            <ul class="lista_footer">
                <li>
                    <a href="#" class="footer_link" id="fl_ajuda">Ajuda</a>
                </li>
            </ul>
        </div>
        <div class="copyright_footer">
            &#169 2024 Emprega mais
        </div>
    </footer><!-- Fim rodapé -->
</body>

</html>