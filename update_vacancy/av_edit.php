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
    <title>Editar vaga</title>
    <style>
* {
    margin: 0;
    padding: 0;
}
body {
    margin: 0;
    height: 100vh; /* Certifique-se de que a altura do body ocupe toda a altura da viewport */
    background-color: #003079;
    background: linear-gradient(to right, #cecdcd, #00307993, #cecdcd);
    font-family: 'Ubuntu', sans-serif;
    display: flex;
    justify-content: center; /* Centraliza horizontalmente */
    align-items: center; /* Centraliza verticalmente */
}

.white-box {
    background-color: #ffffff;
    border-radius: 25px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1), 
                0 6px 20px rgba(0, 0, 0, 0.1);
    width: 500px;
    height: 600px;
    display: flex;
    justify-content: flex-start; /* Alinha o conteúdo no topo do contêiner */
    align-items: center;
    flex-direction: column;
    padding-top: 10px; /* Espaço entre o topo do contêiner e o conteúdo */
    margin: 10px;
}

.titulo_id {
    margin-left: 5px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 10px; /* Adiciona espaço abaixo do título */
    margin-top: 20px;
}

.titulo_id label {
    font-family: "Ubuntu", sans-serif;
    font-weight: 700;
    color: #1F1F1F;
    font-size: 25px; /* Ajuste o tamanho da fonte conforme necessário */ 
}

.titulo_id input[type="text"] {
    padding: 7px;
    border: none;
    font-size: 25px; /* Ajuste o tamanho da fonte conforme necessário */
    font-weight: 700;
    background-color: transparent;
    font-family: 'Ubuntu', sans-serif;
}

fieldset {
    border: 0;
}

.campo {
    margin-bottom: 15px;
    display: inline-block; /* Para colocar os campos lado a lado */
    width: calc(50% - 0px); /* Define a largura dos campos para 50% menos a margem */
}

.campo label {
    margin-left: 10px;
    margin-bottom: 5px;
    color: #0000008a;
    display: block;
    font-weight: 400;
}

.campo input[type="text"] {
    padding: 7px;
    margin-left: 5px;
    border: none;
    box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.082);
    background-color: #EEEEEE;
    display: block;
    width: 80%; /* Largura total */
    border-radius: 8.89px;
    font-family: 'Ubuntu', sans-serif;
}

.descricao_vaga label {
    margin-bottom: 5px;
    margin-left: 10px;
    color: #0000008a;
    display: block;
    font-weight: 400;
}

textarea {
        width: 100%;
        padding: 5px; 
        height: 100px;
        margin-left: 5px;
        resize: none; /* Impede que o usuário redimensione o textarea */
        border: none;
        box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.082);
        background-color: #EEEEEE;
        display: block;
        width: 92%; /* Largura total */
        border-radius: 8.89px;
        font-size: 15px;
        font-family: 'Ubuntu', sans-serif;
        }

.botoes {
    display: flex;
    justify-content: space-evenly;
    margin-top: 50px;

}

.botoes button {
    font-weight: 700;
    padding: 8px 35px; /* Preenchimento interno dos botões */
    font-size: 20px; /* Tamanho da fonte dos botões */
    color: #ffffff; /* Cor do texto dos botões */
    border: none; /* Remove a borda dos botões */
    border-radius: 8.89px; /* Borda arredondada dos botões */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.397); /* Adiciona sombra */
    cursor: pointer;
}

.botoes .salvar {
    background-color: #003079; 
}

.botoes .salvar:hover {
    background-color: #0056b3; /* Cor de fundo dos botões ao passar o mouse */
    color: #FFE500;
}

.botoes .cancelar {
    background-color: #9A1B1B; 
}

.botoes .cancelar:hover {
    background-color: #D81919; /* Cor de fundo dos botões ao passar o mouse */
    color: #FFE500;
}

    </style>
