<?php

//função para saber titulo da atividade
function tituloAtividade($id){   
    
    include("conexao.php");
    
    $sql = "SELECT * FROM atividade WHERE idAtividade = '$id';";
            
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);
    $lista = "";

      

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
        
            $array = array();
            

        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array,$linha);
        }
        
        foreach ($array as $coluna) {
            $lista = "<h1 align='center'>".$coluna["Titulo"]."</h1><h5 align='center'>".$coluna["Descricao"]."</h5>";    
        } 
    }
    
    return $lista;
}
//função para pegar as atividades
function Atividade($id){   
    
    include("conexao.php");
    
    $sql = "select atique.idAtividadeQuestao,que.idQuestao,que.Imagem, que.Pergunta, que.Resp1, que.Resp2, que.Resp3, que.Resp4, que.RespCorreta from questao que inner join atividade_has_questao atique on atique.idQuestao = que.idQuestao where atique.idAtividade = '$id';";
            
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    $lista = "";
    $cont = 0; 
      

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
        $cont = 0;
        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $cont++;
            $lista .= '<input type="text" value="'.$linha["idAtividadeQuestao"].'" name="idAtividadeQuestao'.$cont.'" style="display: none;">
            
                        <div id="'.$linha["idQuestao"].'" class="col-8">                            
                                <h3>Pergunta '.$cont.': '.$linha['Pergunta'].'</h3>
                                <div class="form-group">
                                    <input type="radio" name="questao'.$cont.'" value="1" id="q'.$cont.'a">
                                    <label for="q'.$cont.'a">'.$linha['Resp1'].'</label>
                                </div>
                                <div class="form-group">
                                    <input type="radio" name="questao'.$cont.'" value="2" id="q'.$cont.'b">
                                    <label for="q'.$cont.'b">'.$linha['Resp2'].'</label>
                                </div>
                                <div class="form-group">
                                    <input type="radio" name="questao'.$cont.'" value="3" id="q'.$cont.'c">
                                    <label for="q'.$cont.'c">'.$linha['Resp3'].'</label>
                                </div>
                                <div class="form-group">
                                    <input type="radio" name="questao'.$cont.'" value="4" id="q'.$cont.'d">
                                    <label for="q'.$cont.'d">'.$linha['Resp4'].'</label>
                                </div>                            
                        </div>
                        <div class="col-4" align="right">';
                                if($linha["Imagem"] !== ""){
                                    $lista .='<img src="'.$linha["Imagem"].'" class="img" width="200px" alt="questão Imagem">';
                                }    
                                
                        $lista .='</div>';    
        } 
    }
    
    return $lista;
}

function correcao($id){

    include("conexao.php");
    
    $sql = "select que.RespCorreta,atilu.Resposta, atilu.idAtividadeAluno from atividade_has_questao atique inner join atividade_has_aluno atilu on atilu.idAtividadeQuestao = atique.idAtividadeQuestao inner join questao que on que.idQuestao = atique.idQuestao where atilu.idAtividade = '$id' and atilu.idAluno = '".$_SESSION["idUsuario"]."';";
            
    $result = mysqli_query($conn,$sql);      

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
        

        $array = array();

        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array,$linha);
        }
        
        foreach ($array as $coluna) {
           
           if($coluna["RespCorreta"] == $coluna["Resposta"]){
             
              $sql = "UPDATE atividade_has_aluno"
                     ." SET Acertou = '1'"
                     ." WHERE idAtividadeAluno = '".$coluna['idAtividadeAluno']."';";

              $result = mysqli_query($conn,$sql);   
                      
           }else{

              $sql = "UPDATE atividade_has_aluno"
              ." SET Acertou = '0'"
              ." WHERE idAtividadeAluno = '".$coluna['idAtividadeAluno']."';";

              $result = mysqli_query($conn,$sql);
                     
           }

        }
       
    }
    mysqli_close($conn);

}


