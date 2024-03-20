<?php
//altera_cores.php
	session_start();
	$_SESSION['id_status_trtmto']=$_POST['id_status_trtmto'];
	
    include '../database.php';	
	
	$pdo = database::connect();

	$sql = "SELECT id_status_trtmto, id_equipe, ds_status_trtmto, fl_ativo, fl_status_intrpe_trtmto_equipe, fl_status_finaliza_trtmto_equipe, cd_cor_status_trtmto, fl_status_inicial_trtmto from tratamento.tb_c_status_trtmto where id_status_trtmto = ".$_SESSION['id_status_trtmto']."";

	if ($pdo==null){
			header(Config::$webLogin);
	}	
	$ret = pg_query($pdo, $sql);
	if(!$ret) {
		echo pg_last_error($pdo);
		exit;
	}
	
	$row = pg_fetch_row($ret);
		
	$id_status_trtmto = $row[0];
	$id_equipe = $row[1];	
	$ds_status_trtmto = $row[2];
	$fl_ativo = $row[3];
	$fl_status_intrpe_trtmto_equipe = $row[4];	
	$fl_status_finaliza_trtmto_equipe = $row[5];
	$cd_cor_status_trtmto = $row[6];
	$fl_status_inicial_trtmto = $row[7];
	
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
						<h4 class="modal-title">Alteração do Status do Tratamento</h4>
					</div>								
					<form class="form-inline" method="post" >
						<div class="modal-body">
							<div class="table-responsive">  							
								<table class="table table-bordered">
									 <tr>  
										<td style="width:150px"><label>Id do Status do Tratamento:</label></td>  
										<td style="width:150px"><p class="form-control-static" name="id_status_trtmto"><?php echo $id_status_trtmto; ?></p>
										</td>  
									 </tr>
									 <tr>  
										<td style="width:150px"><label>Descrição do Status do Tratamento:</label></td>  
										<td style="width:200px"><input type="text" class="form-control" name="ds_status_trtmto" value="<?php echo $ds_status_trtmto; ?>"></td>  
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
																									
											<?php
												$cont=1;																	
											
												while($row = pg_fetch_row($ret)) {
													if($row[0]==$id_equipe){														
												?>												
													<option value="<?php echo $row[0]; ?>" selected><?php echo $row[1]; ?></option>
												<?php																		
													} else {
												?>
													<option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>												
													<?php } 
												$cont=$cont+1;} ?>
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
													<?php												
														if($fl_ativo==1){														
													?>
														<option value="1" selected>Sim</option>
														<option value="0">Não</option>
													<?php												
														} else {
													?>
														<option value="1">Sim</option>
														<option value="0" selected>Não</option>
													<?php												
														} 
													?>
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
													<?php												
														if($fl_status_intrpe_trtmto_equipe==1){														
													?>
														<option value="1" selected>Sim</option>
														<option value="0">Não</option>
													<?php												
														} else {
													?>
														<option value="1">Sim</option>
														<option value="0" selected>Não</option>
													<?php												
														} 
													?>
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
													<?php												
														if($fl_status_finaliza_trtmto_equipe==1){														
													?>
														<option value="1" selected>Sim</option>
														<option value="0">Não</option>
													<?php												
														} else {
													?>
														<option value="1">Sim</option>
														<option value="0" selected>Não</option>
													<?php												
														} 
													?>
											</select>
										</td>  
									 </tr>
									 <tr>  
										<td style="width:150px"><label>Cor no Painel:</label></td>  
										<td style="width:200px"><input type="text" class="form-control" name="cd_cor_status_trtmto" value="<?php echo $cd_cor_status_trtmto; ?>"></td>  
									 </tr>
									  <tr>  
										<td style="width:150px"><label>Flag para o Status Inicial do Tratamento?</label></td>
										<td style="width:150px">
											<select  class="form-control" id="flstatusinicialtrtmto" onchange=" 
														var selObj = document.getElementById('flstatusinicialtrtmto');
														var selValue = selObj.options[selObj.selectedIndex].value;
														document.getElementById('fl_status_inicial_trtmto').value = selValue;">
													<?php												
														if($fl_status_inicial_trtmto==1){														
													?>
														<option value="1" selected>Sim</option>
														<option value="0">Não</option>
													<?php												
														} else {
													?>
														<option value="1">Sim</option>
														<option value="0" selected>Não</option>
													<?php												
														} 
													?>
											</select>
										</td>  
									 </tr>
								</table>																
							</div>								
							<div class="modal-footer">	
								<input type="submit" class="btn btn-danger" name="altera" value="Alterar">&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="submit" class="btn btn-primary" onclick="history.go()" value="Voltar">						
							</div>									
						</div>
						<input type="text" id="id_equipe" name="id_equipe" style="display:none" value="<?php echo $id_equipe; ?>"> 
						<input type="text" id="fl_ativo" name="fl_ativo" style="display:none" value="<?php echo $fl_ativo; ?>"> 
						<input type="text" id="fl_status_intrpe_trtmto_equipe" name="fl_status_intrpe_trtmto_equipe" style="display:none" value="<?php echo $fl_status_intrpe_trtmto_equipe; ?>"> 
						<input type="text" id="fl_status_finaliza_trtmto_equipe" name="fl_status_finaliza_trtmto_equipe" style="display:none" value="<?php echo $fl_status_finaliza_trtmto_equipe; ?>"> 
						<input type="text" id="fl_status_inicial_trtmto" name="fl_status_inicial_trtmto" style="display:none" value="<?php echo $fl_status_inicial_trtmto; ?>">
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
