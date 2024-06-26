<?php


function listaQuestao(){

    include("conexao.php");
    $filtro= filtrarQuest($_SESSION['idUsuario']); // valida as diciplinas do professor para que só seja apresentado as diciplinas do professor logado
    $sql = "SELECT * from questao  where idDisciplina in ($filtro) ;";

    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);
    $lista = '';

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
    
        $array = array();
        
    
        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array,$linha);
        }
        
        foreach ($array as $coluna) {
            if($coluna["FlgLiberada"] == 'S'){  
                $ativo = 'checked';
                $icone = '<h6><i class="fas fa-check-circle text-success"></i></h6>'; 
            }else if ($coluna["FlgLiberada"] == 'C'){
                $ativo = 'unchecked';
                $icone = '<h6><i class="fas fa-times-circle text-danger"></i></h6>';
            } 
        
            //***Verificar os dados da consulta SQL
        
            $lista .= 
            "<tr>"
            ."<td align='center'>".$coluna["idQuestao"]."</td>"
            ."<td align='center'>".descDisciplina($coluna["idDisciplina"])."</td>"                
            ."<td align='center'>".descProfessor($coluna["idProfessor"])."</td>"
            ."<td align='center'>".$coluna["Assunto"]."</td>"
            ."<td align='center'>".$icone."</td>"
            ."<td>"
            .'<div class="row" align="center">'
                .'<div class="col-4">'
                    .'<a href="#visualizarQuestoes'.$coluna["idQuestao"].'" data-toggle="modal" >'
                        .'<h6><i class="fas fa-eye text-yellow" data-toggle="tooltip" title="Visualizar questão"></i></h6>'
                    .'</a>'
                .'</div>';
                if($coluna['idProfessor'] == $_SESSION['idUsuario'] ){
                    $lista .='<div class="col-4">'
                        .'<a href="#modalAlterarQuestoes'.$coluna["idQuestao"].'" data-toggle="modal">'
                            .'<h6><i class="fas fa-edit text-info" data-toggle="tooltip" title="Editar questão"></i></h6>'
                        .'</a>'
                    .'</div>';
                }
                $lista.=
                '<div class="col-4">'
                    .'<a href="#liberarQuestao'.$coluna["idQuestao"].'" data-toggle="modal">';
                    if($ativo == 'checked' ){
                        $lista.= '<h6><i class="fas fas fa-thumbs-down text-danger" data-toggle="tooltip" title="Cancelar questão"></i></h6>';
                     } elseif ($ativo =='unchecked' ){
                        $lista.= '<h6><i class="fas fas fa-thumbs-up text-infoz " data-toggle="tooltip" title="Liberar questão"></i></h6>';
                     }
                $lista.='</a>'
                .'</div>'
                    
                    
            .'</div>'
            .'</div>'
            ."</td>"
            ."</tr>"
                    
            .'<div class="modal fade" id="visualizarQuestoes'.$coluna["idQuestao"].'">'
                .'<div class="modal-dialog modal-lg">'
                    .'<div class="modal-content">'
                        .'<div class="modal-header bg-yellow">'
                            .'<h4 class="modal-title">Questão '.$coluna["idQuestao"].':</h4>'
                            .'<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">'
                                .'<span aria-hidden="true">&times;</span>'
                            .'</button>'
                        .'</div>'
                        .'<div class="modal-body">'
                    
                            .'<form method="POST" enctype="multipart/form-data">'              
                    
                                .'<div class="row">'
                                    .'<div class="col-4">'
                                        .'<div class="form-group">'
                                            .'<label for=iAssunto>Assunto:</label>'
                                            .'<input type="text" value="'.$coluna["Assunto"].'" class="form-control" id="iAssunto" name="nAssunto" maxlength="50" readonly>'
                                        .'</div>'
                                    .'</div>'
                                    .'<div class="col-8">'
                                        .'<div class="form-group">'
                                            .'<label for=ipergunta>Pergunta:</label>'
                                            .'<input type="text" value="'.$coluna["Pergunta"].'" class="form-control" id="ipergunta" name="npergunta" maxlength="50" readonly>'
                                        .'</div>'
                                    .'</div>'
                                    .'<div class="image" style="text-align: center;" >'
                                        .'<img src="'.fotoQuestao($coluna["idQuestao"]).'" style="width: 300px;" style="width: 300px;"class="img-square elevation-1" alt="User Image">'
                                    .'</div>'
                                    .'<div class="col-12">'
                                        .'<div class="form-group">'
                                            .'<label for=iresp1> Primeira Alternativa:</label>'
                                            .'<input type="text" value="'.$coluna["Resp1"].'" class="form-control" id="iresp1" name="nresposta1" maxlength="50" readonly>'
                                        .'</div>'
                                    .'</div>'
                                    .'<div class="col-12">'
                                        .'<div class="form-group">'
                                            .'<label for=iresp1> Segunda Alternativa:</label>'
                                            .'<input type="text" value="'.$coluna["Resp2"].'" class="form-control" id="iresp2" name="nresposta2" maxlength="50" readonly>'
                                        .'</div>'
                                    .'</div>'
                                    .'<div class="col-12">'
                                        .'<div class="form-group">'
                                            .'<label for=iresp1> Terceira Alternativa:</label>'
                                            .'<input type="text" value="'.$coluna["Resp3"].'" class="form-control" id="iresp3" name="nresposta3" maxlength="50" readonly>'
                                        .'</div>'
                                    .'</div>'
                                    .'<div class="col-12">'
                                        .'<div class="form-group">'
                                            .'<label for=iresp1> Quarta Alternativa:</label>'
                                            .'<input type="text" value="'.$coluna["Resp4"].'" class="form-control" id="iresp4" name="nresposta4" maxlength="50" readonly>'
                                        .'</div>'
                                    .'</div>'
                                    
                                    .'<div class="col-12">'
                                        .'<div class="form-group">'
                                            .'<label for=iresp1> Resposta:</label>'
                                            .'<input type="text" value="'.respostaCorretaDescricao($coluna["idQuestao"]).'" class="form-control" id="iresp4" name="nrespostacorreta" maxlength="50" readonly>'
                                        .'</div>'
                                    .'</div>'
                    
                                   
                    
                    
                    
                                .'</div>'
                    
                                .'<div class="modal-footer">'
                                    .'<button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>'
                                .'</div>'
                                
                            .'</form>'
                            
                        .'</div>'
                    .'</div>'
                .'</div>'
            .'</div>'
                    
                    
        .'<div class="modal fade" id="liberarQuestao'.$coluna["idQuestao"].'">'
            .'<div class="modal-dialog modal-m">'
                .'<div class="modal-content">'
                    .'<div class="modal-header '.liberadoCanceladoIcone($coluna['idQuestao']).'">'
                        .'<h4 class="modal-title">Liberar/cancelar Questão</h4>'
                        .'<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">'
                            .'<span aria-hidden="true">&times;</span>'
                        .'</button>'
                    .'</div>'
                    .'<div class="modal-body">'
                    
                        .'<form method="POST" action="php/salvarQuestao.php?funcao=D&codigo='.$coluna["idQuestao"].'&teste='.verificaLiberacao($coluna["idQuestao"]).'" enctype="multipart/form-data">'              
                    
                            .'<div class="row">'
                                .'<div class="col-12">';
                                if($ativo == 'checked'){
                                    $lista.='<h4>Realmente deseja Cancelar Questão  '.$coluna["idQuestao"].' ?</h4>';
                                
                                }
                                elseif($ativo == 'unchecked'){
                                    $lista.='<h4>Realmente deseja Liberar Questão  '.$coluna["idQuestao"].' ?</h4>';
                                
                                
                                }
                                $lista.='</div>'
                            .'</div>'
                            .'<div class="modal-footer">'
                                .'<button type="button" class="btn btn-danger" data-dismiss="modal">Não</button>'
                                .'<button type="submit" class="btn btn-success">Sim</button>'
                            .'</div>'
                        .'</form>'
                    .'</div>'
                .'</div>'
            .'</div>'
        .'</div>'
                            
        .'<div class="modal fade" id="modalAlterarQuestoes'.$coluna["idQuestao"].'">'
        .'<div class="modal-dialog modal-lg">'
            .'<div class="modal-content">'
                .'<div class="modal-header bg-info ">'
                    .'<h4 class="modal-title">Editar Questão '.$coluna["idQuestao"].' </h4>'
                    .'<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">'
                        .'<span aria-hidden="true">&times;</span>'
                    .'</button>'
                .'</div>'
                .'<div class="modal-body">'
                            
                    .'<form method="POST" action="php/salvarQuestao.php?funcao=A&codigo='.$coluna["idQuestao"].'" enctype="multipart/form-data">'              
                            
                        .'<div class="row">'
                            .'<div class="col-4">'
                                .'<div class="form-group">'
                                    .'<label for=iAssunto>Assunto:</label>'
                                    .'<input type="text" value="'.$coluna["Assunto"].'" class="form-control" id="iAssunto" name="nAssunto" maxlength="50" >'
                                .'</div>'
                            .'</div>'
                            .'<div class="col-8">'
                                .'<div class="form-group">'
                                    .'<label for=ipergunta>Pergunta:</label>'
                                    .'<input type="text" value="'.$coluna["Pergunta"].'" class="form-control" id="ipergunta" name="npergunta" maxlength="50" >'
                                .'</div>'
                            .'</div>'
                            .'<div class="col-12">'
                                .'<label for="idFoto"> Imagem :'
                                .'<div class="image" style="text-align: center;" >'
                                    
                                    .'<input type="file" class="form-control" id="iFoto" name="Foto" accept="image/*">'
                                    .'</label>'
                                .'</div>'
                            .'</div>'
                            
                            .'<div class="col-12">'
                                .'<div class="form-group">'
                                    .'<label for=iresp1> Primeira Alternativa:</label>'
                                    .'<input type="text" value="'.$coluna["Resp1"].'" class="form-control" id="iresp1" name="nresposta1" maxlength="50" >'
                                .'</div>'
                            .'</div>'
                            .'<div class="col-12">'
                                .'<div class="form-group">'
                                    .'<label for=iresp1> Segunda Alternativa:</label>'
                                    .'<input type="text" value="'.$coluna["Resp2"].'" class="form-control" id="iresp2" name="nresposta2" maxlength="50" >'
                                .'</div>'
                            .'</div>'
                            .'<div class="col-12">'
                                .'<div class="form-group">'
                                    .'<label for=iresp1> Terceira Alternativa:</label>'
                                    .'<input type="text" value="'.$coluna["Resp3"].'" class="form-control" id="iresp3" name="nresposta3" maxlength="50" >'
                                .'</div>'
                            .'</div>'
                            .'<div class="col-12">'
                                .'<div class="form-group">'
                                    .'<label for=iresp1> Quarta Alternativa:</label>'
                                    .'<input type="text" value="'.$coluna["Resp4"].'" class="form-control" id="iresp4" name="nresposta4" maxlength="50" >'
                                .'</div>'
                            .'</div>'
                            
                            .'<div class="col-12">'
                                .'<div class="form-group">'
                                    .'<label for=irespo5> Resposta:'
                                    .'<select name="nrespostacorreta" class="form-control" id="iresp5" required>'
                                        .retornarResposta($coluna["idQuestao"])
                                        .mostrarOpcaoResposta($coluna["idQuestao"])
                                        .'</select>'
                                    .'</label>'
                                .'</div>'
                            .'</div>'
                            
                            
                            
                            .'<div class="modal-footer">'
                                .'<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>'
                                .'<button type="submit" class="btn btn-success">Alterar</button>'
                             .'</div>'
                            
                        .'</div>'
                            
                            
                            
                    .'</form>'
                .'</div>'
            .'</div>'
        .'</div>'
    .'</div>'
                            
                            
    ;


        }    
    }
    
    return $lista;
}

