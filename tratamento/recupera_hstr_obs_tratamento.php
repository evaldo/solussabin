<?php
//select.php
session_start();
$output = '';
	
include '../database.php';
$pdo = database::connect();

$equipe = "";

if(isset($_GET['equipe'])){
	
    $equipe = $_GET['equipe'];
	$pac = $_GET['pac'];
	
	$outputonco = '';
	$outputauto = '';
	
	if ($equipe == "13") {			
		
		$outputonco .= ' 
	    <div class="table-responsive">  
           <table class="table table-bordered" >
		   <tr style="font-size: 12px;">
			<th>Status</th>
			<th>Início</th>
			<th>Fim</th>
			<th>Observação</th>
			<th>Quem Incluiu?</th>
			<th>Incs</th>
			<th>Quem Alterou?</th>
			<th>Alteração</th>
		   </tr>';
		
		$queryonco = "SELECT ds_status_trtmto status
					 , to_char(dt_inic_status_equipe_trtmto, 'dd/mm/yyyy hh24:mi') dt_inicio_status
					 , to_char(dt_final_status_equipe_trtmto, 'dd/mm/yyyy hh24:mi') dt_final_status
					 , ds_obs_pcnt observacao
					 , cd_usua_incs as usuario_que_incluiu
					 , to_char(dt_incs, 'dd/mm/yyyy hh24:mi') data_inclusao
					 , cd_usua_altr as usuario_que_alterou
					 , to_char(dt_altr, 'dd/mm/yyyy hh24:mi') data_que_alterou
				FROM tratamento.tb_hstr_obs_pnel_solic_trtmto 
				WHERE cd_pcnt = '".$pac."'
				  and id_status_equipe = 13
				  and id_hstr_pnel_solic_trtmto = (
														select max(id_hstr_pnel_solic_trtmto)
														 from tratamento.tb_hstr_obs_pnel_solic_trtmto
														where cd_pcnt = '".$pac."'
														  and id_status_equipe = 13
														)
				ORDER BY id_hstr_obs_pnel_solic_trtmto ASC  ";
		
		$ret = pg_query($pdo, $queryonco);
		if(!$ret) {
			echo pg_last_error($pdo);
			exit;
		}   
		   
		//$row = pg_fetch_row($ret);
		while($row = pg_fetch_row($ret)) {
			$outputonco .= '		
						 <tr style="font-size: 12px;">  							
							<td width="30%">'.$row[0].'</td>  							
							<td width="25%">'.$row[1].'</td>  
							<td width="25%">'.$row[2].'</td> ';	
						if (strlen($row[3])<=50) {
							$outputonco .= '<td width="500%" data-toggle="tooltip" data-placement="top" title= "'. $row[3].'">'.$row[3].'</td> ';
						} else {
							$outputonco .= '<td width="500%" data-toggle="tooltip" data-placement="top" title= "'. $row[3].'">'.substr($row[3], 0, 50).'<b>...</b></td> ';
						}							
			$outputonco .= '	<td width="30%">'.$row[4].'</td>  							
							<td width="25%">'.$row[5].'</td>  
							<td width="30%">'.$row[6].'</td>  							
							<td width="25%">'.$row[7].'</td>  
						 </tr>';
		}
		$outputonco .= '</table></div>';
		
		echo $outputonco;
			
			
	}
	
	if ($equipe == "7") {		
	
		$query = "SELECT ds_status_trtmto status
					 , to_char(dt_inic_status_equipe_trtmto, 'dd/mm/yyyy hh24:mi') dt_inicio_status
					 , to_char(dt_final_status_equipe_trtmto, 'dd/mm/yyyy hh24:mi') dt_final_status
					 , ds_obs_pcnt observacao
					 , cd_usua_incs as usuario_que_incluiu
					 , to_char(dt_incs, 'dd/mm/yyyy hh24:mi') data_inclusao
					 , cd_usua_altr as usuario_que_alterou
					 , to_char(dt_altr, 'dd/mm/yyyy hh24:mi') data_que_alterou
				FROM tratamento.tb_hstr_obs_pnel_solic_trtmto 
				WHERE cd_pcnt = '".$pac."'
				  and id_status_equipe = 7
				  and id_hstr_pnel_solic_trtmto = (
														select max(id_hstr_pnel_solic_trtmto)
														 from tratamento.tb_hstr_obs_pnel_solic_trtmto
														where cd_pcnt = '".$pac."'
														  and id_status_equipe = 7
														)
				ORDER BY id_hstr_obs_pnel_solic_trtmto ASC  ";
			
		$outputauto .= '  
		<div class="table-responsive">  
           <table class="table table-bordered">
		   <tr style="font-size: 12px;">
			<th>Status</th>
			<th>Início</th>
			<th>Fim</th>
			<th>Observação</th>
			<th>Quem Incluiu?</th>
			<th>Incs</th>
			<th>Quem Alterou?</th>
			<th>Alteração</th>
		   </tr>';
		$ret = pg_query($pdo, $query);
		if(!$ret) {
			echo pg_last_error($pdo);
			exit;
		}   
		   
		//$row = pg_fetch_row($ret);
		while($row = pg_fetch_row($ret)) {
				$outputauto .= '		
						 <tr style="font-size: 12px;">  							
							<td width="30%">'.$row[0].'</td>  							
							<td width="25%">'.$row[1].'</td>  
							<td width="25%">'.$row[2].'</td> ';	
						if (strlen($row[3])<=50) {
							$outputauto .= '<td width="500%" data-toggle="tooltip" data-placement="top" title= "'. $row[3].'">'.$row[3].'</td> ';
						} else {
							$outputauto .= '<td width="500%" data-toggle="tooltip" data-placement="top" title= "'. $row[3].'">'.substr($row[3], 0, 50).'<b>...</b></td> ';
						}						
			$outputauto .= '<td width="30%">'.$row[4].'</td>  							
							<td width="25%">'.$row[5].'</td>  
							<td width="30%">'.$row[6].'</td>  							
							<td width="25%">'.$row[7].'</td>  
						 </tr>';
		}
		$outputauto .= '</table></div>';
		
		echo $outputauto;
			
	}
	
	if ($equipe == "8") {		
	
		$query = "SELECT ds_status_trtmto status
					 , to_char(dt_inic_status_equipe_trtmto, 'dd/mm/yyyy hh24:mi') dt_inicio_status
					 , to_char(dt_final_status_equipe_trtmto, 'dd/mm/yyyy hh24:mi') dt_final_status
					 , ds_obs_pcnt observacao
					 , cd_usua_incs as usuario_que_incluiu
					 , to_char(dt_incs, 'dd/mm/yyyy hh24:mi') data_inclusao
					 , cd_usua_altr as usuario_que_alterou
					 , to_char(dt_altr, 'dd/mm/yyyy hh24:mi') data_que_alterou
				FROM tratamento.tb_hstr_obs_pnel_solic_trtmto 
				WHERE cd_pcnt = '".$pac."'
				  and id_status_equipe = 8
				  and id_hstr_pnel_solic_trtmto = (
														select max(id_hstr_pnel_solic_trtmto)
														 from tratamento.tb_hstr_obs_pnel_solic_trtmto
														where cd_pcnt = '".$pac."'
														  and id_status_equipe = 8
														)
				ORDER BY id_hstr_obs_pnel_solic_trtmto ASC  ";
			
		$outputauto .= '  
		<div class="table-responsive">  
           <table class="table table-bordered">
		   <tr style="font-size: 12px;">
			<th>Status</th>
			<th>Início</th>
			<th>Fim</th>
			<th>Observação</th>
			<th>Quem Incluiu?</th>
			<th>Incs</th>
			<th>Quem Alterou?</th>
			<th>Alteração</th>
		   </tr>';
		$ret = pg_query($pdo, $query);
		if(!$ret) {
			echo pg_last_error($pdo);
			exit;
		}   
		   
		//$row = pg_fetch_row($ret);
		while($row = pg_fetch_row($ret)) {
				$outputauto .= '		
						 <tr style="font-size: 12px;">  							
							<td width="30%">'.$row[0].'</td>  							
							<td width="25%">'.$row[1].'</td>  
							<td width="25%">'.$row[2].'</td> ';	
						if (strlen($row[3])<=50) {
							$outputauto .= '<td width="500%" data-toggle="tooltip" data-placement="top" title= "'. $row[3].'">'.$row[3].'</td> ';
						} else {
							$outputauto .= '<td width="500%" data-toggle="tooltip" data-placement="top" title= "'. $row[3].'">'.substr($row[3], 0, 50).'<b>...</b></td> ';
						}						
			$outputauto .= '<td width="30%">'.$row[4].'</td>  							
							<td width="25%">'.$row[5].'</td>  
							<td width="30%">'.$row[6].'</td>  							
							<td width="25%">'.$row[7].'</td>  
						 </tr>';
		}
		$outputauto .= '</table></div>';
		
		echo $outputauto;
			
	}
	
	if ($equipe == "9") {		
	
		$query = "SELECT ds_status_trtmto status
					 , to_char(dt_inic_status_equipe_trtmto, 'dd/mm/yyyy hh24:mi') dt_inicio_status
					 , to_char(dt_final_status_equipe_trtmto, 'dd/mm/yyyy hh24:mi') dt_final_status
					 , ds_obs_pcnt observacao
					 , cd_usua_incs as usuario_que_incluiu
					 , to_char(dt_incs, 'dd/mm/yyyy hh24:mi') data_inclusao
					 , cd_usua_altr as usuario_que_alterou
					 , to_char(dt_altr, 'dd/mm/yyyy hh24:mi') data_que_alterou
				FROM tratamento.tb_hstr_obs_pnel_solic_trtmto 
				WHERE cd_pcnt = '".$pac."'
				  and id_status_equipe = 9
				  and id_hstr_pnel_solic_trtmto = (
														select max(id_hstr_pnel_solic_trtmto)
														 from tratamento.tb_hstr_obs_pnel_solic_trtmto
														where cd_pcnt = '".$pac."'
														  and id_status_equipe = 9
														)
				ORDER BY id_hstr_obs_pnel_solic_trtmto ASC  ";
			
		$outputauto .= '  
		<div class="table-responsive">  
           <table class="table table-bordered">
		   <tr style="font-size: 12px;">
			<th>Status</th>
			<th>Início</th>
			<th>Fim</th>
			<th>Observação</th>
			<th>Quem Incluiu?</th>
			<th>Incs</th>
			<th>Quem Alterou?</th>
			<th>Alteração</th>
		   </tr>';
		$ret = pg_query($pdo, $query);
		if(!$ret) {
			echo pg_last_error($pdo);
			exit;
		}   
		   
		//$row = pg_fetch_row($ret);
		while($row = pg_fetch_row($ret)) {
				$outputauto .= '		
						 <tr style="font-size: 12px;">  							
							<td width="30%">'.$row[0].'</td>  							
							<td width="25%">'.$row[1].'</td>  
							<td width="25%">'.$row[2].'</td> ';	
						if (strlen($row[3])<=50) {
							$outputauto .= '<td width="500%" data-toggle="tooltip" data-placement="top" title= "'. $row[3].'">'.$row[3].'</td> ';
						} else {
							$outputauto .= '<td width="500%" data-toggle="tooltip" data-placement="top" title= "'. $row[3].'">'.substr($row[3], 0, 50).'<b>...</b></td> ';
						}						
			$outputauto .= '<td width="30%">'.$row[4].'</td>  							
							<td width="25%">'.$row[5].'</td>  
							<td width="30%">'.$row[6].'</td>  							
							<td width="25%">'.$row[7].'</td>  
						 </tr>';
		}
		$outputauto .= '</table></div>';
		
		echo $outputauto;
			
	}
	
	if ($equipe == "10") {		
	
		$query = "SELECT ds_status_trtmto status
					 , to_char(dt_inic_status_equipe_trtmto, 'dd/mm/yyyy hh24:mi') dt_inicio_status
					 , to_char(dt_final_status_equipe_trtmto, 'dd/mm/yyyy hh24:mi') dt_final_status
					 , ds_obs_pcnt observacao
					 , cd_usua_incs as usuario_que_incluiu
					 , to_char(dt_incs, 'dd/mm/yyyy hh24:mi') data_inclusao
					 , cd_usua_altr as usuario_que_alterou
					 , to_char(dt_altr, 'dd/mm/yyyy hh24:mi') data_que_alterou
				FROM tratamento.tb_hstr_obs_pnel_solic_trtmto 
				WHERE cd_pcnt = '".$pac."'
				  and id_status_equipe = 10
				  and id_hstr_pnel_solic_trtmto = (
														select max(id_hstr_pnel_solic_trtmto)
														 from tratamento.tb_hstr_obs_pnel_solic_trtmto
														where cd_pcnt = '".$pac."'
														  and id_status_equipe = 10
														)
				ORDER BY id_hstr_obs_pnel_solic_trtmto ASC  ";
			
		$outputauto .= '  
		<div class="table-responsive">  
           <table class="table table-bordered">
		   <tr style="font-size: 12px;">
			<th>Status</th>
			<th>Início</th>
			<th>Fim</th>
			<th>Observação</th>
			<th>Quem Incluiu?</th>
			<th>Incs</th>
			<th>Quem Alterou?</th>
			<th>Alteração</th>
		   </tr>';
		$ret = pg_query($pdo, $query);
		if(!$ret) {
			echo pg_last_error($pdo);
			exit;
		}   
		   
		//$row = pg_fetch_row($ret);
		while($row = pg_fetch_row($ret)) {
				$outputauto .= '		
						 <tr style="font-size: 12px;">  							
							<td width="30%">'.$row[0].'</td>  							
							<td width="25%">'.$row[1].'</td>  
							<td width="25%">'.$row[2].'</td> ';	
						if (strlen($row[3])<=50) {
							$outputauto .= '<td width="500%" data-toggle="tooltip" data-placement="top" title= "'. $row[3].'">'.$row[3].'</td> ';
						} else {
							$outputauto .= '<td width="500%" data-toggle="tooltip" data-placement="top" title= "'. $row[3].'">'.substr($row[3], 0, 50).'<b>...</b></td> ';
						}						
			$outputauto .= '<td width="30%">'.$row[4].'</td>  							
							<td width="25%">'.$row[5].'</td>  
							<td width="30%">'.$row[6].'</td>  							
							<td width="25%">'.$row[7].'</td>  
						 </tr>';
		}
		$outputauto .= '</table></div>';
		
		echo $outputauto;
			
	}
	
	if ($equipe == "11") {		
	
		$query = "SELECT ds_status_trtmto status
					 , to_char(dt_inic_status_equipe_trtmto, 'dd/mm/yyyy hh24:mi') dt_inicio_status
					 , to_char(dt_final_status_equipe_trtmto, 'dd/mm/yyyy hh24:mi') dt_final_status
					 , ds_obs_pcnt observacao
					 , cd_usua_incs as usuario_que_incluiu
					 , to_char(dt_incs, 'dd/mm/yyyy hh24:mi') data_inclusao
					 , cd_usua_altr as usuario_que_alterou
					 , to_char(dt_altr, 'dd/mm/yyyy hh24:mi') data_que_alterou
				FROM tratamento.tb_hstr_obs_pnel_solic_trtmto 
				WHERE cd_pcnt = '".$pac."'
				  and id_status_equipe = 11
				  and id_hstr_pnel_solic_trtmto = (
														select max(id_hstr_pnel_solic_trtmto)
														 from tratamento.tb_hstr_obs_pnel_solic_trtmto
														where cd_pcnt = '".$pac."'
														  and id_status_equipe = 11
														)
				ORDER BY id_hstr_obs_pnel_solic_trtmto ASC  ";
			
		$outputauto .= '  
		<div class="table-responsive">  
           <table class="table table-bordered">
		   <tr style="font-size: 12px;">
			<th>Status</th>
			<th>Início</th>
			<th>Fim</th>
			<th>Observação</th>
			<th>Quem Incluiu?</th>
			<th>Incs</th>
			<th>Quem Alterou?</th>
			<th>Alteração</th>
		   </tr>';
		$ret = pg_query($pdo, $query);
		if(!$ret) {
			echo pg_last_error($pdo);
			exit;
		}   
		   
		//$row = pg_fetch_row($ret);
		while($row = pg_fetch_row($ret)) {
				$outputauto .= '		
						 <tr style="font-size: 12px;">  							
							<td width="30%">'.$row[0].'</td>  							
							<td width="25%">'.$row[1].'</td>  
							<td width="25%">'.$row[2].'</td> ';	
						if (strlen($row[3])<=50) {
							$outputauto .= '<td width="500%" data-toggle="tooltip" data-placement="top" title= "'. $row[3].'">'.$row[3].'</td> ';
						} else {
							$outputauto .= '<td width="500%" data-toggle="tooltip" data-placement="top" title= "'. $row[3].'">'.substr($row[3], 0, 50).'<b>...</b></td> ';
						}						
			$outputauto .= '<td width="30%">'.$row[4].'</td>  							
							<td width="25%">'.$row[5].'</td>  
							<td width="30%">'.$row[6].'</td>  							
							<td width="25%">'.$row[7].'</td>  
						 </tr>';
		}
		$outputauto .= '</table></div>';
		
		echo $outputauto;
			
	}
	
}
	

?>
