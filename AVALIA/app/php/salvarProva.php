<?php
    session_start();
    include('funcoes.php');
   
    $idAtividade = isset($_GET["codigo"]) ? $_GET["codigo"] : null;
    $idAtividadeQuestao1 = $_POST["idAtividadeQuestao1"];
    $idAtividadeQuestao2 = $_POST["idAtividadeQuestao2"];
    $idAtividadeQuestao3 = $_POST["idAtividadeQuestao3"];
    $idAtividadeQuestao4 = $_POST["idAtividadeQuestao4"];
    $idAtividadeQuestao5 = $_POST["idAtividadeQuestao5"];
    $idAtividadeQuestao6 = $_POST["idAtividadeQuestao6"];
    $idAtividadeQuestao7 = $_POST["idAtividadeQuestao7"];
    $idAtividadeQuestao8 = $_POST["idAtividadeQuestao8"];
    $idAtividadeQuestao9 = $_POST["idAtividadeQuestao9"];
    $idAtividadeQuestao10 = $_POST["idAtividadeQuestao10"];

    $Resposta1 =  $_POST["questao1"];
    $Resposta2 =  $_POST["questao2"];
    $Resposta3 =  $_POST["questao3"];
    $Resposta4 =  $_POST["questao4"];
    $Resposta5 =  $_POST["questao5"];
    $Resposta6 =  $_POST["questao6"];
    $Resposta7 =  $_POST["questao7"];
    $Resposta8 =  $_POST["questao8"];
    $Resposta9 =  $_POST["questao9"];
    $Resposta10 =  $_POST["questao10"];
    
    
    include("conexao.php");
    
    //UPDATE
    $sql = "UPDATE atividade_has_aluno"
    ." SET idAtividadeQuestao = '$idAtividadeQuestao1'"
    .", Resposta = '$Resposta1'"
    ." WHERE idAluno = '".$_SESSION['idUsuario']."' and idAtividade = '$idAtividade';";

    $result = mysqli_query($conn,$sql);
   
        //INSERT
    $sql = "INSERT INTO atividade_has_aluno (idAluno, idAtividade, idAtividadeQuestao, Resposta) "
            ."VALUES ('".$_SESSION['idUsuario']."','$idAtividade','$idAtividadeQuestao2', '$Resposta2'),
                        ('".$_SESSION['idUsuario']."','$idAtividade','$idAtividadeQuestao3', '$Resposta3'),
                        ('".$_SESSION['idUsuario']."','$idAtividade','$idAtividadeQuestao4', '$Resposta4'),
                        ('".$_SESSION['idUsuario']."','$idAtividade','$idAtividadeQuestao5', '$Resposta5'),
                        ('".$_SESSION['idUsuario']."','$idAtividade','$idAtividadeQuestao6', '$Resposta6'),
                        ('".$_SESSION['idUsuario']."','$idAtividade','$idAtividadeQuestao7', '$Resposta7'),
                        ('".$_SESSION['idUsuario']."','$idAtividade','$idAtividadeQuestao8', '$Resposta8'),
                        ('".$_SESSION['idUsuario']."','$idAtividade','$idAtividadeQuestao9', '$Resposta9'),
                        ('".$_SESSION['idUsuario']."','$idAtividade','$idAtividadeQuestao10', '$Resposta10');";
    
    //Função de correção de atividade                    
                       
    
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);
    correcao($idAtividade);     

    header("location: ../aluno.php");

?>