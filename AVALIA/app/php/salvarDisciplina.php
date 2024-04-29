<?php
    session_start();
    include('funcoes.php');

    $descricao = $_POST["ndescricao"];
    $idCurso = isset($_GET["codigo"]) ? $_GET["codigo"] : null;
    $funcao = $_GET["funcao"];

    
    $ativo = isset($_POST["nAtivo"]) && $_POST["nAtivo"] == "on" ? "S" : "N";

    
    include("conexao.php");

    //Validar se é Inclusão ou Alteração
    if($funcao == "I"){

        //Busca o próximo ID na tabela
        $idCurso = proximoidCurso();

        //INSERT
        $sql = "INSERT INTO curso (idCurso, idEscola, descricao, FlgAtivo) "
        ."VALUES ($idCurso,".$_SESSION['idEscola'].",'$descricao', '$ativo');";
       


    }elseif($funcao == "A"){

        //UPDATE
        $sql = "UPDATE curso"
                ." SET descricao = '$descricao',"
                    ." FlgAtivo = '$ativo'"
                ." WHERE idCurso = '$idCurso';";
    }elseif($funcao == "D"){
   
        $sql = "UPDATE curso "
                ." SET FlgAtivo = 'N' "
                ." WHERE idCurso = '$idCurso';";

    }

    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    header("location: ../curso.php");

?>