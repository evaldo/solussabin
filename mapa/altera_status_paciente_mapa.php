<?php
//insercao_usuario.php
		
	session_start();
	
	include '../database.php';
	$pdo = database::connect();
	
	
?>	

	<!DOCTYPE html>
	<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<link href="../css/bootstrap.min.css" rel="stylesheet">
		<link href="../css/style.css" rel="stylesheet">					
	</head>
	<body style="margin-right: 0; margin-left: 0">		
		<div class="container" style="width: 70%;  margin-right: 0; margin-left: 0; position: relative;">
		  <div class="modal-dialog">
				<div class="modal-content" style="width:800px">
					<div class="container">						
						<h4 class="modal-title">Alterar Observação do Status do Mapa de Tratamento</h4>
					</div>								
					<form class="form-inline" method="post" id="formulario">
						<div class="modal-body">
							<div class="table-responsive">
								<table class="table table-bordered">
									 
									 <tr>  
										<td style="width:150px"><label>Escolha o paciente-status no mapa:</label></td>  
										<?php
										
										$sql = "SELECT mapa_hstr.cd_pcnt
													 , mapa_hstr.nm_pcnt||'->'||status.ds_status_pcnt as nm_pcnt_status
													 , mapa_hstr.id_status_pcnt
													 , mapa_hstr.ds_obs_mapa_risco
													 , mapa.id_hstr_pnel_mapa_risco
													 , mapa_hstr.id_hstr_obs_pnel_mapa_risco
												FROM tratamento.tb_hstr_obs_pnel_mapa_risco mapa_hstr
												   , tratamento.tb_c_status_pcnt status 
												   , tratamento.tb_hstr_pnel_mapa_risco mapa
												WHERE mapa_hstr.id_status_pcnt = status.id_status_pcnt 
												  AND mapa_hstr.id_hstr_pnel_mapa_risco = mapa.id_hstr_pnel_mapa_risco
												  AND mapa.dt_final_mapa_risco is null
												ORDER BY mapa_hstr.nm_pcnt, status.ds_status_pcnt asc  ";
										
										if ($pdo==null){
												header(Config::$webLogin);
										}	
										$ret = pg_query($pdo, $sql);
										if(!$ret) {
											echo pg_last_error($pdo);
											exit;
										}
										?>
										<td style="width:150px">
											<select  id="pcnt" class="form-control" onchange=" 
														var selObj = document.getElementById('pcnt');
														var selValue = selObj.options[selObj.selectedIndex].value;
														var selnm_pcnt = $(this).find(':selected').data('nm_pcnt');
														var selid_status_pcnt = $(this).find(':selected').data('id_status_pcnt');
														var selds_utlma_obs_mapa_risco = $(this).find(':selected').data('ds_utlma_obs_mapa_risco');
														var selid_hstr_pnel_mapa_risco = $(this).find(':selected').data('id_hstr_pnel_mapa_risco');
														var selid_hstr_obs_pnel_mapa_risco = $(this).find(':selected').data('id_hstr_obs_pnel_mapa_risco');
														document.getElementById('cd_pcnt').value = selValue;
														document.getElementById('nm_pcnt').value = selnm_pcnt;
														document.getElementById('id_status_pcnt').value = selid_status_pcnt;
														document.getElementById('ds_utlma_obs_mapa_risco').value = selds_utlma_obs_mapa_risco;
														document.getElementById('id_hstr_pnel_mapa_risco').value = selid_hstr_pnel_mapa_risco;
														document.getElementById('id_hstr_obs_pnel_mapa_risco').value = selid_hstr_obs_pnel_mapa_risco;
														">
														<option value="" data-id_status_pcnt="" data-ds_utlma_obs_mapa_risco="" data-id_hstr_pnel_mapa_risco="" data-id_hstr_obs_pnel_mapa_risco=""></option>
											<?php
												$cont=1;																	
											
												while($row = pg_fetch_row($ret)) {
												?>												
													<option value="<?php echo $row[0]; ?>" data-id_status_pcnt="<?php echo $row[2]; ?>" data-ds_utlma_obs_mapa_risco="<?php echo $row[3]; ?>" data-id_hstr_pnel_mapa_risco="<?php echo $row[4]; ?>" data-id_hstr_obs_pnel_mapa_risco="<?php echo $row[5]; ?>"><?php echo $row[1]; ?></option>	
											<?php $cont=$cont+1;} ?>	
											</select>											
										</td>  																				
									 </tr>
									
									  <tr>  
										<td style="width:150px"><label>Observação:</label></td>  
										<td style="width:200px"><textarea rows="3" cols="70" id="ds_utlma_obs_mapa_risco" class="form-control" name="ds_utlma_obs_mapa_risco"></textarea></td>  
									 </tr>
									 
								</table>																
							</div>
							<div class="modal-footer">	
								<input type="submit" class="btn btn-danger" name="alterastatus" value="Alterar Observação do Status">&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="button" class="btn btn-primary" onclick="history.go()" value="Voltar">									
							</div>									
						</div>		
						<!-- style="display:none"-->												
						<input type="text" id="id_status_pcnt" name="id_status_pcnt" style="display:none">	
						<input type="text" id="nm_pcnt" name="nm_pcnt" style="display:none">
						<input type="text" id="cd_pcnt" name="cd_pcnt" style="display:none">
						<input type="text" id="id_hstr_pnel_mapa_risco" name="id_hstr_pnel_mapa_risco" style="display:none">
						<input type="text" id="id_hstr_obs_pnel_mapa_risco" name="id_hstr_obs_pnel_mapa_risco" style="display:none">
					</form>
				</div>
			</div>
		</div>		
		
		<script src="../js/jquery.min.js"></script>
		<script src="../js/bootstrap.min.js"></script>			
	</body>
	</html>
	
<?php 
    
	
?>
