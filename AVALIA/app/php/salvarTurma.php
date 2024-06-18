<?php
    
    //Arquivo criado para cadastrar turmas em uma escola (É obrigatório associar um curso à turma).
    
    session_start();
    include('funcoes.php');

    //$idtipoUsuario = $_POST["nTipoUsuario"];
    $turma          = $_POST["nTurma"];
    $curso        = $_POST["nCurso"];
    $funcao        = $_GET["funcao"];

    $idTurma     = isset($_GET["codigo"]) ? $_GET["codigo"] : null;

    include("conexao.php");

    //Validar se é Inclusão ou Alteração
    if($funcao == "I"){

        //Busca o próximo ID na tabela (Turma)
        $idTurma = proxIdTurma();

        //INSERT
        $sql = "INSERT INTO turma (idTurma, idEscola, idCurso, Descricao) "
        ."VALUES ('$idTurma', '".$_SESSION['idEscola']."', '$curso','$turma');";

    }elseif($funcao == "A"){

        //UPDATE
        $sql = "UPDATE turma "
              ." SET Descricao = '$turma',"
              ."idCurso = '$curso'"
              ." WHERE idTurma = $idTurma;";

    }

    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    header("location: ../turmas.php");

?>