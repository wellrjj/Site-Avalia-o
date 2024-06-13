<?php
    session_start();
    include('funcoes.php');

    $idtipoUsuario = $_POST["nTipUsu"];
    $idTurma       = $_POST["nTurma"];
    $nome          = $_POST["nNome"];
    $Email         = $_POST["nEmail"];
    $senha         = $_POST["nSenha"];
    $funcao        = $_GET["funcao"];
    $idUsuario     = isset($_GET["codigo"]) ? $_GET["codigo"] : null;
    
    if($_POST["nAtivo"] == "on") $ativo = "S"; else $ativo = "N";
    
    include("conexao.php");

    //Validar se é Inclusão ou Alteração
    if($funcao == "I"){

        //Busca o próximo ID na tabela
        $idUsuario = proxIdUsuario();

        //INSERT
        $sql = "INSERT INTO usuarios (idUsuario, idTipoUsuario, idTurma, Nome, Email, Senha, FlgAtivo, idEscola) "
        ."VALUES ('$idUsuario', '$idtipoUsuario', '$idTurma', '$nome', '$Email', MD5('$senha'), '$ativo', ".$_SESSION['idEscola'].");";

        

    }elseif($funcao == "A"){

        if($senha != ""){
            $senha = ", Senha = MD5('$senha')";
        }

        //UPDATE
        $sql = "UPDATE usuarios "
                ." SET idTipoUsuario = '$idtipoUsuario', "
                    ." Nome = '$nome', "
                    ." Email = '$Email', "
                    ." FlgAtivo = '$ativo' "
                    ." $senha"
                    ." WHERE idUsuario = $idUsuario;";

    }elseif($funcao == "D"){
   
        $sql = "UPDATE usuarios "
                ." SET FlgAtivo = 'N' "
                ." WHERE idUsuario = $idUsuario;";

    }

    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    if($_FILES['Foto']['tmp_name'] != ""){

        //Usar o mesmo nome do arquivo original
        //$nomeArq = $_FILES['Foto']['name'];
        //...
        //OU
        //Pega a extensão do arquivo e cria um novo nome pra ele (MD5 do nome original)
        $extensao = pathinfo($_FILES['Foto']['name'], PATHINFO_EXTENSION);
        $novoNome = md5($_FILES['Foto']['name']).'.'.$extensao;        
        
        //Verificar se o diretório existe, ou criar a pasta
        if(is_dir('../dist/img/')){
            //Existe
            $diretorio = '../dist/img/';
        }else{
            //Criar pq não existe
            $diretorio = mkdir('../dist/img/');
        }

        //Cria uma cópia do arquivo local na pasta do projeto
        move_uploaded_file($_FILES['Foto']['tmp_name'], $diretorio.$novoNome);

        //Caminho que será salvo no banco de dados
        $dirImagem = 'dist/img/'.$novoNome;

        include("conexao.php");
        //UPDATE
        $sql = "UPDATE usuarios "
                ." SET Foto = '$dirImagem' "
                ." WHERE idUsuario = $idUsuario;";
        $result = mysqli_query($conn,$sql);
        mysqli_close($conn);
    }

    header("location: ../usuarios.php");

?>