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
						<h4 class="modal-title">Alterar Observação do Status. Paciente: <?php echo $_POST['nm_pcnt'];?></h4>
					</div>								
					<form class="form-inline" method="post" id="formulario">
						<div class="modal-body">
							<div class="table-responsive">
								<table class="table table-bordered">
									 
									 <tr>  
										<td style="width:150px"><label>Escolha o paciente-equipe-status:</label></td>  
										<?php
										
										$sql = "SELECT trtmto.cd_pcnt, substring(trtmto.nm_pcnt, 1, 15)||'->'||trtmto.ds_equipe||' '||trtmto.ds_status_trtmto, trtmto.id_equipe, trtmto.id_status_trtmto, trtmto.ds_utlma_obs_pcnt from tratamento.tb_hstr_pnel_solic_trtmto trtmto, tratamento.tb_c_status_trtmto status where trtmto.id_status_trtmto = status.id_status_trtmto and status.fl_status_inicial_trtmto = 0 and trtmto.fl_trtmto_fchd = 0 and trtmto.cd_pcnt = '".$_POST['cd_pcnt']."' order by trtmto.nm_pcnt, trtmto.nu_seq_equipe_pnel asc";
										
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
														var selid_equipe = $(this).find(':selected').data('id_equipe');
														var selid_status_trtmto = $(this).find(':selected').data('id_status_trtmto');
														var selds_utlma_obs_pcnt = $(this).find(':selected').data('ds_utlma_obs_pcnt');
														document.getElementById('cd_pcnt').value = selValue;
														document.getElementById('nm_pcnt').value = selnm_pcnt;
														document.getElementById('id_equipe').value = selid_equipe;
														document.getElementById('id_status_trtmto').value = selid_status_trtmto;
														document.getElementById('ds_utlma_obs_pcnt').value = selds_utlma_obs_pcnt;">
														<option value="" data-id_equipe="" data-id_status_trtmto="" data-ds_utlma_obs_pcnt=""></option>
											<?php
												$cont=1;																	
											
												while($row = pg_fetch_row($ret)) {
												?>												
													<option value="<?php echo $row[0]; ?>" data-id_equipe="<?php echo $row[2]; ?>" data-id_status_trtmto="<?php echo $row[3]; ?>" data-ds_utlma_obs_pcnt="<?php echo $row[4]; ?>"><?php echo $row[1]; ?></option>	
											<?php $cont=$cont+1;} ?>	
											</select>											
										</td>  																				
									 </tr>
									
									  <tr>  
										<td style="width:150px"><label>Observação:</label></td>  
										<td style="width:200px"><textarea rows="3" cols="70" id="ds_utlma_obs_pcnt" class="form-control" name="ds_utlma_obs_pcnt"></textarea></td>  
									 </tr>
									 
								</table>																
							</div>
							<div class="modal-footer">	
								<input type="submit" class="btn btn-danger" name="alterastatus" value="Alterar Observação do Status">&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="button" class="btn btn-primary" onclick="history.go()" value="Voltar">									
							</div>									
						</div>		
						<!-- style="display:none"-->
						<input type="text" id="id_equipe" name="id_equipe" style="display:none"> 						
						<input type="text" id="id_status_trtmto" name="id_status_trtmto" style="display:none">	
						<input type="text" id="nm_pcnt" name="nm_pcnt" value="<?php echo $_POST['nm_pcnt'];?>" style="display:none">
						<input type="text" id="cd_pcnt" name="cd_pcnt" value="<?php echo $_POST['cd_pcnt'];?>" style="display:none">
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
