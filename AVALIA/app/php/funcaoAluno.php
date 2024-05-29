<?php

//função para saber se tem atividade pra fazer
function temAtividade(){   
    
    include("conexao.php");
    
    $sql = "SELECT * from atividade_has_aluno atilu inner join atividade ati on ati.idAtividade = atilu.idAtividade where ati.FlgLiberada = 'S' and  atilu.idAluno = ".$_SESSION["idUsuario"]." and atilu.Resposta = '';";
            
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);
    $lista = null;

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
        
        $array = array();
        

        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array,$linha);
        }
        
        foreach ($array as $coluna) {
          
            $lista = $lista + 1;  
        }
         
    }
    
    return $lista;
}


function lista_atividade(){

    include("conexao.php");
    
    $sql = "SELECT ati.idAtividade,ati.Titulo, ati.Descricao, cur.Descricao AS desCur, tur.Descricao AS desTur,ati.idProfessor, ati.DataAplicacao from atividade_has_aluno atilu inner join atividade ati on ati.idAtividade = atilu.idAtividade inner join professor_has_disciplina prodis on prodis.idDisciplina = ati.idDisciplina inner join usuarios usu on usu.idUsuario = prodis.idProfessor inner join disciplina dis on dis.idDisciplina = prodis.idDisciplina inner join curso cur on cur.idCurso = dis.idCurso inner join turma tur on tur.idCurso = cur.idCurso where atilu.idAluno = ".$_SESSION["idUsuario"]." and atilu.Resposta = '' and ati.FlgLiberada = 'S';";
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
            
            $lista .= "<tr>"
                            ."<td align='center'>".$coluna["Titulo"]."</td>"
                            ."<td align='center'>".$coluna["Descricao"]."</td>"                
                            ."<td>".$coluna["desCur"]."</td>"    
                            ."<td>".$coluna["desTur"]."</td>"  
                            ."<td>".nomeProfessor($coluna["idProfessor"])."</td>"  
                            ."<td>".$coluna["DataAplicacao"]."</td>"  
                                            
                            .'<td>'
                                .'<div class="row" align="center">'
                                    
                                    .'<div class="col-12">'
                                        .'<a href="#modalFazAtividade'.$coluna["idAtividade"].'" data-toggle="modal">'
                                            .'<h6><a href="./prova.php?codigo='.$coluna["idAtividade"].'"><i class="fas fa-book-reader text-info" data-toggle="tooltip" title="Realizar Atividade"></i></a></h6>'
                                        .'</a>'
                                    .'</div>'
                                .'</div>'
                            .'</td>'
                        .'</tr>';         

        }    
    }
    
    return $lista;

}

function disciplinasDoAluno(){

    include("conexao.php");
    
    $sql = "SELECT dis.idDisciplina, dis.Descricao from disciplina dis inner join curso cur on dis.idCurso = cur.idCurso inner join turma tur on tur.idCurso = cur.idCurso inner join usuarios usu on usu.idTurma = tur.idTurma inner join atividade ati on ati.idDisciplina = dis.idDisciplina where usu.idUsuario = '".$_SESSION["idUsuario"]."' and usu.idEscola = '".$_SESSION["idEscola"]."' and ati.flgMostraNota = 'S' and ati.FlgLiberada = 'S';";
            
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
            
            $lista .= "<tr>"
                            ."<td align='center'>".$coluna["idDisciplina"]."</td>"
                            ."<td align='center'>".$coluna["Descricao"]."</td>"                                            
                            .'<td>'
                                .'<div class="row" align="center">'
                                    
                                    .'<div class="col-12">'
                                        .'<a href="#modalDesempenho'.$coluna["idDisciplina"].'" data-toggle="modal">'
                                            .'<h6><i class="fas fa-chart-pie text-info" data-toggle="tooltip" title="Desempenho"></i></h6>'
                                        .'</a>'
                                    .'</div>'
                                .'</div>'
                            .'</td>'
                        .'</tr>'
                        
                        .'<div class="modal fade" id="modalDesempenho'.$coluna["idDisciplina"].'">'
                                .'<div class="modal-dialog modal-sm">'
                                    .'<div class="modal-content">'
                                        .'<div class="modal-header bg-info">'
                                            .'<h4 class="modal-title">Desempenho em '.$coluna['Descricao'].'</h4>'
                                            .'<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">'
                                                .'<span aria-hidden="true">&times;</span>'
                                            .'</button>'
                                        .'</div>'
                                        .'<div class="modal-body">'
                                            .'<div class="row">'
                                                .'<div class="col-12">'
                                                
                                                .'<canvas id="graficoPizza'.$coluna["idDisciplina"].'" width="400" height="400"></canvas>'
                                                                      
                                                .'</div>'                                                 
                                            .'</div>'
                                            
                                        .'</div>'
                                    .'</div>'
                                .'</div>'
                            .'</div>';         

        }    
    }
    
    return $lista;
}

?>