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
						<h4 class="modal-title">Novo Status. Paciente: <?php echo $_POST['nm_pcnt'];?></h4>
					</div>								
					<form class="form-inline" method="post" id="formulario">
						<div class="modal-body">
							<div class="table-responsive">
								<table class="table table-bordered">
								
									 <tr>  
										<td style="width:150px"><label>Equipe:</label></td>  
										<?php
										
										$sql = "SELECT id_equipe, ds_equipe from tratamento.tb_c_equipe order by nu_seq_equipe_pnel";
										
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
									 </tr>	
								
									 <tr>  
										<td style="width:150px"><label>Status de Tratamento Por Equipe:</label></td>  
										<?php
										
										$sql = "SELECT trtmto.id_status_trtmto, equipe.ds_equipe||' - '||trtmto.ds_status_trtmto
												FROM tratamento.tb_c_status_trtmto trtmto
												   , tratamento.tb_c_equipe equipe												   
												WHERE trtmto.id_equipe = equipe.id_equipe
												  and trtmto.fl_status_inicial_trtmto = 0
												  and trtmto.id_status_trtmto not in (select id_status_trtmto from tratamento.tb_hstr_pnel_solic_trtmto where cd_pcnt = '".$_POST['cd_pcnt']."' and fl_trtmto_fchd = 0) ORDER BY nu_seq_equipe_pnel ASC";
										
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
											<select  id="trtmto" class="form-control" onchange=" 
														var selObj = document.getElementById('trtmto');
														var selValue = selObj.options[selObj.selectedIndex].value;
														document.getElementById('id_status_trtmto').value = selValue;">
														<option value="null"></option>
																									
											<?php
												$cont=1;																	
											
												while($row = pg_fetch_row($ret)) {
												?>												
													<option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>																		
											<?php $cont=$cont+1;} ?>	
											</select>																
									 </tr>
									  <tr>  
										<td style="width:150px"><label>Observação:</label></td>  
										<td style="width:200px"><textarea rows="3" cols="70" id="ds_obs_pcnt" class="form-control" name="ds_obs_pcnt"></textarea></td>  
									 </tr>
									 
								</table>																
							</div>
							<div class="modal-footer">	
								<input type="submit" class="btn btn-danger" name="inserestatus" value="Inserir Status">&nbsp;&nbsp;&nbsp;&nbsp;
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
