<?php
//Função para pesquisar atividades feitas pelo professor 
function listaAtividadeProfessor(){

    include("conexao.php");
    $sql = "SELECT * from atividade where idProfessor = ".$_SESSION["idUsuario"].";";

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
                                .'<h6><i class="fas fa-edit text-info" data-toggle="tooltip" title="Alterar atividade"></i></h6>'
                            .'</a>'
                        .'</div>'
                        .'<div class="col-4">'
                            .'<a href="#VisualizarAtividade'.$coluna["idAtividade"].'" data-toggle="modal" >'
                                .'<h6><i class="fas fa-eye text-warning" data-toggle="tooltip" title="Visualizar atividade"></i></h6>'
                            .'</a>'
                        .'</div>'
                        .'<div class="col-4">'
                            .'<a href="#VincularQuestao'.$coluna["idAtividade"].'" data-toggle="modal" >'
                                .'<h6><i class="fas fa-list text-success" data-toggle="tooltip" title="Vincular questão"></i></h6>'
                            .'</a>'
                        .'</div>'
                                
                        .'</div>'
                    .'</div>'
                ."</td>"
            ."</tr>"
                


                    
            .'<div class="modal fade" id="VincularQuestao'.$coluna["idAtividade"].'">'
            .'<div class="modal-dialog modal-lg">'
                .'<div class="modal-content">'
                    .'<div class="modal-header bg-success ">'
                        .'<h4 class="modal-title">Adicionar questões à atividade de número '.$coluna["idAtividade"].' </h4>'
                        .'<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">'
                            .'<span aria-hidden="true">&times;</span>'
                        .'</button>'
                    .'</div>'
                    .'<div class="modal-body">'
                                
                        .'<form method="POST" action="php/salvarAtivProf.php?funcao=I&codigo='.$coluna["idAtividade"].'&parte=2" enctype="multipart/form-data">'              
                            
                            .'<div class="row">'
                                .'<div class="col-12">'
                                    .'<div class="form-group">'
                                        .'<label for=iQuest1> Primeira Questão:</label>'
                                        .'<select name="nQuest1" class="form-control" required>'
                                            .'<option value="">Selecione...</option>'
                                                .MostrarQuestaoVincularQuestoes($coluna["idDisciplina"])
                                        .'</select>'
                                    .'</div>'
                                .'</div>'
                            .'<div class="col-12">'
                                .'<div class="form-group">'
                                    .'<label for=iQuest2> Segunda Questão:</label>'
                                    .'<select name="nQuest2" class="form-control" required>'
                                        .'<option value="">Selecione...</option>'
                                        .MostrarQuestaoVincularQuestoes($coluna["idDisciplina"])
                                    .'</select>'
                                .'</div>'
                            .'</div>'
                            .'<div class="col-12">'
                                .'<div class="form-group">'
                                    .'<label for=iQuest3> Terceira Questão:</label>'
                                    .'<select name="nQuest3" class="form-control" required>'
                                        .'<option value="">Selecione...</option>'
                                        .MostrarQuestaoVincularQuestoes($coluna["idDisciplina"])
                                    .'</select>'
                                .'</div>'
                            .'</div>'
                            .'<div class="col-12">'
                                .'<div class="form-group">'
                                    .'<label for=iQuest4> Quarta Questão:</label>'
                                    .'<select name="nQuest4" class="form-control" required>'
                                        .'<option value="">Selecione...</option>'
                                        .MostrarQuestaoVincularQuestoes($coluna["idDisciplina"])
                                    .'</select>'
                                .'</div>'
                            .'</div>'
                            .'<div class="col-12">'
                                .'<div class="form-group">'
                                    .'<label for=iQuest5> Quinta Questão:</label>'
                                    .'<select name="nQuest5" class="form-control" required>'
                                        .'<option value="">Selecione...</option>'
                                        .MostrarQuestaoVincularQuestoes($coluna["idDisciplina"])
                                    .'</select>'
                                .'</div>'
                            .'</div>'
                            .'<div class="col-12">'
                                .'<div class="form-group">'
                                    .'<label for=iQuest6> Sexta Questão:</label>'
                                    .'<select name="nQuest6" class="form-control" required>'
                                        .'<option value="">Selecione...</option>'
                                        .MostrarQuestaoVincularQuestoes($coluna["idDisciplina"])
                                    .'</select>'
                                .'</div>'
                            .'</div>'
                            .'<div class="col-12">'
                                .'<div class="form-group">'
                                    .'<label for=iQuest7> Sétima Questão:</label>'
                                    .'<select name="nQuest7" class="form-control" required>'
                                        .'<option value="">Selecione...</option>'
                                        .MostrarQuestaoVincularQuestoes($coluna["idDisciplina"])
                                    .'</select>'
                                .'</div>'
                            .'</div>'
                            .'<div class="col-12">'
                                .'<div class="form-group">'
                                    .'<label for=iQuest8> Oitava Questão:</label>'
                                    .'<select name="nQuest8" class="form-control" required>'
                                        .'<option value="">Selecione...</option>'
                                        .MostrarQuestaoVincularQuestoes($coluna["idDisciplina"])
                                    .'</select>'
                                .'</div>'
                            .'</div>'
                            .'<div class="col-12">'
                                .'<div class="form-group">'
                                    .'<label for=iQuest9> Nona Questão:</label>'
                                    .'<select name="nQuest9" class="form-control" required>'
                                        .'<option value="">Selecione...</option>'
                                        .MostrarQuestaoVincularQuestoes($coluna["idDisciplina"])

                                    .'</select>'
                                .'</div>'
                            .'</div>'

                            .'<div class="col-12">'
                                .'<div class="form-group">'
                                    .'<label for=iQuest10> Décima Questão:</label>'
                                    .'<select name="nQuest10" class="form-control" required>'
                                        .'<option value="">Selecione...</option>'
                                        .MostrarQuestaoVincularQuestoes($coluna["idDisciplina"])
                                    .'</select>'
                                .'</div>'
                            .'</div>'
                            .'<div class="modal-footer">'
                                .'<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>'
                                .'<button type="submit" class="btn btn-success">Inserir</button>'
                            .'</div>'
                        
                        .'</form>'
                    .'</div>'
                .'</div>'
            .'</div>'
           .'</div>'
        .'</div>'
        
        .'<div class="modal fade" id="EditarQuestao'.$coluna["idAtividade"].'">'
            .'<div class="modal-dialog modal-lg">'
                .'<div class="modal-content">'
                    .'<div class="modal-header bg-info ">'
                        .'<h4 class="modal-title">Editar atividade de número '.$coluna["idAtividade"].' </h4>'
                        .'<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">'
                            .'<span aria-hidden="true">&times;</span>'
                        .'</button>'
                    .'</div>'
                    .'<div class="modal-body">'
                                
                        .'<form method="POST" action="php/salvarAtivProf.php?funcao=A&codigo='.$coluna["idAtividade"].'" enctype="multipart/form-data">'              
                                
                            .'<div class="row">'
                                .'<div class="col-4">'
                                    .'<div class="form-group">'
                                        .'<label for=iDisciplina>Disciplina:</label>'
                                        .'<select name="nDisciplina" class="form-control">'
                                            .retornaSEtiverDisciplina($coluna['idAtividade'])
                                            .optiondaDisciplina()
                                        .'</select>'
                                    .'</div>'
                                .'</div>'

                                .'<div class="col-4">'
                                    .'<div class="form-group">'
                                        .'<label for=iTitulo>Título:</label>'
                                        .'<input type="text" value="'.$coluna["Titulo"].'" class="form-control" id="ipergunta" name="nTitulo" maxlength="60" >'
                                    .'</div>'
                                .'</div>'

                                
                                .'<div class="col-4">'
                                    .'<div class="form-group">'
                                        .'<label for=iDescricao> Descrição:</label>'
                                        .'<input type="text" value="'.$coluna["Descricao"].'" class="form-control" id="iresp1" name="nDescricao" maxlength="50" >'
                                    .'</div>'
                                .'</div>'
                                

                                .'<div class="col-4">'
                                    .'<div class="form-group">'
                                        .'<input type="checkbox" id="iAtivo" name="nAtivo1" '.$ativo.'>'
                                        .'<label for="iAtivo">Flag Liberada</label>'
                                    .'</div>'
                                .'</div>'
                                .'<div class="col-4">'
                                    .'<div class="form-group">'
                                        .'<input type="checkbox" id="iAtivo" name="nAtivo2" '.$ativo.'>'
                                        .'<label for="iAtivo">Flag Revisão</label>'
                                    .'</div>'
                                .'</div>'
                                .'<div class="col-4">'
                                    .'<div class="form-group">'
                                        .'<input type="checkbox" id="iAtivo" name="nAtivo3" '.$ativo.'>'
                                        .'<label for="iAtivo">Flag Mostrar Nota</label>'
                                    .'</div>'
                                .'</div>'
                                
                                .'<div class="col-12">'
                                    .'<div class="form-group">'
                                        .'<label for=idata>Data da Aplicação:</label>'
                                        .'<input type="date"  value="'.$coluna["DataAplicacao"].'" class="form-control" id="idata" name="nDataAp">'
                                    .'</div>'
                                .'</div>'      
                                
                                .'<div class="modal-footer">'
                                    .'<button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>'
                                    .'<button type="submit" class="btn btn-success">Alterar</button>'
                                .'</div>'
                                
                            .'</div>'
                                    
                                    
                                    
                        .'</form>'
                    .'</div>'
                .'</div>'
            .'</div>'
        .'</div>'
            

        .'<div class="modal fade" id="VisualizarAtividade'.$coluna["idAtividade"].'">'
            .'<div class="modal-dialog modal-lg">'
                .'<div class="modal-content">'
                    .'<div class="modal-header bg-warning ">'
                        .'<h4 class="modal-title">Visualizar atividade de número '.$coluna["idAtividade"].' </h4>'
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
                                     .'<select name="nTurma" class="form-control" readonly >'
                                       .turmaSelect() 
                                     .'</select>'
                                 .'</div>'
                                .'</div>'

                                .'<div class="col-2">'
                                .'<div class="form-group">'
                                    .'<label for=iDisciplina>Disciplina:</label>'
                                    .vizualizarDisciplina($coluna["idAtividade"])
                                .'</div>'
                               .'</div>'
   

                                .'<div class="col-4">'
                                .'<div class="form-group">'
                                    .'<label for=iTitulo>Titulo:</label>'
                                    .'<input type="text" value="'.$coluna["Titulo"].'" class="form-control" id="ipergunta" name="nTitulo" readonly maxlength="60" >'
                                .'</div>'
                                .'</div>'
    
                                
                                .'<div class="col-4">'
                                    .'<div class="form-group">'
                                        .'<label for=iDescricao> Descricao:</label>'
                                        .'<input type="text" value="'.$coluna["Descricao"].'" class="form-control" id="iresp1" name="nDescricao" readonly maxlength="50" >'
                                    .'</div>'
                                .'</div>'

                                  .mostarMestre2($coluna['idAtividade'])
                                

                                  .'<div class="col-4">'
                                  .'<div class="form-group">'
                                      .'<input type="checkbox" id="iAtivo" name="nAtivo1" disabled '.$ativo.'>'
                                      .'<label for="iAtivo">Usuário Ativo</label>'
                                  .'</div>'
                                  .'</div>'
                                  .'<div class="col-4">'
                                  .'<div class="form-group">'
                                      .'<input type="checkbox" id="iAtivo" name="nAtivo2" disabled '.$ativo.'>'
                                      .'<label for="iAtivo">Usuário Ativo</label>'
                                  .'</div>'
                                  .'</div>'
                                  .'<div class="col-4">'
                                  .'<div class="form-group">'
                                      .'<input type="checkbox" id="iAtivo" name="nAtivo3" disabled '.$ativo.'>'
                                      .'<label for="iAtivo">Usuário Ativo</label>'
                                  .'</div>'
                                  .'</div>'
                                  
                                  .'<div class="col-12">'
                                  .'<div class="form-group">'
                                    .'<label for=idata> Data DataAplicação:</label>'
                                    .'<input type="date"  value="'.$coluna["DataAplicacao"].'" class="form-control" id="idata"  disabled name="nDataAp">'
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
        .'</div>';


        }    
    }
    
    return $lista;
}

