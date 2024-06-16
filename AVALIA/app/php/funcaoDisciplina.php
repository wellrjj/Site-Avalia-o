<?php

//função para listar todas as disciplinas
function lista_disciplinas(){   

    include("conexao.php");
    
    $sql = "SELECT 
    dis.idDisciplina as idDisciplina, 
    dis.Descricao as DescDIS, 
    cur.Descricao as DescCUR,
    dis.idCurso as idCurso
    from disciplina dis inner join curso cur on dis.idCurso = cur.idCurso where cur.idEscola = ".$_SESSION["idEscola"].";";
            
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
            

            //***Verificar os dados da consulta SQL
            
            $lista .= 

            "<tr>"
                ."<td align='center'>".$coluna["idDisciplina"]."</td>"
                ."<td align='center'>".$coluna["DescDIS"]."</td>"                
                ."<td>".$coluna["DescCUR"]."</td>"         
                .'<td>'
                    .'<div class="row" align="center">'
                        .'<div class="col-6">'
                            .'<a href="#modalEditDisciplina'.$coluna["idDisciplina"].'" data-toggle="modal">'
                                .'<h6><i class="fas fa-edit text-info" data-toggle="tooltip" title="Alterar Disciplina"></i></h6>'
                            .'</a>'
                        .'</div>'
                        
                        .'<div class="col-6">'
                            .'<a href="#modalDeleteDisciplina'.$coluna["idDisciplina"].'" data-toggle="modal">'
                                .'<h6><i class="fas fa-trash text-danger" data-toggle="tooltip" title="Excluir Disciplina"></i></h6>'
                            .'</a>'
                        .'</div>'
                    .'</div>'
                .'</td>'
            .'</tr>'
            
            .'<div class="modal fade" id="modalEditDisciplina'.$coluna["idDisciplina"].'">'
                    .'<div class="modal-dialog modal-lg">'
                        .'<div class="modal-content">'
                            .'<div class="modal-header bg-info">'
                                .'<h4 class="modal-title">Alterar Disciplina</h4>'
                                .'<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">'
                                    .'<span aria-hidden="true">&times;</span>'
                                .'</button>'
                            .'</div>'
                            .'<div class="modal-body">'

                                .'<form method="POST" action="php/salvarDisciplina.php?funcao=A&codigo='.$coluna["idDisciplina"].'" enctype="multipart/form-data">'              
                    
                                    .'<div class="row">'
                                        .'<div class="col-8">'
                                        .'<div class="form-group">'
                                            .'<label for="iNome">Descrição:</label>'
                                            .'<input type="text" value="'.$coluna["DescDIS"].'" class="form-control" id="iNome" name="nDescricao" maxlength="50">'
                                        .'</div>'
                                    .'</div>'

                                    .'<div class="col-4">'
                                        .'<div class="form-group">'
                                            .'<label for="iNome">Curso:</label>'
                                            .'<select name="nCurso" class="form-control" required>'
                                            .optionCursoDisciplina($coluna["idCurso"])
                                            .'</select>'
                                        .'</div>'
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
                .'</div>'
                

                .'<div class="modal fade" id="modalDeleteDisciplina'.$coluna["idDisciplina"].'">'
                    .'<div class="modal-dialog modal-lg">'
                        .'<div class="modal-content">'
                            .'<div class="modal-header bg-danger">'
                                .'<h4 class="modal-title">Cancelar Curso</h4>'
                                .'<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">'
                                    .'<span aria-hidden="true">&times;</span>'
                                .'</button>'
                            .'</div>'
                            .'<div class="modal-body">'

                                .'<form method="POST" action="php/salvarDisciplina.php?funcao=D&codigo='.$coluna["idDisciplina"].'" enctype="multipart/form-data">'              
                    
                                    .'<div class="row">'
                                        .'<div class="col-12">'
                                            .'<h4>Deseja EXCLUIR a Disciplina '.$coluna["DescDIS"].'?</h4>'
                                        .'</div>'
                                    .'</div>'

                                    .'<div class="modal-footer">'
                                        .'<button type="button" class="btn btn-danger" data-dismiss="modal">Não</button>'
                                        .'<button type="submit" class="btn btn-success">Sim</button>'
                                    .'</div>'
                                    
                                .'</form>'
                                
                            .'</div>'
                        .'</div>'
                    .'</div>'
                .'</div>';

            
           

        }    
    }else{

        $lista = "<tr><td>NULL</td><td>NULL</td><td>NULL</td><td>NULL</td><td>NULL</td></tr>";
    }
    
    return $lista;
}

//Função que retorna o próximo id da tabela de disciplina 
function proximoidDisciplina(){

    $id = "";

    include("conexao.php");
    $sql = "SELECT MAX(idDisciplina) AS Maior FROM disciplina;";        
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

//Função que retorna as disciplinas que estão inseridas num curso
function optionDisciplinas(){

    include("conexao.php");
    $sql = "SELECT  DISTINCT idDisciplina, dis.Descricao AS Descricao FROM disciplina dis inner join curso cur on cur.idCurso = dis.idCurso where cur.idEscola = ".$_SESSION["idEscola"].";";
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
            $resp .= '<option value="'.$coluna["idDisciplina"].'">'.$coluna["Descricao"].'</option>';
        } 
    }
    return $resp;  
}

?>