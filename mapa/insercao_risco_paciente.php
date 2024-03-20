<?php
//insercao_usuario.php
	session_start();			
	
    include '../database.php';	
	
	$pdo = database::connect();
	$optconsulta = "";
	$textoconsulta = "";
	
?>	
	<!DOCTYPE html>
	<html lang="pt-br">
	<head>
	 <meta charset="utf-8">
	 <link href="../css/bootstrap.min.css" rel="stylesheet">
	 <link href="../css/style.css" rel="stylesheet">	 
</head>
	</head>
	<body style="margin-right: 0; margin-left: 0">	
		<div class="container" style="width: 100%;  margin-right: 0; margin-left: 0; position: relative;">
		  <div class="modal-dialog">
				<div class="modal-content" style="width:500px">
					<div class="container">						
						<h4 class="modal-title">Inserção de Riscos do Paciente</h4>
					</div>								
					<form class="form-inline" method="post" >
						<div class="modal-body">
							<div class="table-responsive">  							
								<table class="table table-bordered">									 									  
									  <tr>  
										<td style="width:150px"><label>Escolha o paciente para inserir o risco:</label></td>  
										<?php
										
										$sql = "SELECT distinct mapa.cd_pcnt, mapa.nm_pcnt from tratamento.tb_hstr_pnel_mapa_risco mapa where mapa.dt_final_mapa_risco is null order by 2";
										
										if ($pdo==null){
												header(Config::$webLogin);
										}	
										$ret = pg_query($pdo, $sql);
										if(!$ret) {
											echo pg_last_error($pdo);
											exit;
										}
										?>
										<td style="width:120px">
											<select  id="pcnt" class="form-control" onchange=" 
														var selObj = document.getElementById('pcnt');
														var selValue = selObj.options[selObj.selectedIndex].value;
														document.getElementById('cd_pcnt').value = selValue;">
												<option value="0"></option>
																									
											<?php
												$cont=1;																	
											
												while($row = pg_fetch_row($ret)) {
											?>												
													<option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>																		
											<?php $cont=$cont+1;} ?>	
											</select>											
										</td>  																				
									 </tr>
									 
									  <tr>  
										<td style="width:150px"><label>Escolha o risco:</label></td>  
										<?php
										
										$sql = "SELECT id_risco_pcnt, ds_risco_pcnt FROM tratamento.tb_c_risco_pcnt ORDER BY ds_risco_pcnt ASC";
										
										if ($pdo==null){
												header(Config::$webLogin);
										}	
										$ret = pg_query($pdo, $sql);
										if(!$ret) {
											echo pg_last_error($pdo);
											exit;
										}
										?>
										<td style="width:120px">
											<select  id="risco" class="form-control" onchange=" 
														var selObj = document.getElementById('risco');
														var selValue = selObj.options[selObj.selectedIndex].value;
														document.getElementById('id_risco_pcnt').value = selValue;">
												<option value="0"></option>
																									
											<?php
												$cont=1;																	
											
												while($row = pg_fetch_row($ret)) {
											?>												
													<option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>																		
											<?php $cont=$cont+1;} ?>	
											</select>											
										</td>  																				
									 </tr>
									 
								</table>																
							</div>								
							<div class="modal-footer">	
								<input type="submit" class="btn btn-danger" name="insererisco" value="Inserir">&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="submit" class="btn btn-primary" onclick="history.go()" value="Voltar">						
							</div>
							<input type="text" id="cd_pcnt" name="cd_pcnt" style="display:none"> 	
							<input type="text" id="id_risco_pcnt" name="id_risco_pcnt" style="display:none"> 		
						</div>
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