function retornarResposta($id){

    include("conexao.php");
    $sql = "SELECT RespCorreta,idQuestao FROM questao WHERE idQuestao = $id";        
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);
    $resp = "";

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
                
        $array = array();
        
        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array,$linha);
        }
        
        foreach ($array as $coluna) {            
            //***Verificar os dados da consulta SQL
            $resp .= '<option value="'.$coluna["RespCorreta"].'">'.respostaCorretaDescricao($coluna["idQuestao"]).'</option>';
            
        }        
    }


    return $resp;
}





function descDisciplina($id){
    include("conexao.php");
    $sql = "SELECT Descricao from disciplina where idDisciplina=$id ;";
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);
    if (mysqli_num_rows($result) > 0) {
        $descricao = '';
        $array = array();
        

        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array,$linha);
        }
        foreach ($array as $coluna) {
            $descricao = $coluna['Descricao'];
        }
    }
    return $descricao;

}


function descProfessor($id){
    include("conexao.php");
    $sql = "SELECT Nome from usuarios where idusuario =$id";
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);
    if (mysqli_num_rows($result) > 0) {
        $descricao = '';
        $array = array();
        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array,$linha);
        }
        foreach ($array as $coluna) {
            $descricao = $coluna['Nome'];
        }
    
    
    }
    return $descricao;
}
function fotoQuestao($id){

    $resp = "";

    include("conexao.php");
    $sql = "SELECT Imagem FROM questao WHERE idQuestao = $id;";        
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
                
        $array = array();
        
        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array,$linha);
        }
        
        foreach ($array as $coluna) {            
            //***Verificar os dados da consulta SQL
            $resp = $coluna["Imagem"];
        }        
    } 

    return $resp;
}


