<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function montaMenu(){
    
    $html = '<p>'
                .'<table border="1">'
                    .'<tr>'
                        .'<td> <a href="lista-usuario.php">USUÁRIOS</a></td>';

                        if($_SESSION['idTipoUsuario'] == 1){
                            $html .= '<td> <a href="salvarUsuario.php">CADASTRAR USUÁRIO</a></td>';
                        }
                        if($_SESSION['idTipoUsuario'] == 3){
                            $html .= '<td> <a href="questao.php">CADASTRAR QUESTÃO</a></td>';
                        }
                        
                        $html .=
                        '<td>PERFIL</td>'
                        .'<td>'
                            .'<a href="php/validaLogoff.php">SAIR</a>'
                        .'</td>'
                    .'</tr>'      
                .'</table>'
            .'</p>';

           
          
    return $html;
}


?>