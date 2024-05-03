<?php

//função para saber se tem atividade pra fazer
function temAtividade(){   

    include("conexao.php");
    
    $sql = "SELECT * FROM atividade where FlgLiberada = 'S';";
            
    $result = mysqli_query($conn,$sql);
    mysqli_close($conn);
    $lista = null;
    //Validar se tem retorno do BD
    if (mysqli_num_rows($result) > 0) {
        
       $lista .= 1;    
    }
    
    return $lista;
}


?>