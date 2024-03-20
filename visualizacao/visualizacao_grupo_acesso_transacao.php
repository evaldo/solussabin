<?php
//visualizacao_cores_risco.php
if(isset($_POST["id_grupo_usua_transac_acesso"]))
{
	session_start();
    
	$output = '';
    include '../database.php';
	
    $pdo = database::connect();
	
    $output .= '
     <tr>  
        <td width="30%"><label><b>Identificador:</b></label></td>  
        <td width="200%">'.$_POST["id_grupo_usua_transac_acesso"].'</td>  
     </tr>
     <tr>  
        <td width="30%"><label><b>Transação:</b></label></td>  
        <td width="200%">'.$_POST["nm_acesso_transac_tratamento"].'</td>  
      </tr> 
	  <tr>  
        <td width="30%"><label><b>Grupo de Acesso:</b></label></td>  
        <td width="200%">'.$_POST["nm_grupo_acesso"].'</td>  
      </tr>';
    $output .= '</table></div>';
    echo $output;
}
?>
