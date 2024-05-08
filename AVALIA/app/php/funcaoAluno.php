<?php

//função para saber se tem atividade pra fazer
function temAtividade(){   
    
    include("conexao.php");
    
    $sql = "select * from atividade_has_aluno ati_alu left join atividade ati on ati_alu.idAtividade = ati.idAtividade inner join usuarios usu on ati.idProfessor = usu.idUsuario where usu.idEscola = 2 and ati_alu.Resposta = '' and ati.FlgLiberada = 'S';";
            
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);
    $lista = null;

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
        
       $lista .= 1;    
    }
    
    return $lista;
}

function atividadesPendentes(){

    include("conexao.php");
    
    $sql = "Select";
            
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);
    $lista = "";

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
        
       $lista .= 1;    
    }
    
    return $lista; 
}

function lista_atividade(){

    include("conexao.php");
    
    $sql = "select ati.idAtividade,ati.Titulo, ati.Descricao,cur.Descricao as 'descCur',tur.Descricao as 'descTur', usu.Nome as 'professor', ati.DataAplicacao from atividade ati inner join usuarios usu on ati.idProfessor = usu.idUsuario inner join turma tur inner join curso cur on tur.idCurso = cur.idCurso inner join atividade_has_aluno ati_alu on ati_alu.idAtividade = ati.idAtividade where usu.idEscola = 2 and ati_alu.Resposta = '' and ati.FlgLiberada = 'S';";
            
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
                ."<td align='center'>".$coluna["Titulo"]."</td>"
                ."<td align='center'>".$coluna["Descricao"]."</td>"                
                ."<td>".$coluna["descCur"]."</td>"    
                ."<td>".$coluna["descTur"]."</td>"  
                ."<td>".$coluna["professor"]."</td>"  
                ."<td>".$coluna["DataAplicacao"]."</td>"  
                                   
                .'<td>'
                    .'<div class="row" align="center">'
                        
                        .'<div class="col-12">'
                            .'<a href="#modalFazAtividade'.$coluna["idAtividade"].'" data-toggle="modal">'
                                .'<h6><i class="fas fa-book-reader text-info" data-toggle="tooltip" title="Realizar Atividade"></i></h6>'
                            .'</a>'
                        .'</div>'
                    .'</div>'
                .'</td>'
            .'</tr>'
            
            .'<div class="modal fade" id="modalFazAtividade'.$coluna["idAtividade"].'">'
                .'<div class="modal-dialog modal-xl">'
                    .'<div class="modal-content">'
                        .'<div class="modal-header bg-info">'
                            .'<h4 class="modal-title">'.$coluna["Titulo"].'</h4>'
                            .'<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">'
                                .'<span aria-hidden="true">&times;</span>'
                            .'</button>'
                        .'</div>'
                        .'<div class="modal-body">'
                            .'<label>'.$coluna["Descricao"].'</label>'

                            .'<form method="POST" action="php/salvarLecionador.php?funcao=D&codigo='.$coluna["idAtividade"].'" enctype="multipart/form-data">'              
                
                                .'<div class="row">'
                                    
                                   .'PAREI AQUIIIIIIIIIIIIIIIII'


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



?>