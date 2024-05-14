<?php

//função para saber se tem atividade pra fazer
function temAtividade(){   
    
    include("conexao.php");
    
    $sql = "SELECT ati.idAtividade from atividade ati inner join disciplina dis on dis.idDisciplina = ati.idDisciplina inner join curso cur on cur.idCurso = dis.idCurso inner join turma tur on tur.idCurso = cur.idCurso inner join usuarios usu on usu.idTurma = tur.idTurma LEFT join atividade_has_aluno atilu on atilu.idAluno = usu.idUsuario where usu.idEscola = ".$_SESSION["idEscola"]." and ati.FlgLiberada = 'S' and atilu.Resposta = '';";
            
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
    
    $sql = "SELECT ati.idAtividade,ati.Titulo, ati.Descricao,cur.Descricao as 'descCur',tur.Descricao as 'descTur', usu.Nome as 'professor', ati.DataAplicacao from atividade ati inner join disciplina dis on dis.idDisciplina = ati.idDisciplina inner join curso cur on cur.idCurso = dis.idCurso inner join turma tur on tur.idCurso = cur.idCurso inner join usuarios usu on usu.idTurma = tur.idTurma LEFT join atividade_has_aluno atilu on atilu.idAluno = usu.idUsuario where usu.idEscola = ".$_SESSION["idEscola"]." and ati.FlgLiberada = 'S' and atilu.Resposta = '';";
            
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



?>