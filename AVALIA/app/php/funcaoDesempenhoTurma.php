<?php 
  
  function listaTurmaProfessor(){

    include("conexao.php");
    
    $sql = "select tur.Descricao, tur.idTurma, ati.Titulo, ati.idAtividade from turma tur inner join curso cur on cur.idCurso = tur.idCurso inner join disciplina dis on dis.idCurso = cur.idCurso inner join professor_has_disciplina prodis on prodis.idDisciplina = dis.idDisciplina inner join atividade ati on ati.idDisciplina = dis.idDisciplina  where prodis.idProfessor = ".$_SESSION["idUsuario"].";";
            
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
                            ."<td align='center'>".$coluna["Descricao"]."</td>"
                            ."<td align='center'>".$coluna["Titulo"]."</td>"                            
                            ."<td align='center'>".notaTurma($coluna["idAtividade"])."%</td>"                                                                   
                            .'<td>'
                                .'<div class="row" align="center">'
                                    
                                    .'<div class="col-12">'
                                            
                                        .'<h6><a href="./desempenhoAlunoTurma.php?idturma='.$coluna["idTurma"].'&codigo='.$coluna["idAtividade"].'"><i class="fas fa-book-reader text-info" data-toggle="tooltip" title="Dessempenho Turma"></i></a></h6>'
                                            
                                    .'</div>'
                                .'</div>'
                            .'</td>'
                        .'</tr>';         

        }    
    }
    
    return $lista;

  }

  function notaTurma($id){

    // Dados do banco de dados
    include("conexao.php");
  
    $sql = "select * from atividade_has_aluno atilu where atilu.idAtividade = $id;";
            
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);  
 
    $acertos = 0; // Número de respostas corretas
    $erros = 0; // Número de respostas erradas
    $porcentagem = 0;
    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
        
        $array = array();

        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array,$linha);
        }
        foreach ($array as $coluna) {

            if ($coluna["Acertou"] == 1) {
                $acertos = $acertos + 1;  
            }elseif($coluna["Acertou"] == 0){
                $erros = $erros + 1;
            }
              
        }
        if (($acertos + $erros) > 0) {
            $porcentagem = ($acertos * 100) / ($acertos + $erros);
        }
    }

    // Formatar a porcentagem para 3 casas decimais
    $porcentagem_formatada = number_format($porcentagem, 1);
    
    return strval($porcentagem_formatada);
}

//desempenho do aluno da turma (quem visualiza é o professor) FALTA FAZER UM NEGOCIO (PRECISO DO IDTURMA)
function desempenhoDoAlunoTurma($idAti,$idTur){

    include("conexao.php");
    
    $sql = "SELECT usu.idUsuario,usu.Nome,ati.Titulo, dis.idDisciplina from usuarios usu inner join atividade ati on ati.idAtividade = $idAti inner join disciplina dis on dis.idDisciplina = ati.idDisciplina where usu.idTurma = $idTur;";
            
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
                            ."<td align='center'>".$coluna["Nome"]."</td>"
                            ."<td align='center'>".$coluna["Titulo"]."</td>"                                            
                            .'<td>'
                                .'<div class="row" align="center">'
                                    
                                    .'<div class="col-12">'
                                        .'<a href="#modalDesempenho'.$coluna["idUsuario"].'" data-toggle="modal">'
                                            .'<h6><i class="fas fa-chart-pie text-info" data-toggle="tooltip" title="Desempenho"></i></h6>'
                                        .'</a>'
                                    .'</div>'
                                .'</div>'
                            .'</td>'
                        .'</tr>'
                        
                        .'<div class="modal fade" id="modalDesempenho'.$coluna["idUsuario"].'">'
                                .'<div class="modal-dialog modal-sm">'
                                    .'<div class="modal-content">'
                                        .'<div class="modal-header bg-info">'
                                            .'<h4 class="modal-title">Desempenho em '.$coluna['Titulo'].'</h4>'
                                            .'<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">'
                                                .'<span aria-hidden="true">&times;</span>'
                                            .'</button>'
                                        .'</div>'
                                        .'<div class="modal-body">'
                                            .'<div class="row">'
                                                .'<div class="col-12">'
                                                
                                                .'<canvas id="graficoPizza'.$coluna["idUsuario"].'" width="400" height="400"></canvas>'
                                                                      
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

//monta Script em JS para monstrar um gráfico em formato de pizza
function montaScriptDesempenhoAlunoTurma($idTur,$idAti){

    // Dados do banco de dados
    include("conexao.php");
  
    $sql = "select usu.idUsuario,atilu.Acertou, atilu.idAtividade, ati.idDisciplina from atividade_has_aluno atilu inner join atividade ati on ati.idAtividade = atilu.idAtividade inner join usuarios usu on usu.idUsuario = atilu.idAluno where usu.idTurma = $idTur and ati.idAtividade = $idAti and atilu.Resposta != '' ORDER BY usu.idUsuario;";
            
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);


    $lista = ""; // Número de respostas corretas     
    $acertos = 0; // Número de respostas corretas
    $erros = 0;   // Número de respostas erradas
    $total = 10;
    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
        

        $array = array();

        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array,$linha);
        }
        
        foreach ($array as $coluna) {
          
           
          if($coluna["Acertou"] == 1){
              $acertos++;
          }else{
              $erros++;
          }

          if(($acertos + $erros) == 10){

            $lista .= "
                    var ctx = document.getElementById('graficoPizza".$coluna["idUsuario"]."').getContext('2d');

                    // Cria o gráfico de pizza
                    var graficoPizza = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: ['Acertos', 'Erros'],
                            datasets: [{
                                data: [".$acertos.", ".$erros."],
                                backgroundColor: [
                                    'green', // Cor para os acertos
                                    'red'    // Cor para os erros
                                ]
                            }]
                        }
                    });";  
            $acertos = 0; 
            $erros = 0; 
          }

        }
       
    }
   
    return $lista;
}

?>