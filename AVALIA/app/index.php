<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TecAvaliação - Entrar</title>
    <link rel="stylesheet" href="dist/css2/login.css">
    <?php 
        session_start();
        include('php/funcoes.php');        
        
    ?>
  
   


</head>
<body style="background-image: url('../app/dist/img/high1.png');" class="tela-login">
    
    <div class="form-container">
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
                        <td><br><input type="submit" value="Logar" id="iBotao"></td>
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

