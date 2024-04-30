<?php

//função para listar todos os lecionadores
function lista_lecionadores(){   

    include("conexao.php");
    
    $sql = "SELECT * FROM disciplina dis inner join professor_has_disciplina pro_dis on dis.idDisciplina = pro_dis.idDisciplina inner join usuarios usu on usu.idUsuario = pro_dis.idProfessor;";
            
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
        $lista = '';
        $array = array();
        

        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array,$linha);
        }
        
        foreach ($array as $coluna) {
            

            //***Verificar os dados da consulta SQL
            
            $lista .= 

            "<tr>"
                ."<td align='center'>".$coluna["idDisciplina"]."</td>"
                ."<td align='center'>".$coluna["Descricao"]."</td>"                
                ."<td>".$coluna["idUsuario"]."</td>"    
                ."<td>".$coluna["Nome"]."</td>"                     
                .'<td>'
                    .'<div class="row" align="center">'
                        
                        .'<div class="col-12">'
                            .'<a href="#modalDeleteLecionadores'.$coluna["idDisciplina"].'" data-toggle="modal">'
                                .'<h6><i class="fas fa-trash text-danger" data-toggle="tooltip" title="Excluir Lecionador"></i></h6>'
                            .'</a>'
                        .'</div>'
                    .'</div>'
                .'</td>'
            .'</tr>'
                

                .'<div class="modal fade" id="modalDeleteLecionadores'.$coluna["idProfessorDisciplina"].'">'
                    .'<div class="modal-dialog modal-lg">'
                        .'<div class="modal-content">'
                            .'<div class="modal-header bg-danger">'
                                .'<h4 class="modal-title">Excluir Lecionador</h4>'
                                .'<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">'
                                    .'<span aria-hidden="true">&times;</span>'
                                .'</button>'
                            .'</div>'
                            .'<div class="modal-body">'

                                .'<form method="POST" action="php/salvarLecionador.php?funcao=D&codigo='.$coluna["idProfessorDisciplina"].'" enctype="multipart/form-data">'              
                    
                                    .'<div class="row">'
                                        .'<div class="col-12">'
                                            .'<h4>Deseja EXCLUIR lecionador?</h4>'
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
    }
    
    return $lista;
}

function proximoidProfessorDisciplina(){
    
    $id = "";
    include("conexao.php");

    $sql = "SELECT MAX(idProfessorDisciplina) AS Maior FROM professor_has_disciplina;";        
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