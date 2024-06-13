<?php
    if(session_status() !== PHP_SESSION_ACTIVE){
        session_start();
    }

  
   $email = $_POST['nEmail'];
   $senha = $_POST['nSenha'];
    
   //o include chama a referência da outra página (na pagina de conexao.php)
   include('conexao.php');
   
   //comando sql para jogar lá no banco
   $sql = "SELECT * "
          ." FROM `usuarios` "
          ." WHERE Email = '".$email."' ";
     
    //EXECUTA O CÓDIGO NO BANCO DE DADOS      
    $result = mysqli_query($conn, $sql);
    //FECHA A CONEXÃO (IMPORTANTE)  
    
    //TROUXE RESULTADO? (RESULTADO DESSE TIPO RETORNA UM VALOR MAIOR QUE ZERO)
    if(mysqli_num_rows($result) > 0){
        
        //SE ENTROU É PQ TEM USUÁRIO, VERIFICA A SENHA
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
                        header('location: ../usuarios.php');
                        break;
                       
                    case 2:
                        header('location: ../usuarios.php');
                        break;
                    
                    case 3:
                        header('location: ../professor.php');
                        break;
                        
                    case 4:
                        header('location: ../aluno.php');
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