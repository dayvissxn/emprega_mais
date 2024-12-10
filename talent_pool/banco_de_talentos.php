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

    

<style>
* {
    margin: 0;
    padding: 0;
    font-family: 'Ubuntu', sans-serif;
}
body {
    margin: 0;
    height: 100vh;
    background-color: #003079;
    background: linear-gradient(to right, #ffffff 20%, #003079);
    font-family: 'Ubuntu', sans-serif;
    display: flex;
}

/* PARTE ESQUERDA */
.container_left {
    width: 30%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: flex-start;
    padding-left: 40px;
    padding-top: 5%;
    align-self: flex-start;
}

.container_left .configurar_vagas h1 {
    color: #35383F;
    font-size: 40px;
    font-weight: bold;
    text-align: center;
    margin-left: 27px;
    margin-bottom: 42px;
    margin-top: 38px;
}

.button-container {
    display: block;
    background-color: transparent;
    min-width: 200px;
    z-index: 1;
    margin-left: 20px;
   
}

/* Links do button-container */
.button-container a {
    color: #35383F;
    padding: 12px 16px;
    font-size: 20px;
    text-decoration: none;
    display: block;
    margin-top: -6px;
    
}

/* Mudança de cor ao passar o mouse */
.button-container a:hover {
    background-color: #f1f1f1;
    color: #35383F;
    border-radius: 8.89px;
}

/* Ajuste para alinhar os ícones com o texto */
.button-container a {
    display: flex;
    align-items: center;
    font-weight: 500;
}

.button-container a i {
    margin-right: 27px; /* Espaçamento entre o ícone e o texto */
    font-size: 22px; /* Tamanho do ícone */
    color: #35383F;

}

/* Especifico para separar texto do icon*/
.button-container .criar_vaga_btn i {
    margin-right: 29px; /* Ajuste o valor conforme necessário */
}

.button-container .candidatos_btn i {
    font-size: 23px;
    margin-left: 1px;
    margin-right: 30px; /* Ajuste o valor conforme necessário */
}

.button-container .banco_de_talentos_btn i {
    margin-right: 30px; /* Ajuste o valor conforme necessário */
}

.button-container .voltar_btn i {
    margin-right: 28px; /* Ajuste o valor conforme necessário */
}
/* FIM PARTE ESQUERDA */

/* PARTE DIREITA */

form{
    display: flex;
    margin-top: 140px;
}

.caixa_pesquisar {
    display: flex;
    align-items: center;
    width: 435px;
    height: 45px;
    padding: 0 5px; 
    border: none;
    background-color: #fff;
    border-radius: 5px;
    box-sizing: border-box;
}

.input_pesquisar {
    border: none;
    padding: 0 5px; 
    margin: 0px 10px 0px 5px;
    flex-grow: 1;
    height: 30px;
    background-color: #ffff;
    font-size: 15px;
    width: 100%;
}

.caixa_pesquisar i {
    margin-left: 5px;
    color: #808080;
}

.botao_buscar {
    display: flex;
    margin-left: 40px;
}

.botao_buscar button {
    font-weight: 500;
    padding: 5px 50px;
    font-size: 20px; 
    background-color: #003079; 
    color: #ffffff; 
    border: none; 
    border-radius: 8.89px; 
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1), 
                0 6px 20px rgba(0, 0, 0, 0.1);
    cursor: pointer;

}

.botao_buscar button:hover {
    background-color: #0056b3; /* Cor de fundo dos botões ao passar o mouse */
    color: #FFE500;
}


table{
    margin-top: 50px;
}

.table th, .table td {
  vertical-align: middle; /* Alinha verticalmente ao meio */
 
}

/* Cor do fundo cabeçalho */
thead {
    background-color: #FFFFFF; /* Cor de fundo azul */
    text-align: center;
}

/* Cor do fundo impares */
.table-striped tbody tr:nth-of-type(odd) {
    background-color: #759DC2; /* Cor azul */
}

/* Cor do fundo pares */
.table-striped tbody tr:nth-of-type(even) {
    background-color: #FFFFFF; /* Cor branca */
   
}

/* Cor da linhas das tabelas e bordas */
.table-bordered {
    border: 1px solid #000; /* Cor da borda da tabela */
}

.table-bordered th,
.table-bordered td, 
.table-bordered tr {
    border: 1px solid #000; /* Cor da borda das células */
    padding: 3px 15px; 
}

.excluir {
    font-weight: 500;
    padding: 3px 25px; /* Preenchimento interno dos botões */
    font-size: 15px; /* Tamanho da fonte dos botões */
    background-color: #9A1B1B;
    color: #ffffff; /* Cor do texto dos botões */
    border: none; /* Remove a borda dos botões */
    border-radius: 8.89px; /* Borda arredondada dos botões */
    cursor: pointer;
}

.excluir:hover {
    background-color: #D81919; /* Cor de fundo dos botões ao passar o mouse */
    color: #FFE500;
}

