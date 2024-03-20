<?php
//insercao_usuario.php
		
	session_start();
	
	error_reporting(0); 	
	
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
						<h4 class="modal-title">Acesso Venoso e Via de Aplicação</h4>
					</div>								
					<form class="form-inline" method="post" id="formulario">
						<div class="modal-body">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>  
										<td style="width:150px"><label>Escolha o paciente:</label></td>  
										<?php
										
										$sql = "SELECT distinct 
										                mapa_hstr.cd_pcnt
													  , mapa_hstr.nm_pcnt
												 FROM tratamento.tb_hstr_pnel_mapa_risco mapa_hstr												  
												WHERE mapa_hstr.dt_final_mapa_risco is null
												ORDER BY mapa_hstr.nm_pcnt asc        ";
										
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
														document.getElementById('cd_pcnt').value = selValue;">
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
										<td style="width:150px"><label>Acesso Venoso:</label></td> 
										<td style="width:150px">
											<select  id="selacessovenoso" class="form-control" onchange=" 
														var selObj = document.getElementById('selacessovenoso');
														var selValue = selObj.options[selObj.selectedIndex].value;
														document.getElementById('acessovenoso').value = selValue;">
												<option value="null"></option>
												<option value="avp">Acesso Venoso Periférico</option>
												<option value="cvc">Cateter Venoso Central</option>
											</select>	
										</td>
									 </tr>
									 <tr>
										<td style="width:150px"><label>Via de Aplicação:</label></td> 										
										<td style="width:150px">
											<input type="checkbox" name="ev"  id="ev" value="ev" onchange="document.getElementById('ev_text').value = this.checked;">Endrovenoso&nbsp;&nbsp;
											<input type="checkbox" name="sc"  id="sc" value="sc" onchange="document.getElementById('sc_text').value = this.checked;">Subcutâneo&nbsp;&nbsp;
											<input type="checkbox" name="im"  id="im" value="im" onchange="document.getElementById('im_text').value = this.checked;">Intramuscular&nbsp;&nbsp;
											<input type="checkbox" name="vv"  id="vv" value="vv" onchange="document.getElementById('vv_text').value = this.checked;">Via Vesical&nbsp;&nbsp;
										</td>										
									 </tr>	
								</table>																
							</div>
							<div class="modal-footer">	
								<input type="submit" class="btn btn-danger" name="forminsereacessovenoso" value="Inserir">&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="button" class="btn btn-primary" onclick="history.go()" value="Voltar">									
							</div>									
						</div>		
						<!-- style="display:none"-->
						<input type="text" id="cd_pcnt" name="cd_pcnt" style="display:none">
						<input type="text" id="acessovenoso" name="acessovenoso" style="display:none">
						<input type="text" id="ev_text" name="ev_text" value="false" style="display:none"/>
						<input type="text" id="sc_text" name="sc_text" value="false" style="display:none"/>
						<input type="text" id="im_text" name="im_text" value="false" style="display:none"/>
						<input type="text" id="vv_text" name="vv_text" value="false" style="display:none"/>
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