function respostaCorretaDescricao($id){
    include("conexao.php");
    $sql= "SELECT * FROM Questao where idQuestao =$id;";
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);
    if (mysqli_num_rows($result) > 0) {
        $descricao = '';
        $array = array();
        while($linha = mysqli_fetch_array($result, MYSQLI_ASSOC))
        {
            array_push($array,$linha);
        }
        $respostacerta="";
        foreach ($array as $coluna) {
            $descricao = $coluna['RespCorreta'];
            switch ($descricao) {
                case '1':
                    $respostacerta = $coluna['Resp1'];
                    break;
                 case '2':
                    $respostacerta = $coluna['Resp2'];
                    break;
                 case '3':
                    $respostacerta = $coluna['Resp3'];
                    break;
                 case '4':
                    $respostacerta = $coluna['Resp4'];
                    break;
                
                default:
                    # code...
                    break;
            }
        
        
        }
    }
    return $respostacerta;
}

function selectQuestao($id){
    include("conexao.php");
    $sql = "SELECT a.idDisciplina AS idid, a.Descricao as DESCS "
    ."FROM disciplina a "
    ."JOIN professor_has_disciplina b  on a.idDisciplina = b.idDisciplina "
    ."WHERE b.idProfessor = $id ; ";
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    $resp = "";
    if (mysqli_num_rows($result) > 0) {
        $array = array();
        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array,$linha);
        }
        foreach ($array as $coluna) {            
            //***Verificar os dados da consulta SQL
            $resp .= '<option value="'.$coluna["idid"].'">'.$coluna["DESCS"].'</option>';
        }        
    } 
    return $resp;
}
function mostrarOpcaoResposta($id){
    include("conexao.php");
    $sql = "SELECT * FROM questao where idQuestao = $id ;";        
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);
    $resp2="";
	if (mysqli_num_rows($result) >0){
        $array = array();
        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array,$linha);
        }
        foreach ($array as $coluna) {            
            //***Verificar os dados da consulta SQL
            $resp = $coluna["RespCorreta"];
            if($resp != 1){
                $respostacerta = $coluna['Resp1'];
                $valorresposta = '1';
                $resp2 .= '<option value="'.$valorresposta.'">'.$respostacerta.'</option>';
            }if ($resp !=2){
                $respostacerta = $coluna['Resp2'];
                $valorresposta = '2';
                $resp2 .= '<option value="'.$valorresposta.'">'.$respostacerta.'</option>';
            }if ($resp !=3){
                $respostacerta = $coluna['Resp3'];
                $valorresposta  = '3';
                $resp2 .= '<option value="'.$valorresposta.'">'.$respostacerta.'</option>';
            }if ($resp !=4){
                $respostacerta = $coluna['Resp4'];
                $valorresposta = '4';
                $resp2 .= '<option value="'.$valorresposta.'">'.$respostacerta.'</option>';
            }
               

        }
        
    }
    return $resp2;
}
function verificaLiberacao($id){

    include("conexao.php");
    $sql= "SELECT FlgLiberada from questao where idQuestao =$id;";
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    if (mysqli_num_rows($result) >0){
        $array = array();
        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array,$linha);
        }
        foreach ($array as $coluna) {            
            //***Verificar os dados da consulta SQL
            $resp = $coluna["FlgLiberada"];
        }   
    }
    return $resp;
}
function proxIdQeustao(){

    $id = "";

    include("conexao.php");
    $sql = "SELECT MAX(idQuestao) AS Maior FROM Questao;";        
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
                
        $array = array();
        
        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array,$linha);
        }
        
        foreach ($array as $coluna) {            
            //***Verificar os dados da consulta SQL
            $id = $coluna["Maior"] + 1;
        }        
    } 

    return $id;
}
function filtrarQuest($id){
    include("conexao.php");
    $sql = "SELECT idDisciplina FROM professor_has_disciplina where idProfessor = $id;";    
    $result = mysqli_query($conn,$sql);    
    mysqli_close($conn);

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
                
        $array = array();
        
        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array,$linha);
        }

        $idDisciplinas = array();
        
        foreach ($array as $coluna) {            
            //***Verificar os dados da consulta SQL
            $idDisciplinas[] = $coluna["idDisciplina"];
        }
    } 

    $id = implode(", ", $idDisciplinas);

    return $id;  
}
function liberadoCanceladoIcone($id){
    include("conexao.php");
    $sql = "SELECT FlgLiberada FROM questao where idQuestao = $id;";    
    $result = mysqli_query($conn,$sql);    
    mysqli_close($conn);
    if (mysqli_num_rows($result) > 0) {
                
        $array = array();
        
        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array,$linha);
        }
        
        foreach ($array as $coluna) {            
            //***Verificar os dados da consulta SQL
            if($coluna["FlgLiberada"] == "S"){
                $id="bg-danger";
            }else{
                $id="bg-blue";
            }

        }        
    } 

    return $id;
}
?>