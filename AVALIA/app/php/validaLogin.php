<?php
    
    //Arquivo para validar o login do usuário.

    if(session_status() !== PHP_SESSION_ACTIVE){
        session_start();
    }

   $email = $_POST['nEmail'];
   $senha = $_POST['nSenha'];
    
   //O include chama a referência da outra página (na página de conexao.php)
   include('conexao.php');
   
   //Comando SQL para jogar no banco
   $sql = "SELECT * "
          ." FROM `usuarios` "
          ." WHERE Email = '".$email."' ";
     
    //EXECUTA O CÓDIGO NO BANCO DE DADOS      
    $result = mysqli_query($conn, $sql);
    //FECHA A CONEXÃO (IMPORTANTE)  
    
    //TROUXE RESULTADO? (RESULTADO DESSE TIPO RETORNA UM VALOR MAIOR QUE ZERO)
    if(mysqli_num_rows($result) > 0){
        
        //SE ENTROU É PORQUE TEM USUÁRIO, VERIFICA A SENHA
        $sql = "SELECT * "
        ." FROM `usuarios` "
        ." WHERE Email = '".$email."' "
        ." AND Senha = MD5('".$senha."')";

        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);
        
        //VERIFICA SE A SENHA ESTÁ CORRETA
        if(mysqli_num_rows($result) > 0){
             
            $arrayLogin = array();
        
            while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                array_push($arrayLogin,$linha);
            }
            
            foreach ($arrayLogin as $coluna) {
                
                //***Verificar os dados da consulta SQL
                $_SESSION['idTipoUsuario'] = $coluna['idTipoUsuario'];
                $_SESSION['idEscola'] = $coluna['idEscola'];
                $_SESSION['idUsuario'] = $coluna['idUsuario'];
                $_SESSION['idCurso'] = $coluna['idCurso'];
                $_SESSION['alerta'] = '';

                switch ($coluna['idTipoUsuario']) {
                    case 1:
                        header('location: ../painel.php');
                        break;
                       
                    case 2:
                        header('location: ../painel.php');
                        break;
                    
                    case 3:
                        header('location: ../painel.php');
                        break;
                        
                    case 4:
                        header('location: ../painel.php');
                        break; 
                                            
                    default:
                        # code...
                        break;
                }
            }    

        }else{
            
            $_SESSION['alerta'] = "alert('Senha incorreta, tente novamente')";  
            header('location: ../index.php');           
        }

    }else{
        
        $_SESSION['alerta'] = "alert('Usuário não encontrado ou não existe')";  
        header('location: ../index.php');   
    }

?>