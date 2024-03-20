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
		<div class="container" style="width: 100%;  margin-right: 0; margin-left: 0; position: relative;">
		  <div class="modal-dialog">
				<div class="modal-content" style="width:800px">
					<div class="container">						
						<h4 class="modal-title">Inserção do Status do Tratamento</h4>
					</div>								
					<form class="form-inline" method="post" id="formulario">
						<div class="modal-body">
							<div class="table-responsive">
								<table class="table table-bordered">									 
									 
									    <tr>  
											<td style="width:150px"><label>Descrição do Status do Tratamento:</label></td>  
											<td style="width:200px"><input type="text" class="form-control" name="ds_status_trtmto"></td>  
									 </tr>	
								
									  <tr>  
										<td style="width:150px"><label>Descrição da Equipe:</label></td>  
										<?php
										
										$sql = "SELECT id_equipe, ds_equipe from tratamento.tb_c_equipe order by 1";
										
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
											<select  id="cequipe" class="form-control" onchange=" 
														var selObj = document.getElementById('cequipe');
														var selValue = selObj.options[selObj.selectedIndex].value;
														document.getElementById('id_equipe').value = selValue;">
														<option value="null"></option>
																									
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
										<td style="width:150px"><label>Flag Ativo?</label></td>
										<td style="width:150px">
											<select  class="form-control" id="flativo" onchange=" 
														var selObj = document.getElementById('flativo');
														var selValue = selObj.options[selObj.selectedIndex].value;
														document.getElementById('fl_ativo').value = selValue;">
													<option value="null"></option>
													<option value="1">Sim</option>
													<option value="0">Não</option>
											</select>
										</td>  
									 </tr>
									 
									 <tr>  
										<td style="width:150px"><label>Flag Interrompe o Tratamento?</label></td>
										<td style="width:150px">
											<select  class="form-control" id="flstatusintrpetrtmtoequipe" onchange=" 
														var selObj = document.getElementById('flstatusintrpetrtmtoequipe');
														var selValue = selObj.options[selObj.selectedIndex].value;
														document.getElementById('fl_status_intrpe_trtmto_equipe').value = selValue;">
													<option value="null"></option>
													<option value="1">Sim</option>
													<option value="0">Não</option>
											</select>
										</td>  
										
									 </tr>
									 
									 <tr>  
										<td style="width:150px"><label>Flag Finaliza o Tratamento?</label></td>
										<td style="width:150px">
											<select  class="form-control" id="flstatusfinalizatrtmtoequipe" onchange=" 
														var selObj = document.getElementById('flstatusfinalizatrtmtoequipe');
														var selValue = selObj.options[selObj.selectedIndex].value;
														document.getElementById('fl_status_finaliza_trtmto_equipe').value = selValue;">
													<option value="null"></option>
													<option value="1">Sim</option>
													<option value="0">Não</option>
											</select>
										</td>  
										
									 </tr>
									 <tr>  
											<td style="width:150px"><label>Cor no Painel:</label></td>  
											<td style="width:200px"><input type="text" class="form-control" name="cd_cor_status_trtmto"></td>  
									 </tr>	
									 
									 <tr>  
										<td style="width:150px"><label>Flag para o Status Inicial do Tratamento?</label></td>
										<td style="width:150px">
											<select  class="form-control" id="flstatusinicialtrtmto" onchange=" 
														var selObj = document.getElementById('flstatusinicialtrtmto');
														var selValue = selObj.options[selObj.selectedIndex].value;
														document.getElementById('fl_status_inicial_trtmto').value = selValue;">
													<option value="null"></option>
													<option value="1">Sim</option>
													<option value="0">Não</option>
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
						<input type="text" id="id_equipe" name="id_equipe" style="display:none"> 
						<input type="text" id="fl_ativo" name="fl_ativo" style="display:none"> 
						<input type="text" id="fl_status_intrpe_trtmto_equipe" name="fl_status_intrpe_trtmto_equipe" style="display:none"> 
						<input type="text" id="fl_status_finaliza_trtmto_equipe" name="fl_status_finaliza_trtmto_equipe" style="display:none"> 
						<input type="text" id="fl_status_inicial_trtmto" name="fl_status_inicial_trtmto" style="display:none">
						
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