function montaScriptDesempenho(){

    // Dados do banco de dados
    include("conexao.php");
  
    $sql = "SELECT atilu.Acertou, dis.idDisciplina from disciplina dis inner join curso cur on dis.idCurso = cur.idCurso inner join turma tur on tur.idCurso = cur.idCurso inner join usuarios usu on usu.idTurma = tur.idTurma inner join atividade ati on ati.idDisciplina = dis.idDisciplina inner join atividade_has_aluno atilu on atilu.idAtividade = ati.idAtividade  where usu.idUsuario = '".$_SESSION["idUsuario"]."' and usu.idEscola = '".$_SESSION["idEscola"]."' and ati.flgMostraNota = 'S';";
            
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
                    var ctx = document.getElementById('graficoPizza".$coluna["idDisciplina"]."').getContext('2d');

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

function notaAluno($id){

    // Dados do banco de dados
    include("conexao.php");
  
    $sql = "SELECT atilu.Acertou from disciplina dis inner join curso cur on dis.idCurso = cur.idCurso inner join turma tur on tur.idCurso = cur.idCurso inner join usuarios usu on usu.idTurma = tur.idTurma inner join atividade ati on ati.idDisciplina = dis.idDisciplina inner join atividade_has_aluno atilu on atilu.idAtividade = ati.idAtividade  where usu.idUsuario = '".$_SESSION["idUsuario"]."' and usu.idEscola = '".$_SESSION["idEscola"]."' and ati.flgRevisao = 'S' and ati.idAtividade = '$id';";
            
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);  
 
    $acertos = 0; // Número de respostas corretas
   
    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
        
        $array = array();

        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array,$linha);
        }
        foreach ($array as $coluna) {
            if ($coluna["Acertou"] == 1) {
                $acertos = $acertos + 1;  
            }
              
        }
    }
    return strval($acertos);;
}

function revisaoAluno(){

    include("conexao.php");
    
    $sql = "SELECT ati.idAtividade, dis.Descricao from disciplina dis inner join curso cur on dis.idCurso = cur.idCurso inner join turma tur on tur.idCurso = cur.idCurso inner join usuarios usu on usu.idTurma = tur.idTurma inner join atividade ati on ati.idDisciplina = dis.idDisciplina where usu.idUsuario = '".$_SESSION["idUsuario"]."' and usu.idEscola = '".$_SESSION["idEscola"]."' and ati.FlgRevisao = 'S';";
            
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
                            ."<td align='center'>".$coluna["idAtividade"]."</td>"
                            ."<td align='center'>".$coluna["Descricao"]."</td>"
                            ."<td align='center'>".notaAluno($coluna["idAtividade"])."</td>"
                                                                   
                            .'<td>'
                                .'<div class="row" align="center">'
                                    
                                    .'<div class="col-12">'
                                            
                                        .'<h6><a href="./provaRevisao.php?codigo='.$coluna["idAtividade"].'"><i class="fas fa-book-reader text-info" data-toggle="tooltip" title="Revisão da Atividade"></i></a></h6>'
                                            
                                    .'</div>'
                                .'</div>'
                            .'</td>'
                        .'</tr>';         

        }    
    }
    
    return $lista;

}

