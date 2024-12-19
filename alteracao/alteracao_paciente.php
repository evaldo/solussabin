<?php
//insercao_usuario.php
	session_start();
	$_SESSION['cd_pcnt']=$_POST['cd_pcnt'];
	
    include '../database.php';	
	
	$pdo = database::connect();

	$sql = "SELECT cd_pcnt, nm_pcnt, to_char(dt_nasc_pcnt,'yyyy-mm-dd'), ds_mncp_pcnt, cd_cnvo from tratamento.tb_c_pcnt where cd_pcnt = '".$_SESSION['cd_pcnt']."'";

	if ($pdo==null){
			header(Config::$webLogin);
	}	
	$ret = pg_query($pdo, $sql);
	if(!$ret) {
		echo pg_last_error($pdo);
		exit;
	}
	
	$row = pg_fetch_row($ret);	
	
	$nm_pcnt = $row[1];
	$dt_nasc_pcnt = $row[2];
	$ds_mncp_pcnt = $row[3];
	$cd_cnvo = $row[4];
	
	
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
						<h4 class="modal-title">Alteração de Pacientes</h4>
					</div>								
					<form class="form-inline" method="post" id="formulario">
						<div class="modal-body">
							<div class="table-responsive">
								<table class="table table-bordered">
								
									 <tr>  
										<td style="width:150px"><label>Identificador no Sistema de Gestão:</label></td>  										
										<td style="width:150px"><p class="form-control-static" name="cd_pcnt"><?php echo $_POST['cd_pcnt']; ?></p>
									 </tr>	
								
									 <tr>  
										<td style="width:150px"><label>Nome do Paciente:</label></td>
										<td style="width:400px"><input type="text" class="form-control" name="nm_pcnt" value="<?php echo $_POST['nm_pcnt']; ?>"></td>
									 </tr>
									 
									 <tr>  
										<td style="width:150px"><label>Data de Nascimento:</label></td>
										<td style="width:400px"><input type="date" data-date-format="dd/mm/yyyy" name="dt_nasc_pcnt" value="<?php echo $dt_nasc_pcnt; ?>"></td>  
									 </tr>
									 
									  <tr>  
										<td style="width:150px"><label>Município de Origem:</label></td>  
										<?php
										
										$sql = "SELECT id_mncp, ds_mncp from tratamento.tb_c_mncp order by 2";
										
										if ($pdo==null){
												header(Config::$webLogin);
										}	
										$retmncp = pg_query($pdo, $sql);
										if(!$retmncp) {
											echo pg_last_error($pdo);
											exit;
										}
										?>
										<td style="width:150px">
											<select  id="mncp" class="form-control" onchange=" 
														var selObj = document.getElementById('mncp');
														var selValue = selObj.options[selObj.selectedIndex].value;
														document.getElementById('ds_mncp_pcnt').value = selValue;">
														<option value="null"></option>
																									
											<?php
												$cont=1;																	
												
												while($rowmncp = pg_fetch_row($retmncp)) {
													
													if($rowmncp[1]==$ds_mncp_pcnt) {														
													?>
														<option value="<?php echo $ds_mncp_pcnt; ?>" selected><?php echo $ds_mncp_pcnt; ?></option>
													<?php
													} else {
													?>
														<option value="<?php echo $rowmncp[1]; ?>"><?php echo $rowmncp[1]; ?></option>																		
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
														<option value="<?php echo $cd_cnvo; ?>" selected><?php echo $cd_cnvo; ?></option>
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
								<input type="submit" class="btn btn-danger" name="altera" value="Alterar">&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="button" class="btn btn-primary" onclick="history.go()" value="Voltar">									
							</div>									
						</div>						
						<!--style="display:none"-->
						<input type="text" id="cd_cnvo" name="cd_cnvo" value="<?php echo $cd_cnvo; ?>" style="display:none"> 	
						<input type="text" id="ds_mncp_pcnt" name="ds_mncp_pcnt" value="<?php echo $ds_mncp_pcnt; ?>" style="display:none">						
						
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
