<?php
session_start();
include('funcoes.php');

$Disciplina    = $_POST["nDisciplina"];
$Pergunta      = $_POST["npergunta"];
$resp1         = $_POST["nresposta1"];
$resp2         = $_POST["nresposta2"];
$resp3         = $_POST["nresposta3"];
$resp4         = $_POST["nresposta4"];
$certo         = $_POST["nrespostacorreta"];
$Professor     = $_SESSION["idUsuario"];
$funcao        = $_GET["funcao"];
$Assunto       = $_POST["nAssunto"];

if($_POST["nAtivo"] == "on") $ativo = "S"; else $ativo = "N";

include("conexao.php");

//Validar se é Inclusão ou Alteração
if($funcao == "I"){

    //Busca o próximo ID na tabela
    $idQuestao = proxIdQeustao();

    //INSERT
    $sql = "INSERT INTO questao (idQuestao, idDisciplina, idProfessor, Pergunta, Resp1, Resp2,Resp3,Resp4,RespCorreta,FlgLiberada,Assunto) "
    ."VALUES ('$idQuestao', '$Disciplina', '$Professor', '$Pergunta', '$resp1','$resp2','$resp3','$resp4','$certo','$ativo','$Assunto');";

}elseif($funcao == "A"){
    $idQuestao     = $_GET["codigo"];
    $sql = "UPDATE questao SET Pergunta ='$Pergunta', Resp1 = '$resp1', Resp2 = '$resp2', Resp3 = '$resp3', Resp4 = '$resp4', RespCorreta = '$certo' WHERE idQuestao = $idQuestao;";
}elseif($funcao == "D"){
    include("conexao.php");
    $idQuestao  = $_GET["codigo"];
    $TESTE = $_GET['teste'];
    if($TESTE =="S"){
    $sql=" UPDATE questao set FlgLiberada = 'C' WHERE idQuestao= $idQuestao ;";
    } elseif($TESTE =="C") {
    $sql=" UPDATE questao set FlgLiberada = 'S' WHERE idQuestao=$idQuestao ;";
    }
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
    $sql = "UPDATE Questao "
            ." SET Imagem = '$dirImagem' "
            ." WHERE idQuestao = $idQuestao;";
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);
}

header("location: ../questoes.php");





?>




















?>