function provaRevisao($id){
   
    include("conexao.php");
    
    $sql = "select atique.idAtividadeQuestao,que.idQuestao,que.Imagem, que.Pergunta, que.Resp1, que.Resp2, que.Resp3, que.Resp4, que.RespCorreta, atilu.Resposta from questao que inner join atividade_has_questao atique on atique.idQuestao = que.idQuestao inner join atividade_has_aluno atilu on atilu.idAtividadeQuestao = atique.idAtividadeQuestao where atique.idAtividade = '$id';";
            
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);

    $lista = "";
    $cont = 0; 
    $icone = "";  
    $ativo = "";

    $resp1 = '';
    $resp2 = '';
    $resp3 = '';
    $resp4 = '';

    $respCorreta = '';


    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
        $cont = 0;
        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $resp1 = '';
            $resp2 = '';
            $resp3 = '';
            $resp4 = ''; 

            $icone1 = '';
            $icone2 = '';
            $icone3 = '';
            $icone4 = '';
            

             $cont++;
            
            if($linha["Resposta"] == 1){  
                $resp1 = 'checked';
                if($linha["RespCorreta"] == 1){
                    $icone1 = '<i class="fas fa-check-circle text-success"></i>';
                }else{
                    $icone1 = '<i class="fas fa-times-circle text-danger"></i>'; 
                }                
            }

            if($linha["Resposta"] == 2){  
                $resp2 = 'checked';
                if($linha["RespCorreta"] == 2){
                    $icone2 = '<i class="fas fa-check-circle text-success"></i>';
                }else{
                    $icone2 = '<i class="fas fa-times-circle text-danger"></i>'; 
                }                
            }

            if($linha["Resposta"] == 3){  
                $resp3 = 'checked';
                if($linha["RespCorreta"] == 3){
                    $icone3 = '<i class="fas fa-check-circle text-success"></i>';
                }else{
                    $icone3 = '<i class="fas fa-times-circle text-danger"></i>'; 
                }                
            }

            if($linha["Resposta"] == 4){  
                $resp4 = 'checked';
                if($linha["RespCorreta"] == 4){
                    $icone4 = '<i class="fas fa-check-circle text-success"></i>';
                }else{
                    $icone4 = '<i class="fas fa-times-circle text-danger"></i>'; 
                }                
            }

            switch ($linha["RespCorreta"]) {
                case 1:
                    $icone1 = '<i class="fas fa-check-circle text-success"></i>';
                break;
                case 2:
                    $icone2 = '<i class="fas fa-check-circle text-success"></i>';
                break;
                case 3:
                    $icone3 = '<i class="fas fa-check-circle text-success"></i>';
                break;
                case 4:
                    $icone4 = '<i class="fas fa-check-circle text-success"></i>';
                break;
                                        
            }

                       
            $lista .= '<input type="text" value="'.$linha["idAtividadeQuestao"].'" name="idAtividadeQuestao'.$cont.'" style="display: none;">
            
                        <div id="'.$linha["idQuestao"].'" class="col-8">                            
                                <h5>Pergunta '.$cont.': '.$linha['Pergunta'].'</h5>
                                <div class="form-group">
                                    <input type="radio" name="questao'.$cont.'" value="1" id="q'.$cont.'a" disabled '.$resp1.'>
                                    <label for="q'.$cont.'a">'.$linha['Resp1'].'</label>'.$icone1.'
                                </div>
                                <div class="form-group">
                                    <input type="radio" name="questao'.$cont.'" value="2" id="q'.$cont.'b" disabled '.$resp2.'>
                                    <label for="q'.$cont.'b">'.$linha['Resp2'].'</label>'.$icone2.'
                                </div>
                                <div class="form-group">
                                    <input type="radio" name="questao'.$cont.'" value="3" id="q'.$cont.'c" disabled '.$resp3.'>
                                    <label for="q'.$cont.'c">'.$linha['Resp3'].'</label>'.$icone3.'
                                </div>
                                <div class="form-group">
                                    <input type="radio" name="questao'.$cont.'" value="4" id="q'.$cont.'d" disabled '.$resp4.'>
                                    <label for="q'.$cont.'d">'.$linha['Resp4'].'</label>'.$icone4.'
                                </div>                            
                        </div>
                        <div class="col-4" align="right">';
                                if($linha["Imagem"] !== ""){
                                    $lista .='<img src="'.$linha["Imagem"].'" class="img" width="200px" alt="questão Imagem">';
                                }    
                                
                        $lista .='</div>';    
        } 
    }   
    return $lista;
}
?>