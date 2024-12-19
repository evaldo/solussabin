<?php
if(isset($_POST["cd_pcnt"]))
{
	session_start();

	$output = '';	
    include '../database.php';	
	
	$pdo = database::connect();

	$sql = "SELECT cd_pcnt, nm_pcnt, to_char(dt_nasc_pcnt, 'dd/mm/yyyy'), ds_mncp_pcnt, cd_cnvo from tratamento.tb_c_pcnt where cd_pcnt = '".$_POST['cd_pcnt']."'";

	if ($pdo==null){
			header(Config::$webLogin);
	}	
	$ret = pg_query($pdo, $sql);
	if(!$ret) {
		echo pg_last_error($pdo);
		exit;
	}
	
	$row = pg_fetch_row($ret);		
	
	$output .= '  
      <div class="table-responsive">  
           <table class="table table-bordered">';
		  
    $output .= '
     <tr>  
        <td width="30%"><label><b>Código do paciente no sistema de gestão:</b></label></td>  
        <td width="200%">'.$row[0].'</td>  
     </tr>
     <tr>  
        <td width="30%"><label><b>Nome do paciente:</b></label></td>  
        <td width="200%">'.$row[1].'</td>  
      </tr>
	 <tr>  
        <td width="30%"><label><b>Data de nascimento:</b></label></td>  
        <td width="200%">'.$row[2].'</td>  
      </tr>
	  <tr>  
        <td width="30%"><label><b>Município do paciente:</b></label></td>  
        <td width="200%">'.$row[3].'</td>  
      </tr>
	  <tr>  
        <td width="30%"><label><b>Convênio do paciente:</b></label></td>  
        <td width="200%">'.$row[4].'</td>  
      </tr>';
    $output .= '</table></div>';
    echo $output;
} 
	
?>
