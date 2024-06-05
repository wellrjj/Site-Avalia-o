<?php


function listaAtividadeProfessor(){

    include("conexao.php");
    $sql = "SELECT * from atividade;";

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
            }else if ($coluna["FlgLiberada"] == 'N'){
                $ativo = 'unchecked';
                $icone = '<h6><i class="fas fa-times-circle text-danger"></i></h6>';
            } 
            if($coluna["FlgRevisao"] == 'S'){  
                $ativo2 = 'checked';
                $icone2 = '<h6><i class="fas fa-check-circle text-success"></i></h6>'; 
            }else if ($coluna["FlgRevisao"] == 'N'){
                $ativo2 = 'unchecked';
                $icone2 = '<h6><i class="fas fa-times-circle text-danger"></i></h6>';
            } 
            if($coluna["flgMostraNota"] == 'S'){  
                $ativo3 = 'checked';
                $icone3 = '<h6><i class="fas fa-check-circle text-success"></i></h6>'; 
            }else if ($coluna["flgMostraNota"] == 'N'){
                $ativo3 = 'unchecked';
                $icone3 = '<h6><i class="fas fa-times-circle text-danger"></i></h6>';
            } 
        
            //***Verificar os dados da consulta SQL
        
            $lista .= 
            "<tr>"
            ."<td align='center'>".$coluna["idAtividade"]."</td>"
            ."<td align='center'>".descProfessor2($coluna["idProfessor"])."</td>"
            ."<td align='center'>".descDisciplina2($coluna["idDisciplina"])."</td>"
            ."<td align='center'>".$coluna["Titulo"]."</td>"
            ."<td align='center'>".$coluna["Descricao"]."</td>"
            ."<td align='center'>".$coluna["DataAplicacao"]."</td>"
            ."<td align='center'>".$icone."</td>"
            ."<td align='center'>".$icone2."</td>"
            ."<td align='center'>".$icone3."</td>"
            ."<td>"
            .'<div class="row" align="center">'
                .'<div class="col-4">'
                    .'<a href="#EditarQuestao'.$coluna["idAtividade"].'" data-toggle="modal" >'
                        .'<h6><i class="fas fa-edit text-info" data-toggle="tooltip" title="Alterar Disciplina"></i></h6>'
                    .'</a>'
                .'</div>'
                      
            .'</div>'
            .'</div>'
            ."</td>"
            ."</tr>"
            
            
            
            .'<div class="modal fade" id="EditarQuestao'.$coluna["idAtividade"].'">'
            .'<div class="modal-dialog modal-lg">'
                .'<div class="modal-content">'
                    .'<div class="modal-header bg-info ">'
                        .'<h4 class="modal-title">Editar Questão '.$coluna["idAtividade"].' </h4>'
                        .'<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">'
                            .'<span aria-hidden="true">&times;</span>'
                        .'</button>'
                    .'</div>'
                    .'<div class="modal-body">'
                                
                        .'<form method="POST" action="php/salvarAtivProf.php?funcao=A&codigo='.$coluna["idAtividade"].'" enctype="multipart/form-data">'              
                                
                            .'<div class="row">'
                            
                                .'<div class="col-2">'
                                 .'<div class="form-group">'
                                     .'<label for=iTurma>Turma:</label>'
                                     .'<select name="nTurma" class="form-control">'
                                       .turmaSelect() 
                                     .'</select>'
                                 .'</div>'
                                .'</div>'

                                .'<div class="col-2">'
                                 .'<div class="form-group">'
                                     .'<label for=iDisciplina>Disciplina:</label>'
                                     .'<select name="nDisciplina" class="form-control">'
                                       .optiondaDisciplina()
                                     .'</select>'
                                 .'</div>'
                                .'</div>'

                                .'<div class="col-4">'
                                .'<div class="form-group">'
                                    .'<label for=iTitulo>Titulo:</label>'
                                    .'<input type="text" value="'.$coluna["Titulo"].'" class="form-control" id="ipergunta" name="nTitulo" maxlength="60" >'
                                .'</div>'
                                .'</div>'

                                
                                .'<div class="col-4">'
                                    .'<div class="form-group">'
                                        .'<label for=iDescricao> Descricao:</label>'
                                        .'<input type="text" value="'.$coluna["Descricao"].'" class="form-control" id="iresp1" name="nDescricao" maxlength="50" >'
                                    .'</div>'
                                .'</div>'

                                .mostarMestre($coluna['idAtividade'])
                                
                                .'<div class="col-12">'
                                .'<div class="form-group">'
                                  .'<label for=idata> Data DataAplicação:</label>'
                                  .'<input type="date"  value="'.$coluna["DataAplicacao"].'" class="form-control" id="idata" name="nDataAp">'
                                .'</div>'
                                .'</div>'      
                                


                                .'<div class="modal-footer">'
                                    .'<button type="button" class="btn btn-danger" data-dismiss="modal">Não</button>'
                                    .'<button type="submit" class="btn btn-success">Sim</button>'
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

