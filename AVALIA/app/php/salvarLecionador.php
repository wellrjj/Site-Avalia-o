<?php
    
    //Arquivo criado para salvar cadastrar o lecionador;
    
    session_start();
    include('funcoes.php');

    $idProfessor = $_POST["nProfessor"];
    $idProfessorDisciplina = isset($_GET["codigo"]) ? $_GET["codigo"] : null;
    $idDisciplina = $_POST["nDisciplina"];
    $funcao = $_GET["funcao"];
    
    
    include("conexao.php");

    //Validar se é Inclusão ou Alteração
    if($funcao == "I"){

        //Busca o próximo ID na tabela
        $idProfessorDisciplina = proximoidProfessorDisciplina();

        //INSERT
        $sql = "INSERT INTO professor_has_disciplina (idProfessorDisciplina, idProfessor, idDisciplina) "
        ."VALUES ('$idProfessorDisciplina','$idProfessor','$idDisciplina');";
       


    }else{

        //UPDATE
        $sql = "DELETE FROM professor_has_disciplina WHERE idProfessorDisciplina = '$idProfessorDisciplina';";
                
    }

    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    header("location: ../lecionadores.php");

?>