</head>
<body>
   
        <?php
        $conn = mysqli_connect("localhost", "root", "12345", "emprega_mais");
        if ($conn->connect_error) {
            die("Connection failed:" . $conn->connect_error);
        }

        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $sql = "SELECT id, nome, tipo, disponivel, quantidade_vagas, escolaridade, empresa, localidade, carga_horaria, descricao_vaga FROM vagas WHERE id='$id'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo "<div class='white-box'>";
                    echo "<form action='av_update.php' method='POST'>";
                        echo "<div class='titulo_id'>";
                            echo "<label>ID:</label><input type='text' name='id' value='" . $row["id"] . "' readonly>";
                        echo "</div>";

                        echo "<fieldset class='grupo'>";
                            echo "<div class='campo'>";
                                echo "<label for='nome_" . $row["id"] . "'>Nome:</label><input type='text' id='nome_" . $row["id"] . "' name='nome' value='" . $row["nome"] . "'>";
                            echo "</div>";
                            
                            echo "<div class='campo'>";
                                echo "<label for='tipo_" . $row["id"] . "'>Tipo:</label><input type='text' id='tipo_" . $row["id"] . "' name='tipo' value='" . $row["tipo"] . "'>";
                            echo "</div>";
                        echo "</fieldset>";

                        echo "<fieldset class='grupo'>";
                            echo "<div class='campo'>";
                                echo "<label for='disponivel_" . $row["id"] . "'>Disponivel:</label><input type='text' id='disponivel_" . $row["id"] . "' name='disponivel' value='" . $row["disponivel"] . "'>";
                            echo "</div>";

                            echo "<div class='campo'>";
                                echo "<label for='quantidade_vagas_" . $row["id"] . "'>Quantidade vagas:</label><input type='text' id='quantidade_vagas_" . $row["id"] . "' name='quantidade_vagas' value='" . $row["quantidade_vagas"] . "'>";
                            echo "</div>";
                        echo "</fieldset>";

                        echo "<fieldset class='grupo'>";
                            echo "<div class='campo'>";
                                echo "<label for='escolaridade_" . $row["id"] . "'>Escolaridade:</label><input type='text' id='escolaridade_" . $row["id"] . "' name='escolaridade' value='" . $row["escolaridade"] . "'>";
                            echo "</div>";

                            echo "<div class='campo'>";
                                echo "<label for='empresa_" . $row["id"] . "'>Empresa:</label><input type='text' id='empresa_" . $row["id"] . "' name='empresa' value='" . $row["empresa"] . "'>";
                            echo "</div>";
                        echo "</fieldset>";

                        echo "<fieldset class='grupo'>";
                            echo "<div class='campo'>";
                                echo "<label for='localidade_" . $row["id"] . "'>Localidade:</label><input type='text' id='localidade_" . $row["id"] . "' name='localidade' value='" . $row["localidade"] . "'>";
                            echo "</div>";

                            echo "<div class='campo'>";
                                echo "<label for='carga_horaria_" . $row["id"] . "'>Carga horária:</label><input type='text' id='carga_horaria_" . $row["id"] . "' name='carga_horaria' value='" . $row["carga_horaria"] . "'>";
                            echo "</div>";
                        echo "</fieldset>";

                        echo "<div class='descricao_vaga'>";
                            echo "<label for='descricao_vaga_" . $row["id"] . "'>Descrição da vaga:</label><textarea id='descricao_vaga_" . $row["id"] . "' name='descricao_vaga'>" . $row["descricao_vaga"] . "</textarea>";
                        echo "</div>";

                        echo "<div class='botoes'>";
                            echo "<button type='submit' class='salvar'>Salvar</button>";
                            echo "<button type='button' class='cancelar' onclick='window.history.back()'>Cancelar</button>";
                        echo "</div>";
                    echo "</form>";
                echo "</div>";
            } else {
                echo "Vaga não encontrada.";
            }
        } else {
            echo "ID da vaga não especificado.";
        }

        $conn->close();
        ?>
    
</body>
</html>
