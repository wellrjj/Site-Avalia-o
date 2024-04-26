<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TecAvaliação - Entrar</title>
    <?php include('partes/css.php'); ?>

    <style>
        body{
            background-color: rgb(234, 234, 234);
        }
        #iTabela{

            padding-left: 18%;   

        }
        #iH101{

            font-family: Arial, Helvetica, sans-serif;

        }
        #iNome{
            width: 100%;
            font-size: 97%;

            border-radius: 3px;

            padding-top: 3%;
            padding-bottom: 3%;
            padding-left: 3%;
            padding-right: 3%;
            border: 1px solid #ccc; 
            border-width: 1px; 
        }
        #iSenha{
            width: 100%;
            font-size: 97%;

            border-radius: 3px;

            padding-top: 3%;
            padding-bottom: 3%;
            padding-left: 3%;
            padding-right: 3%;
            border: 1px solid #ccc; 
            border-width: 1px; 
        }
        #iCampo{
            margin-top: 15%;
            margin-left: 36%;
            margin-right: 38%;

            border-radius: 10px;
            background-color: white;
            border-color: transparent;
            
            
        }
        #iBotao{
            background-color: blueviolet;
            color: aliceblue;
            border-radius: 3px;
            font-family: Arial, Helvetica, sans-serif;

            padding-top: 2%;
            padding-bottom: 2%;
            padding-left: 5%;
            padding-right: 5%;

            border: none;

        }
    </style>

</head>
<body class="tela-login">

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
    
</body>
</html>

