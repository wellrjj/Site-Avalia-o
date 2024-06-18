<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TecAvaliação - Login</title>
    <link rel="stylesheet" href="dist/css2/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
    <?php 
        session_start();
        include('php/funcoes.php');        
        
    ?>

</head>

<body id="tela-login">

    
    
    <div class="form-container">
        <div class="title-container">
            <h1 class="lobster"><u>TecAvaliação</u></h1>
        </div>

        <form method="POST" action="php/validaLogin.php">
            <fieldset id="iCampo">
                <table id="iTabela">
                    <tr>
                        <td><h2 id="iH101">Login</h2></td>
                    </tr>
                    <tr>
                        <td><input type="email" placeholder="Usuário" id="iNome" name="nEmail"></td>
                    </tr>
                    <tr>
                        <td><br><input type="password" placeholder="Senha" id="iSenha" name="nSenha"></td>
                    </tr>
                    <tr>
                        <td><br><input type="submit" value="Entrar" id="iBotao"></td>
                    </tr>
                </table>
                <br>
            </fieldset>
        </form>
    </div>

    <script>
        <?php echo $_SESSION['alerta']; ?>
    </script>
    
</body>
</html>