//Função para pegar o nome do professor no banco de dados
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

//Função para montar um formulário de atividade
function mostarMestre2($id){
    include("conexao.php");
    $sql = "SELECT quest.Pergunta as per FROM atividade_has_questao atvq JOIN questao quest on atvq.idQuestao = quest.idQuestao where atvq.idAtividade = $id ;";
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
            .'<div class="form-group">';
                if( $i == 1){
            $resp .= '<label for=iQuest'.$i.'> Primeira Questao:</label>';
                }else if($i == 2){
            $resp .= '<label for=iQuest'.$i.'> Segunda Questao:</label>';
                }else if($i == 3){
            $resp .= '<label for=iQuest'.$i.'> Terceira Questao:</label>';
                }else if($i == 4){
            $resp .= '<label for=iQuest'.$i.'> Quarta Questao:</label>';
                }else if($i == 5){
            $resp .= '<label for=iQuest'.$i.'> Quinta Questao:</label>';
                }else if($i == 6){
            $resp .= '<label for=iQuest'.$i.'> Sexta Questao:</label>';
                }else if($i == 7){
            $resp .= '<label for=iQuest'.$i.'> Sétima Questao:</label>';
                }else if($i == 8){
            $resp .= '<label for=iQuest'.$i.'> Oitava Questao:</label>';
                }else if($i == 9){
            $resp .= '<label for=iQuest'.$i.'> Nona Questao:</label>';
                }else if($i == 10){
            $resp .= '<label for=iQuest'.$i.'> Décima Questao:</label>';
                }
              $resp .= 
              '<input type="text" value="'.$coluna["per"].'" class="form-control" id="iresp1" name="nDescricao" readonly maxlength="50" >' 
              .'</div>'
              .'</div>'
              ;
        }
    }
    return $resp;
}

