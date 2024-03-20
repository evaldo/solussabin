<?php
//visualizacao_cores_risco.php
if(isset($_POST["id_grupo_usua_menu_sist_tratamento"]))
{
	session_start();
    
	$output = '';
    include '../database.php';
	
    $pdo = database::connect();
	
    $query = "SELECT grupo_menu.id_grupo_usua_menu_sist_tratamento
					 , grupo.nm_grupo_acesso
					 , menu.nm_menu_sist_tratamento
				FROM tratamento.tb_c_grupo_usua_menu_sist_tratamento grupo_menu
				   , tratamento.tb_c_grupo_acesso grupo
				   , tratamento.tb_c_menu_sist_tratamento menu
				where grupo_menu.id_grupo_acesso = grupo.id_grupo_acesso
				  and grupo_menu.id_menu_sist_tratamento = menu.id_menu_sist_tratamento				 
				  and id_grupo_usua_menu_sist_tratamento = ".$_POST["id_grupo_usua_menu_sist_tratamento"]." 
				order by 2, 3 ";
	
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
        <td width="30%"><label><b>Identificador:</b></label></td>  
        <td width="200%">'.$row[0].'</td>  
     </tr>
     <tr>  
        <td width="30%"><label><b>Grupo de Acesso:</b></label></td>  
        <td width="200%">'.$row[1].'</td>  
      </tr> 
	  <tr>  
        <td width="30%"><label><b>Menu da Aplicação:</b></label></td>  
        <td width="200%">'.$row[2].'</td>  
      </tr>';
    $output .= '</table></div>';
    echo $output;
}
?>
