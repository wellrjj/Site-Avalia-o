<?php
session_start();
include('funcoes.php');

$Turma         = $_POST["nTurma"];
$Disciplina    = $_POST["nDisciplina"];
$Titulo         = $_POST["nTitulo"];
$Descricao      = $_POST["nDescricao"];
$DataAplicacao  = $_POST["nDataAp"];
$Professor     = $_SESSION["idUsuario"];
$Disciplina     = $_POST["nDisciplina"];


$quest1         = $_POST["nQuest1"];
$quest2         = $_POST["nQuest2"];
$quest3         = $_POST["nQuest3"];
$quest4         = $_POST["nQuest4"];
$quest5         = $_POST["nQuest5"];
$quest6         = $_POST["nQuest6"];
$quest7         = $_POST["nQuest7"];
$quest8         = $_POST["nQuest8"];
$quest9         = $_POST["nQuest9"];
$quest10        = $_POST["nQuest10"];
$funcao         = $_GET["funcao"];
$parte          = $_GET["parte"];
if($_POST["nAtivo1"] == "on") $ativo1 = "S"; else $ativo1 = "N";
if($_POST["nAtivo2"] == "on") $ativo2 = "S"; else $ativo2 = "N";
if($_POST["nAtivo3"] == "on") $ativo3 = "S"; else $ativo3 = "N";

include("conexao.php");

//Validar se é Inclusão ou Alteração
if($funcao == "I"){
    
//Busca o próximo ID na tabela
    if($parte==1){
    $idAtividade = proxIDAtividade();
    //INSERT
    $sql = "INSERT INTO atividade (idAtividade, idProfessor, idDisciplina, Titulo, Descricao, DataAplicacao,FlgLiberada,FlgRevisao,flgMostraNota) "
    ."VALUES ('$idAtividade','$Professor', '$Disciplina', '$Titulo','$Descricao','$DataAplicacao','N','N','N');";
    $result = mysqli_query($conn,$sql);
    salvarAtividadeAlunoAtividadeQuestao($Turma);
    }else if ($parte==2){
   
    $idAtividade = $_GET["codigo"];
    $del ="DELETE FROM atividade_has_questao where idAtividade = $idAtividade ;";
    $result = mysqli_query($conn,$del);
   
    $sql2 = "INSERT INTO atividade_has_questao (idAtividade, idQuestao) "
    ."VALUES ('$idAtividade','$quest1');";
    $sql3 = "INSERT INTO atividade_has_questao (idAtividade, idQuestao) "
    ."VALUES ('$idAtividade','$quest2');";
    
    $sql4 = "INSERT INTO atividade_has_questao (idAtividade, idQuestao) "
    ."VALUES ('$idAtividade','$quest3');";
    
    $sql5 = "INSERT INTO atividade_has_questao (idAtividade, idQuestao) "
    ."VALUES ('$idAtividade','$quest4');";
    
    $sql6 = "INSERT INTO atividade_has_questao (idAtividade, idQuestao) "
    ."VALUES ('$idAtividade','$quest5');";
    
    $sql7 = "INSERT INTO atividade_has_questao (idAtividade, idQuestao) "
    ."VALUES ('$idAtividade','$quest6');";
    
    $sql8 = "INSERT INTO atividade_has_questao (idAtividade, idQuestao) "
    ."VALUES ('$idAtividade','$quest7');";
    
    $sql9 = "INSERT INTO atividade_has_questao (idAtividade, idQuestao) "
    ."VALUES ('$idAtividade','$quest8');";
    
    $sql10 = "INSERT INTO atividade_has_questao (idAtividade, idQuestao) "
    ."VALUES ('$idAtividade','$quest9');";
    $sql11 = "INSERT INTO atividade_has_questao (idAtividade, idQuestao) "
    ."VALUES ('$idAtividade','$quest10');";

    $result = mysqli_query($conn,$sql2);
    $result = mysqli_query($conn,$sql3);
    $result = mysqli_query($conn,$sql4);
    $result = mysqli_query($conn,$sql5);
    $result = mysqli_query($conn,$sql6);
    $result = mysqli_query($conn,$sql7);
    $result = mysqli_query($conn,$sql8);
    $result = mysqli_query($conn,$sql9);
    $result = mysqli_query($conn,$sql10);
    $result = mysqli_query($conn,$sql11);
    }
   

}elseif($funcao == "A"){

   $idAtividade = $_GET["codigo"];
   $sql = "UPDATE atividade set idDisciplina = '$Disciplina' ,Titulo = '$Titulo' , Descricao= '$Descricao' , DataAplicacao= '$DataAplicacao', FlgLiberada='$ativo1' , FlgRevisao='$ativo2' , flgMostraNota='$ativo3'  where idAtividade = $idAtividade ;";
   $result = mysqli_query($conn,$sql);

}


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
    $sql = "UPDATE Questao "
            ." SET Imagem = '$dirImagem' "
            ." WHERE idQuestao = $idQuestao;";
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);
}

header("location: ../atividadeProfessor.php");

function salvarAtividadeAlunoAtividadeQuestao($idTurma) {
    include("conexao.php");

    // Encontrar a última atividade realizada
    $sql = "SELECT MAX(idAtividade) AS idAtividade FROM atividade;";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $coluna = mysqli_fetch_assoc($result);
        $idAtividade = $coluna["idAtividade"];
    } else {
        // Se não houver atividades realizadas, não podemos continuar
        die('Nenhuma atividade realizada.');
    }

    // Selecionar os alunos da turma
    $sql = "SELECT idUsuario FROM usuarios WHERE idTurma = $idTurma;";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($coluna = mysqli_fetch_assoc($result)) {
            $idAluno = $coluna["idUsuario"];

            // Inserir o aluno na última atividade realizada
            $sql = "INSERT INTO atividade_has_aluno (idAtividade, idAluno) VALUES ($idAtividade, $idAluno);";
            $insert_result = mysqli_query($conn, $sql);

            if (!$insert_result) {
                die('Erro na consulta: ' . mysqli_error($conn));
            }
        }
    } else {
        // Se não houver alunos na turma, não podemos continuar
        die('Nenhum aluno encontrado na turma.');
    }

    mysqli_close($conn);
}




?>