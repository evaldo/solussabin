<?php
//visualizacao_cores_risco.php
if(isset($_POST["id_equipe_usua"]))
{
	session_start();
    
	$output = '';
    include '../database.php';
	
    $pdo = database::connect();
	
    $query = "select equipe.ds_equipe
					 , usua.nm_usua_acesso
					 , id_equipe_usua					 
				  from tratamento.tb_c_equipe_usua equipe_usua
					 , tratamento.tb_c_equipe equipe
					 , tratamento.tb_c_usua_acesso usua
				where equipe_usua.id_equipe = equipe.id_equipe
				  and equipe_usua.cd_usua_acesso = usua.cd_usua_acesso
				  and id_equipe_usua = '".$_POST["id_equipe_usua"]."'";
	
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
        <td width="30%"><label><b>Equipe:</b></label></td>  
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
