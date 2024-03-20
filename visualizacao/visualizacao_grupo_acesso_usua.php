<?php
//visualizacao_cores_risco.php
if(isset($_POST["id_grupo_usua_acesso"]))
{
	session_start();
    
	$output = '';
    include '../database.php';
	
    $pdo = database::connect();
	
    $query = "select grupo.nm_grupo_acesso
					 , usua.nm_usua_acesso
					 , id_grupo_usua_acesso
					 , grupo_usua_acesso.id_grupo_acesso
					 , grupo.id_grupo_acesso
				  from tratamento.tb_c_grupo_usua_acesso grupo_usua_acesso
					 , tratamento.tb_c_grupo_acesso grupo
					 , tratamento.tb_c_usua_acesso usua
				where grupo_usua_acesso.id_grupo_acesso = grupo.id_grupo_acesso
				  and grupo_usua_acesso.cd_usua_acesso = usua.cd_usua_acesso
				  and id_grupo_usua_acesso = '".$_POST["id_grupo_usua_acesso"]."'";
	
    $ret = pg_query($pdo, $query);
    if(!$ret) {
        echo pg_last_error($pdo);
        exit;
    }

    $output .= '  
      <div class="table-responsive">  
           <table class="table table-bordered">';
		   
    $row = pg_fetch_row($ret);
	
    $output .= '
     <tr>  
        <td width="30%"><label><b>Grupo de Acesso:</b></label></td>  
        <td width="200%">'.$row[0].'</td>  
     </tr>
     <tr>  
        <td width="30%"><label><b>Usuário:</b></label></td>  
        <td width="200%">'.$row[1].'</td>  
      </tr> ';
    $output .= '</table></div>';
    echo $output;
}
?>
