<?php
//select.php
if(isset($_POST["local"]))
{
	session_start();
    $output = '';
    include '../database.php';
    $pdo = database::connect();
	
    $query = "SELECT cd_pcnt, nm_pcnt, ds_status_pcnt, ds_local_trtmto, ds_utlma_obs_mapa_risco, cd_usua_incs, to_char(dt_incs, 'dd/mm/yyyy hh24:mi') as dt_incs FROM tratamento.tb_hstr_pnel_mapa_risco WHERE ds_local_trtmto = '". $_POST["local"] ."' and dt_final_mapa_risco is null ";
		
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
        <td width="30%"><label><b>Códido do Paciente:</b></label></td>  
        <td width="200%">'.$row[0].'</td>  
     </tr>
     <tr>  
        <td width="30%"><label><b>Nome do Paciente:</b></label></td>  
        <td width="200%">'.$row[1].'</td>  
      </tr>
      <tr>  
        <td width="30%"><label><b>Status:</b></label></td>  
        <td width="200%">'.$row[2].'</td>  
      </tr>
      <tr>  
        <td width="30%"><label><b>Local do Tratamento:</b></label></td>  
        <td width="200%">'.$row[3].'</td>  
      </tr>
      <tr>  
        <td width="30%"><label><b>Observação:</b></label></td>  
        <td width="200%">'.$row[4].'</td>  
      </tr>             
      <tr>  
        <td width="30%"><label><b>Usuário que incluiu o registro:</b></label></td>  
        <td width="200%">'.$row[5].'</td>  
      </tr>
      <tr>  
        <td width="30%"><label><b>Data/Hora de inclusão:</b></label></td>  
        <td width="200%">'.$row[6].'</td>  
      </tr>      
    ';
    $output .= '</table></div>';
    echo $output;
}
?>
