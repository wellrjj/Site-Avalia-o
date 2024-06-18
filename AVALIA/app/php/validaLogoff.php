<?php
    
    //Arquivo criado para o usuário efetuar o logoff
    
    $_SESSION['logado'] = 0;
    session_destroy();

    header('location: ../');
?>