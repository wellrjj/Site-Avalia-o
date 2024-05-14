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
//função para pegar as atividades e a resposta
function Atividade($id){   
    
    include("conexao.php");
    
    $sql = "select atique.idAtividadeQuestao,que.idQuestao,que.Imagem, que.Pergunta, que.Resp1, que.Resp2, que.Resp3, que.Resp4, que.RespCorreta from questao que inner join atividade_has_questao atique on atique.idQuestao = que.idQuestao inner join atividade_has_aluno atilu on atilu.idAtividade = atique.idAtividade where atique.idAtividade = '$id';";
            
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

function acertou(){

    // Dados do banco de dados
    include("conexao.php");
    
    $sql = "select atilu.Acertou from atividade_has_questao atique inner join atividade_has_aluno atilu on atilu.idAtividadeQuestao = atique.idAtividadeQuestao inner join questao que on que.idQuestao = atique.idQuestao inner join atividade ati on ati.idAtividade = atilu.idAtividade where ati.flgMostraNota = 'S' and atilu.idAluno = '".$_SESSION["idUsuario"]."';";
        
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
           
           if($coluna["Acertou"] == 1){
             
              $acertos++;
                      
           }

        }
       
    }

    return $acertos;
}

function errou(){

    // Dados do banco de dados
    include("conexao.php");
    
    $sql = "select atilu.Acertou from atividade_has_questao atique inner join atividade_has_aluno atilu on atilu.idAtividadeQuestao = atique.idAtividadeQuestao inner join questao que on que.idQuestao = atique.idQuestao inner join atividade ati on ati.idAtividade = atilu.idAtividade where ati.flgMostraNota = 'S' and atilu.idAluno = '".$_SESSION["idUsuario"]."';";
        
    $result = mysqli_query($conn,$sql);      
    mysqli_close($conn);

    $erros = 0; // Número de respostas corretas     
   

    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
        

        $array = array();

        while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($array,$linha);
        }
        
        foreach ($array as $coluna) {
           
           if($coluna["Acertou"] == 0){
             
              $erros++;
                      
           }

        }
       
    }

    return $erros;
}

function montaDesempenho(){

      // Dados do banco de dados
      include("conexao.php");
    
      $sql = "select ati.Titulo from atividade_has_questao atique inner join atividade_has_aluno atilu on atilu.idAtividadeQuestao = atique.idAtividadeQuestao inner join questao que on que.idQuestao = atique.idQuestao inner join atividade ati on ati.idAtividade = atilu.idAtividade where ati.flgMostraNota = 'S' and atilu.idAluno = '".$_SESSION["idUsuario"]."' and atilu.idAtividadeAluno = 4;";
          
      $result = mysqli_query($conn,$sql);      
      mysqli_close($conn);
  
      $lista = ""; // Número de respostas corretas     
     
  
      //Validar se tem retorno do BD
      if (mysqli_num_rows($result) > 0) {
          
  
          $array = array();
  
          while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
              array_push($array,$linha);
          }
          
          foreach ($array as $coluna) {
             
             $lista .= '<!-- DONUT CHART -->
                        <div class="card card-danger">
                            <div class="card-header">
                                <h3 class="card-title">Avaliação de '.$coluna["Titulo"].' <?php ?></h3>
                                
                                <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                </div>
                            </div>
                            <div class="card-body">               
                                <canvas id="graficoPizza" width="400" height="400"></canvas>
                
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->';   
  
          }
         
      }
  
      return $lista;
  }

?>