.visualizar {
    font-weight: 500;
    padding: 3.5px 17px; /* Preenchimento interno dos botões */
    font-size: 15px; /* Tamanho da fonte dos botões */
    background-color: #0F921C;
    color: #ffffff; /* Cor do texto dos botões */
    border: none; /* Remove a borda dos botões */
    border-radius: 8.89px; /* Borda arredondada dos botões */
    cursor: pointer;
    margin-left: 5px;

}

.visualizar:hover {
    background-color: #37B944; /* Cor de fundo dos botões ao passar o mouse */
    color: #FFE500;
}


/* Estilos existentes */

Estilos responsivos
        @media (max-width: 1754px){
            .container_right {
                display: flex;
                justify-content: center;
            }

            .container_right .white-box {
                margin-left: 0px;
                
                width: 700px;
            }

        }

        @media (max-width: 950px) {
            body {
                flex-direction: column; /* Muda para coluna em telas menores */
            }

            .container_left, .container_right {
                width: 100%; /* Ocupa a largura total em telas menores */
            }

            .container_left {
                padding: 20px; /* Ajusta o padding conforme necessário */
            }

            .container_right {
                margin-top: 20px; /* Adicione margem conforme necessário */
                justify-content: flex-start;
                padding: 20px;
            }
        }


    </style>
</head>
<body>
    <div class="container_left">
        <div class="configurar_vagas">
            <h1>Configurar vagas</h1>
        </div>
        <div class="button-container"> 

            <a href="../create_vacancy/criar_vaga.html" class="criar_vaga_btn"><i class="fa-regular fa-square-plus"></i>Criar vaga</a>

            <a href="../update_vacancy/atualizar_vaga.php" class="atualizar_vaga_btn"><i class="fa-regular fa-pen-to-square"></i>Atualizar vaga</a>
            
            <a href="../candidates/candidatos.php" class="candidatos_btn"><i class="fa-regular fa-clipboard"></i>Candidatos</a>

            <a href="#" class="banco_de_talentos_btn"><i class="fa-solid fa-user"></i>Banco de talentos</a>

            <a href="../home_loggedin/logged_in.php" class="voltar_btn"><i class="fa-regular fa-circle-left"></i>Voltar</a>

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

            <?php
                // Conexão com o banco de dados
                $conn = mysqli_connect("localhost", "root", "12345", "emprega_mais");
                if ($conn->connect_error) {
                    die("Connection failed:" . $conn->connect_error);
                }

                // Verifica se o parâmetro de pesquisa foi enviado
                $pesquisa = isset($_GET['pesquisar']) ? $_GET['pesquisar'] : '';

                // Monta a query de seleção com base no campo de pesquisa
                $sql = "SELECT id, nome_completo, cpf, data_nascimento, genero FROM usuarios";
                if (!empty($pesquisa)) {
                    // Adiciona a cláusula WHERE para buscar em nome_completo, cpf, data_nascimento ou genero
                    $sql .= " WHERE nome_completo LIKE '%$pesquisa%' 
                            OR cpf LIKE '%$pesquisa%' 
                            OR data_nascimento LIKE '%$pesquisa%' 
                            OR genero LIKE '%$pesquisa%'";
                }

                $result = $conn->query($sql);

        
            if ($result->num_rows > 0) {
                
                    echo '<table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">NOME COMPLETO</th>
                                    <th scope="col">CPF</th>
                                    <th scope="col">DATA DE NASCIMENTO</th>
                                    <th scope="col">GÊNERO</th>
                                    <th scope="col">AÇÕES</th>
                                </tr>
                            </thead>
                            <tbody>';
                    
                    $index = 1; // Contador para a numeração das linhas
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>
                                <th scope="row">' . $index . '</th>
                                <td>' . htmlspecialchars($row['nome_completo']) . '</td>
                                <td>' . htmlspecialchars($row['cpf']) . '</td>
                                <td>' . htmlspecialchars($row['data_nascimento']) . '</td>
                                <td>' . htmlspecialchars($row['genero']) . '</td>
                                <td>
                                    <!-- Botão de Excluir -->
                                    <form action="bdt_delete.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="id" value="' . $row['id'] . '">
                                        <button type="submit" class="excluir" onclick="return confirm(\'Tem certeza de que deseja excluir esta conta? Essa ação não poderá ser desfeita!\')">Excluir</button>
                                    </form>
                    
                                    <!-- Botão de Ver -->
                                    <a href="../talent_pool/bdt_perfil_candidato.php?id=' . $row['id'] . '" class="btn visualizar" role="button">Visualizar</a>
                                </td>
                            </tr>';
                        $index++; // Incrementa o contador
                    }
                
                     echo '</tbody></table>';
                    
                } else {
                    echo "0 results";
                }
              

            $conn->close();
        
            ?>
    </div>
</body>
</html>
