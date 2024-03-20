<?php
//insercao_usuario.php
	session_start();			
	
    include '../database.php';	
	
	$pdo = database::connect();
	
	$nm_pcnt = '';	
	$dt_nasc_pcnt = '';	
	$ds_mncp_pcnt = '';
	$cd_cnvo = '';
	
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
						<h4 class="modal-title">Inserção do Novo Paciente para o Tratamento</h4>
					</div>								
					<form class="form-inline" method="post" id="formulario">
						<div class="modal-body">
							<div class="table-responsive">
								<table class="table table-bordered">
								
									<tr>  
										<td style="width:150px"><label>Escolha um paciente ou faça o cadastro abaixo:</label></td>  
										<?php
										
										$sql = "SELECT cd_pcnt, nm_pcnt, to_char(dt_nasc_pcnt,'yyyy-mm-dd'), ds_mncp_pcnt, cd_cnvo from tratamento.tb_c_pcnt order by 2";
										
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
														var seldt_nasc_pcnt = $(this).find(':selected').data('dt_nasc_pcnt');
														var selds_mncp_pcnt = $(this).find(':selected').data('ds_mncp_pcnt');
														var selcd_cnvo = $(this).find(':selected').data('cd_cnvo');
														document.getElementById('cd_pcnt').value = selValue;
														document.getElementById('nm_pcnt').value = selnm_pcnt;
														document.getElementById('dt_nasc_pcnt').value = seldt_nasc_pcnt;
														document.getElementById('mncp').value = selds_mncp_pcnt;
														document.getElementById('cnvo').value = selcd_cnvo;
														document.getElementById('cd_cnvo').value = selcd_cnvo;
														document.getElementById('ds_mncp').value = selds_mncp_pcnt;">
														<option value="" data-nm_pcnt="" data-cd_cnvo="" data-dt_nasc_pcnt="" data-ds_mncp_pcnt="">Novo</option>
																									
											<?php
												$cont=1;																	
											
												while($row = pg_fetch_row($ret)) {
												?>												
													<option value="<?php echo $row[0]; ?>" data-nm_pcnt="<?php echo $row[1]; ?>" data-dt_nasc_pcnt="<?php echo $row[2]; ?>" data-ds_mncp_pcnt="<?php echo $row[3]; ?>" data-cd_cnvo="<?php echo $row[4]; ?>" ><?php echo $row[1]; ?></option>																		
											<?php $cont=$cont+1;} ?>	
											</select>											
										</td>  																				
									 </tr>
								
									 <tr>  
										<td style="width:150px"><label>Identificador no Sistema de Gestão:</label></td>  
										<td style="width:200px"><input type="text" id="cd_pcnt" class="form-control" name="cd_pcnt"></td>  
									 </tr>	
								
									 <tr>  
										<td style="width:150px"><label>Nome do Paciente:</label></td>  
										<td style="width:200px"><input type="text" class="form-control" value="<?php echo $nm_pcnt; ?>" id="nm_pcnt" name="nm_pcnt"></td> 																			
									 </tr>
									 
									 <tr>  
										<td style="width:150px"><label>Data de Nascimento:</label></td>
										<td style="width:400px"><input type="date" class="form-control" id="dt_nasc_pcnt" name="dt_nasc_pcnt" value="<?php echo $dt_nasc_pcnt; ?>"></td>  
									 </tr>
									 
									  <tr>  
										<td style="width:150px"><label>Município de Origem:</label></td>  
										<?php
										
										$sql = "SELECT id_mncp, ds_mncp from tratamento.tb_c_mncp order by 2";
										
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
											<select  id="mncp" class="form-control" onchange=" 
														var selObj = document.getElementById('mncp');
														var selValue = selObj.options[selObj.selectedIndex].value;
														document.getElementById('ds_mncp').value = selValue;">
														<option value="null"></option>
																									
											<?php
												$cont=1;																	
											
												while($row = pg_fetch_row($ret)) {
													if($row[1]==$ds_mncp_pcnt) {														
													?>
														<option value="<?php echo $ds_mncp_pcnt; ?>"><?php echo $ds_mncp_pcnt; ?></option>
													<?php
													} else {
													?>
														<option value="<?php echo $row[1]; ?>"><?php echo $row[1]; ?></option>																		
												<?php $cont=$cont+1;}} ?>	
											</select>
										</td>  								
									 </tr>
									 
									 <tr>  
										<td style="width:150px"><label>Convênio:</label></td>  
										<?php
										
										$sql = "SELECT id_cnvo, cd_cnvo from tratamento.tb_c_cnvo order by 2";
										
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
											<select  id="cnvo" class="form-control" onchange=" 
														var selObj = document.getElementById('cnvo');
														var selValue = selObj.options[selObj.selectedIndex].value;
														document.getElementById('cd_cnvo').value = selValue;">
														<option value="null"></option>
																									
											<?php
												$cont=1;																	
												
												while($row = pg_fetch_row($ret)) {
													
													if($row[1]==$cd_cnvo) {															
													?>														
														<option value="<?php echo $cd_cnvo; ?>"><?php echo $cd_cnvo; ?></option>
													<?php													
													} else {																												
													?>													
														<option value="<?php echo $row[1]; ?>"><?php echo $row[1]; ?></option>																		
												<?php $cont=$cont+1;}} ?>	
											</select>
										</td>  								
									 </tr>
									 
								</table>																
							</div>
							<div class="modal-footer">	
								<input type="submit" class="btn btn-danger" name="insere" value="Inserir">&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="button" class="btn btn-primary" onclick="history.go()" value="Voltar">									
							</div>									
						</div>						
						<!--style="display:none"-->
						<input type="text" id="cd_cnvo" name="cd_cnvo" style="display:none"> 	
						<input type="text" id="ds_mncp" name="ds_mncp" style="display:none">						
						
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
