<?php
//visualizacao_cores_risco.php
if(isset($_POST["id_local_trtmto"]))
{
	session_start();
    
	$output = '';
    include '../database.php';
	
    $pdo = database::connect();
	
    $query = "SELECT id_local_trtmto, ds_local_trtmto, nu_seq_local_pnel from tratamento.tb_c_local_trtmto where id_local_trtmto = '".$_POST["id_local_trtmto"]."'";
	
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
        <td width="30%"><label><b>Id do Local de Tratamento:</b></label></td>  
        <td width="200%">'.$row[0].'</td>  
     </tr>
     <tr>  
        <td width="30%"><label><b>Descrição do Local de Tratamento:</b></label></td>  
        <td width="200%">'.$row[1].'</td>  
      </tr>
	 <tr>  
        <td width="30%"><label><b>No. da Seq. do Local de Tratamento no Painel:</b></label></td>  
        <td width="200%">'.$row[2].'</td>  
      </tr>';
    $output .= '</table></div>';
    echo $output;
}
?>
