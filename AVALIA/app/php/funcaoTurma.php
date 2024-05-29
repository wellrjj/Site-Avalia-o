
<?php

function listaAlunos($id){

    include("conexao.php");
   
   
    //SELECT para consultar uma tabela com os alunos da turma.
    $sql = "SELECT Nome, Email, FlgAtivo, idUsuario
            FROM usuarios 
            WHERE idTipoUsuario = '4'"
         ." AND idEscola = '".$_SESSION['idEscola']."'"
         ." AND idTurma = '$id';";
    
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);              
      
    $lista = '';
    $ativo = '';
    $icone = '';


    if (mysqli_num_rows($result) > 0) {
        
        $array = array();
    
        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array,$linha);
        }
        
        foreach ($array as $coluna) {


            if($coluna["FlgAtivo"] == 'S'){  
                $ativo = 'checked';
                $icone = '<h6><i class="fas fa-check-circle text-success"></i></h6>'; 
            }else{
                $ativo = '';
                $icone = '<h6><i class="fas fa-times-circle text-danger"></i></h6>';
            } 

            $lista .= 

            '<tr>'
                .'<td align="center">'.$coluna["Nome"].'</td>'
                .'<td align="center">'.$coluna["Email"].'</td>'
                .'<td align="center">'.$icone.'</td>'
                .'<td align="center">'.$coluna["idUsuario"].'</td>'
            .'</tr>';

        }
    }

    return $lista;
}

//Função criada para consultar turmas da escola. 
function listaTurmas(){

    include("conexao.php");

    //Criando um SELECT para consultar uma tabela com as informações da turma.
    $sql = "SELECT turma.Descricao AS turmaDescr, curso.Descricao AS cursoDescr, turma.idTurma
            FROM turma
            LEFT JOIN curso ON turma.idCurso = curso.idCurso
            WHERE turma.idEscola = '".$_SESSION["idEscola"]."';";

    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);              
      
    $lista = '';
    $ativo = '';
    $icone = '';


    if (mysqli_num_rows($result) > 0) {
        
        $array = array();
        
        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array,$linha);
        }
        
        foreach ($array as $coluna) {

            $_SESSION['nomeTurma'] = $coluna['turmaDescr'];
            $_SESSION['matriculaTurma'] = $coluna['idTurma'];


            $lista .= 

            '<tr>'
                .'<td align="center">'.$coluna["turmaDescr"].'</td>'
                .'<td align="center">'.$coluna["cursoDescr"].'</td>'
                .'<td align="center">'.$coluna["idTurma"].'</td>'

                .'<td>'
                    .'<div class="row" align="center">'

                        .'<div class="col-6">'
                            .'<a href="#modalEditTurma'.$coluna["idTurma"].'" data-toggle="modal">'
                                .'<h6><i class="fas fa-edit" data-toggle="tooltip" title="Editar Turma"></i></h6>'
                            .'</a>'
                        .'</div>'

                        .'<div class="col-6">'
                            .'<a href="turmaAlunos.php?codigo='.$coluna["idTurma"].'">'
                                .'<h6><i class="fas fa-eye" data-toggle="tooltip" title="Consultar Turma"></i></h6>'
                            .'</a>'
                        .'</div>'

                    .'</div>'
                .'</td>'
            ."</tr>"
            
            .'<div class="modal fade" id="modalEditTurma'.$coluna["idTurma"].'">'
                .'<div class="modal-dialog modal-lg">'
                    .'<div class="modal-content">'
                        .'<div class="modal-header bg-info">'
                            .'<h4 class="modal-title">Editar Turma</h4>'
                            .'<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">'
                                .'<span aria-hidden="true">&times;</span>'
                            .'</button>'
                        .'</div>'

                        .'<div class="modal-body">'

                            .'<form method="POST" action="php/salvarTurma.php?funcao=A&codigo='.$coluna["idTurma"].'" enctype="multipart/form-data">'              

                                .'<div class="row">'

                                    .'<div class="col-12">'
                                        .'<div class="form-group">'
                                            .'<label for="iNome">Nome da Turma:</label>'
                                            .'<input type="text" value="'.$coluna["turmaDescr"].'" class="form-control" id="iNome" name="nTurma" maxlength="50">'
                                        .'</div>'
                                    .'</div>'

                                    .'<div class="col-12">'
                                        .'<div class="form-group">'
                                            .'<label for="iNome">Curso:</label>'
                                            .'<select name="nCurso" class="form-control" required>'
                                            .optionCurso($coluna["idTurma"])
                                            .'</select>'
                                        .'</div>'
                                    .'</div>'

                                    .'<div class="modal-footer">'
                                        .'<button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>'
                                        .'<button type="submit" class="btn btn-success">Alterar</button>'
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

function optionTurmas(){

    include("conexao.php");
    $sql = "SELECT * FROM turma WHERE idEscola = '".$_SESSION['idEscola']. "';";
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
            $resp .= '<option value="'.$coluna["idTurma"].'">'.$coluna["Descricao"].'</option>';
        } 
    }

    return $resp;  
}

//Próximo ID da Turma
function proxIdTurma(){

    $id = "";

    include("conexao.php");
    $sql = "SELECT MAX(idTurma) AS Maior FROM turma;";        
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

?>