<?php
//visualizacao_grupo_acesso.php
if(isset($_POST["id_cnvo"]))
{
	session_start();
    
	$output = '';
    include '../database.php';
	
    $pdo = database::connect();
	
    $query = "SELECT id_cnvo, cd_cnvo
				from tratamento.tb_c_cnvo where id_cnvo = '".$_POST["id_cnvo"]."'";
	
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
        <td width="30%"><label><b>Id do convenio:</b></label></td>  
        <td width="200%">'.$row[0].'</td>  
     </tr>
     <tr>  
        <td width="30%"><label><b>Código/Descrição do Convenio:</b></label></td>  
        <td width="200%">'.$row[1].'</td>  
      </tr> 	  ';
    $output .= '</table></div>';
    echo $output;
}
?>
