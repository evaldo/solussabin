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
						<h4 class="modal-title">Excluir Risco do Paciente no Mapa de Tratamento</h4>
					</div>								
					<form class="form-inline" method="post" id="formulario">
						<div class="modal-body">
							<div class="table-responsive">
								<table class="table table-bordered">
									 
									 <tr>  
										<td style="width:150px"><label>Escolha o paciente-risco:</label></td>  
										<?php
										
										$sql = "SELECT distinct mapa_risco.cd_pcnt
															 , mapa_risco.nm_pcnt||'->'||mapa_risco.ds_risco_pacnt as nm_pcnt_risco
															 , mapa_risco.id_risco_pcnt
															 , mapa_risco.id_hstr_pnel_mapa_risco
															 , mapa_risco.id_risco_rnado_pcnt
															 , mapa_risco.cd_pcnt
															 , mapa_risco.nm_pcnt
															 , mapa_risco.ds_risco_pacnt
														FROM tratamento.tb_risco_rnado_pcnt mapa_risco
														   , tratamento.tb_hstr_pnel_mapa_risco mapa_risco_pcnt
														WHERE mapa_risco_pcnt.id_hstr_pnel_mapa_risco = mapa_risco.id_hstr_pnel_mapa_risco
														  and mapa_risco_pcnt.dt_final_mapa_risco  is null
														  and mapa_risco.id_risco_rnado_pcnt = (
																							SELECT max(mapa.id_risco_rnado_pcnt)
																								FROM tratamento.tb_risco_rnado_pcnt mapa
																							WHERE mapa.cd_pcnt =  mapa_risco.cd_pcnt
																							)
														ORDER BY mapa_risco.nm_pcnt, mapa_risco.ds_risco_pacnt asc ";
										
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
														var selid_risco_pcnt = $(this).find(':selected').data('id_risco_pcnt');
														var selid_hstr_pnel_mapa_risco = $(this).find(':selected').data('id_hstr_pnel_mapa_risco');
														var selid_risco_rnado_pcnt = $(this).find(':selected').data('id_risco_rnado_pcnt');
														document.getElementById('cd_pcnt').value = selValue;
														document.getElementById('id_hstr_pnel_mapa_risco').value = selid_hstr_pnel_mapa_risco;
														document.getElementById('id_risco_rnado_pcnt').value = selid_risco_rnado_pcnt;
														document.getElementById('id_risco_pcnt').value = selid_risco_pcnt;
														">
														<option value="" data-id_risco_pcnt="" data-id_hstr_pnel_mapa_risco="" data-id_risco_rnado_pcnt=""></option>
											<?php
												$cont=1;																	
											
												while($row = pg_fetch_row($ret)) {
												?>												
													<option value="<?php echo $row[0]; ?>" data-id_risco_pcnt="<?php echo $row[2]; ?>" data-id_hstr_pnel_mapa_risco="<?php echo $row[3]; ?>" data-id_risco_rnado_pcnt="<?php echo $row[4]; ?>"><?php echo $row[1]; ?></option>	
											<?php $cont=$cont+1;} ?>	
											</select>											
										</td>  																				
									 </tr>
									
								</table>																
							</div>
							<div class="modal-footer">	
								<input type="submit" class="btn btn-danger" name="excluirisco" id="excluirisco" value="Excluir Risco">&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="button" class="btn btn-primary" onclick="history.go()" value="Voltar">									
							</div>									
						</div>		
						<!-- style="display:none"-->						
						<input type="text" id="id_risco_pcnt" name="id_risco_pcnt" style="display:none">	
						<input type="text" id="id_risco_rnado_pcnt" name="id_risco_rnado_pcnt" style="display:none">	
						<input type="text" id="cd_pcnt" name="cd_pcnt" style="display:none">
						<input type="text" id="id_hstr_pnel_mapa_risco" name="id_hstr_pnel_mapa_risco" style="display:none">
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
