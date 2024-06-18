<?php
    
    //Arquivo criado para cadastrar as discplinas do curso.
    
    session_start();
    include('funcoes.php');

    $descricao = $_POST["nDescricao"];
    $idDisciplina = isset($_GET["codigo"]) ? $_GET["codigo"] : null;
    $idCurso = $_POST["nCurso"];
    $funcao = $_GET["funcao"];

    
    include("conexao.php");

    //Validar se é Inclusão ou Alteração
    if($funcao == "I"){

        //Busca o próximo ID na tabela
        $idDisciplina = proximoidDisciplina();

        //INSERT
        $sql = "INSERT INTO disciplina (idDisciplina, idCurso, Descricao) "
        ."VALUES ('$idDisciplina','$idCurso','$descricao');";
       


    }elseif($funcao == "A"){

        //UPDATE
        $sql = "UPDATE disciplina"
                ." SET Descricao = '$descricao'"
                ." WHERE idDisciplina = '$idDisciplina';";
                
    }elseif($funcao == "D"){

        //DELETE
        $sql = "DELETE FROM disciplina WHERE idDisciplina = '$idDisciplina';";

    }

    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    header("location: ../disciplinas.php");

?>