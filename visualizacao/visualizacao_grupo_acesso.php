<?php
//visualizacao_grupo_acesso.php
if(isset($_POST["id_grupo_acesso"]))
{
	session_start();
    
	$output = '';
    include '../database.php';
	
    $pdo = database::connect();
	
    $query = "SELECT id_grupo_acesso, nm_grupo_acesso 
				from tratamento.tb_c_grupo_acesso where id_grupo_acesso = '".$_POST["id_grupo_acesso"]."'";
	
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
        <td width="30%"><label><b>Código Usuário:</b></label></td>  
        <td width="200%">'.$row[0].'</td>  
     </tr>
     <tr>  
        <td width="30%"><label><b>Nome do usuário:</b></label></td>  
        <td width="200%">'.$row[1].'</td>  
      </tr> ';
    $output .= '</table></div>';
    echo $output;
}
?>