function descProfessor2($id){
    include("conexao.php");
    $sql = "SELECT Nome from usuarios where idusuario =$id ;";
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
function descDisciplina2($id){ // adicionar a DESCRICAO PARA A DISICPLINA MEU XERO da prova realizada 
    include("conexao.php");
    $sql = "SELECT Descricao from disciplina where idDisciplina =$id ;";
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


function turmaSelect(){ // para o modal de nova atividade, essa função tem a finalidade de retornar uma lista da turma do professor logado 
    include("conexao.php");
    $sql = "SELECT DISTINCT tur.Descricao as TEST1, tur.idTurma as idTurma11
    FROM usuarios usu
    JOIN professor_has_disciplina prodis ON prodis.idProfessor = usu.idUsuario
    JOIN disciplina dis ON dis.idDisciplina = prodis.idDisciplina
    JOIN curso cur ON cur.idCurso = dis.idCurso
    JOIN turma tur ON tur.idCurso = cur.idCurso
    WHERE usu.idUsuario = ".$_SESSION['idUsuario']."
    AND EXISTS (
        SELECT 1
        FROM usuarios usa
        WHERE usa.idTurma = tur.idTurma
    )";
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);
    if (mysqli_num_rows($result) > 0) {
        $array = array();
        $resp='';
        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array,$linha);
        }
        foreach ($array as $coluna) {
            $resp .= '<option value="'.$coluna["idTurma11"].'">'.$coluna["TEST1"].'</option>';
        }
    }
    return $resp;
}




function optiondaDisciplina(){
    include("conexao.php");
    
    $sql = "SELECT disc.Descricao as DescricaoFin, disc.idDisciplina as IdDis
        FROM disciplina disc
        JOIN professor_has_disciplina discprof ON disc.idDisciplina = discprof.idDisciplina
        WHERE discprof.idProfessor = ".$_SESSION['idUsuario']." ;";

    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);
    if (mysqli_num_rows($result) > 0) {
        $array = array();
        $resp = '';
        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array,$linha);
        }
        foreach ($array as $coluna) {
            $resp .= '<option value="'.$coluna["IdDis"].'">'.$coluna["DescricaoFin"].'</option>';

        }
    }
    return $resp;
}
function MostrarQuestao($id){
    include("conexao.php");
    $filtroDisciplina= filtrarQuest2();
    $sql = "SELECT * FROM questao where FlgLiberada = 'S' and idDisciplina in ($filtroDisciplina) and idQuestao = $id ;";

    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);
    $resp = ''; // Inicialize a variável $resp

    if (mysqli_num_rows($result) > 0) {
        $array = array();
        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array,$linha);
        }
        foreach ($array as $coluna) {
            $resp .= '<option value="'.$coluna["idQuestao"].'">'.$coluna["Pergunta"].'</option>';

        }
    }
    return $resp;
}
function MostarAsDEMAISQuestoesEDITAR($id){
    include("conexao.php");
    $filtroDisciplina= filtrarQuest2();
    $sql = "SELECT * FROM questao where FlgLiberada = 'S' and idDisciplina in ($filtroDisciplina) and idQuestao != $id ;";

    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);
    $resp = ''; // Inicialize a variável $resp

    if (mysqli_num_rows($result) > 0) {
        $array = array();
        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array,$linha);
        }
        foreach ($array as $coluna) {
            $resp .= '<option value="'.$coluna["idQuestao"].'">'.$coluna["Pergunta"].'</option>';

        }
    }
    return $resp;
}

function MostrarQuestaoNOVO(){
    include("conexao.php");
    $filtroDisciplina= filtrarQuest2();
    $sql = "SELECT * FROM questao where FlgLiberada = 'S' and idDisciplina in ($filtroDisciplina);";

    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);
    $resp = ''; // Inicialize a variável $resp

    if (mysqli_num_rows($result) > 0) {
        $array = array();
        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array,$linha);
        }
        foreach ($array as $coluna) {
            $resp .= '<option value="'.$coluna["idQuestao"].'">'.$coluna["Pergunta"].'</option>';

        }
    }
    return $resp;
}





function mostarMestre($id){
    include("conexao.php");
    $sql = "SELECT * FROM atividade_has_questao where idAtividade = $id ;";
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);
    $resp = '';
    if (mysqli_num_rows($result) > 0) {
        $array = array();

        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array,$linha);
        }
        $i = 0;
        foreach ($array as $coluna) {
            $i= $i + 1; 
            $resp .= 
            '<div class="col-12">'
            .'<div class="form-group">'
            .'<label for=iQuest'.$i.'> Primeira Questao:</label>'
              .'<select name="nQuest'.$i.'" class="form-control" required> '
                .MostrarQuestao($coluna['idQuestao'])
                .MostarAsDEMAISQuestoesEDITAR($coluna['idQuestao'])
                .'</select>'
            .'</div>'
            .'</div>';
        }
    }
    return $resp;
}

function proxIDAtividade(){
    $id = "";
    include("conexao.php");
    $sql = "SELECT MAX(idAtividade) AS Maior FROM atividade;";        
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


function filtrarQuest2(){
    include("conexao.php");
    $sql = "SELECT idDisciplina FROM professor_has_disciplina where idProfessor = ".$_SESSION['idUsuario'].";";    
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






?>