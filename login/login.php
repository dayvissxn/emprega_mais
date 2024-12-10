<?php
include('conexao_login.php');

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['cpf']) && isset($_POST['senha'])) {
        if (strlen($_POST['cpf']) == 0) {
            $error_message = "Preencha seu CPF";
        } else if (strlen($_POST['senha']) == 0) {
            $error_message = "Preencha sua Senha";
        } else {
            $cpf = $mysqli->real_escape_string($_POST['cpf']);
            $senha = $mysqli->real_escape_string($_POST['senha']);

            $sql_code = "SELECT * FROM usuarios WHERE cpf = '$cpf' AND senha = '$senha'";
            $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

            $quantidade = $sql_query->num_rows;

            if ($quantidade == 1) {
                $usuario = $sql_query->fetch_assoc();

                if (!isset($_SESSION)) {
                    session_start();
                }

                $_SESSION['id_usuario'] = $usuario['id'];
                $_SESSION['nome_completo'] = $usuario['nome_completo'];
                $_SESSION['cpf'] = $usuario['cpf'];
                $_SESSION['telefone'] = $usuario['telefone'];
                $_SESSION['data_nascimento'] = $usuario['data_nascimento'];
                $_SESSION['genero'] = $usuario['genero'];
                $_SESSION['email'] = $usuario['email'];
                $_SESSION['experiencia_antecessora'] = $usuario['experiencia_antecessora'];
                $_SESSION['caminho_curriculo'] = $usuario['caminho_curriculo'];
                $_SESSION['caminho_fotoperfil'] = $usuario['caminho_fotoperfil'];

                header("Location: ../home_loggedin/logged_in.php");
                exit(); // Certifique-se de que a execução do script pare após o redirecionamento
            } else {
                $error_message = "Falha ao logar! CPF ou Senha incorretos";
            }
        }
    }
}
?>
 
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
    <link rel="stylesheet" type="text/css" href="#" media="screen">
    <title>Login </title>

<style>

*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Ubuntu", sans-serif;
}

body{
    background-color: #003079;
    background: linear-gradient(to right, #ffff, #003079);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    height: 100vh;
}

.painel{
    background-color: #ffff;
    border-radius: 35.56px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1), 
                0 6px 20px rgba(0, 0, 0, 0.1);
    position: relative;
    overflow: hidden;
    width: 768px;
    max-width: 100%;
    min-height: 480px;
}

.forma-painel h1{
    margin-bottom: 20px;
    font-size: 40px;
}


.painel p{
    font-size: 15px;
    line-height: 20px;
    letter-spacing: 0.2px;
    margin: 20px 0;
}

.painel span{
    font-size: 12px;
}

.painel a{
    color: #0056b3;
    font-size: 13px;
    text-decoration: none;
    margin: 15px 0 10px;
}

.painel a:hover{
    color: #ffe600;
}

.painel button{
    background-color: #003079;
    color: #ffff;
    font-size: 14px;
    padding: 10px 45px;
    border: 1px solid transparent;
    border-radius: 8.89px;
    font-weight: 600;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    margin-top: 10px;
    cursor: pointer;
}

.painel button:hover{
    background-color: #0056b3;
    color: #ffe600;
}

.painel button.hidden{
    background-color: transparent;
    border-color: #ffff;
}

.painel button.hidden:hover{
    background-color: #0056b3;
    color: #ffe600;
}

.painel form{
    background-color: #ffff;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding: 0 40px;
    height: 100%;
}

.painel input{
    background-color: #eee;
    border: none;
    margin: 8px 0;
    padding: 10px 15px;
    font-size: 13px;
    border-radius: 8px;
    width: 100%;
    outline: none;
}

.forma-painel{
    position: absolute;
    top: 0;
    height: 100%;
}

.entrar{
    left: 0;
    width: 50%;
    z-index: 2;
}

.painel-inscrever{
    position: absolute;
    top: 0;
    left: 50%;
    width: 50%;
    height: 100%;
    overflow: hidden;
    border-radius: 150px 0 0 120px;
    z-index: 1000;
}

.inscrever{
    background-color: #003079;
    height: 100%;
    background: linear-gradient(to right, #003079, #507ec2);
    color: #ffff;
    position: relative;
    left: -100%;
    height: 100%;
    width: 200%;
}

.inscrever-painel{
    position: absolute;
    width: 50%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding: 0 30px;
    text-align: center;
    top: 0;
}

.inscrever-direita{
    right: 0;
}

    .error-message {
        color: red;
        margin-top: 10px;
        font-family: "Ubuntu", sans-serif;
        font-size: 0.9em;
    }
</style>
<!--  -->
<!--  -->

</head>
<body>
    <div class="painel" id="painel">
        <div class="forma-painel entrar">
            <form action="" method="POST">
                <h1>Entrar</h1>
                <span>Insira as informações</span>
                <?php
                if (!empty($error_message)) {
                    echo '<div class="error-message">' . $error_message . '</div>';
                }
                ?>
                <input type="text" name="cpf" placeholder="CPF 123.456.789.00" pattern="\d{3}\.\d{3}\.\d{3}-\d{2}" title="Formato: 123.456.789-00"/> 
                <input type="password" name="senha" placeholder="Senha" />
                <a href="../forgot_password/esqueceu_senha.php">Esqueceu sua Senha?</a>
                <button type="submit">Entrar</button>
            </form>
        </div>
        <div class="painel-inscrever">
            <div class="inscrever">
                <div class="inscrever-painel inscrever-direita">
                    <h1>Olá, tudo bem?</h1>  
                    <p>
                        Registre-se com seus dados para ter acesso às vagas
                    </p>
                    <a onclick= "window.location.href='../create_account/register.html'">
                        <button class="hidden" id="register"> Criar conta</button>
                    </a>
                </div>
            </div>
        </div>
    </div>  
</body>
</html>
