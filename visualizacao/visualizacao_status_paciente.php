<?php
//visualizacao_cores_risco.php
if(isset($_POST["id_status_pcnt"]))
{
	session_start();
    
	$output = '';
    include '../database.php';
	
    $pdo = database::connect();
	
    $query = "SELECT id_status_pcnt, ds_status_pcnt , case when fl_ativo=1 then 'Sim' else 'Não' end fl_ativo, cd_cor_status_pcnt from tratamento.tb_c_status_pcnt where id_status_pcnt = '".$_POST["id_status_pcnt"]."'";
	
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
        <td width="30%"><label><b>Id do Status do Paciente:</b></label></td>  
        <td width="200%">'.$row[0].'</td>  
     </tr>
     <tr>  
        <td width="30%"><label><b>Descrição do Status do Paciente:</b></label></td>  
        <td width="200%">'.$row[1].'</td>  
      </tr>
	  <tr>  
        <td width="30%"><label><b>Flag Ativo?</b></label></td>  
        <td width="200%">'.$row[2].'</td>  
      </tr>
	 <tr>  
        <td width="30%"><label><b>Cor no Painel:</b></label></td>  
        <td width="200%">'.$row[3].'</td>  
      </tr>';
    $output .= '</table></div>';
    echo $output;
}
?>