function vizualizarDisciplina($id){
    include("conexao.php");
    $sql = "SELECT atv.idDisciplina as IdDis, disc.Descricao as DescricaoFin FROM atividade atv 
    JOIN disciplina disc ON disc.idDisciplina = atv.idDisciplina
    WHERE atv.idAtividade = $id ;";
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);
    if (mysqli_num_rows($result) > 0) {
        $array = array();
        $resp = '';
        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array,$linha);
        }
        foreach ($array as $coluna) {
            $resp .= '<input type="text"  value="'.$coluna["DescricaoFin"].'"  readonly class="form-control" >';

        }
    }return $resp;
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

//Para o modal de nova atividade, essa função tem a finalidade de retornar uma lista da turma do professor logado 
function turmaSelect(){ 

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
//Para o modal de nova atividade, essa função tem a finalidade de retornar uma lista da turma do professor logado 
function turmaSelectVisualizar(){ 

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
            $resp .= '<input type="date"  value="'.$coluna["TEST1"].'" class="form-control" id="idata" name="nDataAp">';

        }
    }
    return $resp;
}

//Monta um option da disciplina que o professor está inserido
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

//Função para retornar a disciplina que está em alguma atividade
function retornaSEtiverDisciplina($id){

    include("conexao.php");

    $sql = "SELECT atv.idDisciplina as IdDis, disc.Descricao as DescricaoFin FROM atividade atv 
    JOIN disciplina disc ON disc.idDisciplina = atv.idDisciplina
    WHERE atv.idAtividade = $id ;";

    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    if (mysqli_num_rows($result) > 0) {
        $array = array();
        $resp = '';
        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array,$linha);
        }
        foreach ($array as $coluna) {
            $resp .= '<option value="'.$coluna["IdDis"].'">Disciplina Selecionada: '.$coluna["DescricaoFin"].'</option>';
        }
    }return $resp;
}


//Função para mostrar outras questões que ainda não foram utilizadas nas atividades
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

//Função para montar um option que é selecionado para a atividade
function MostrarQuestaoVincularQuestoes($id){
    include("conexao.php");
    $sql = "SELECT * FROM questao where FlgLiberada = 'S' and idDisciplina =$id;";

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



//Função para buscar no banco de dados o próximo id da atividade
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

//Função para filtrar quais disciplinas o professor está inserido
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