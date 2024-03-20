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
						<h4 class="modal-title">Inserção de Grupos de Acesso Por Transação</h4>
					</div>								
					<form class="form-inline" method="post" id="formulario">
						<div class="modal-body">
							<div class="table-responsive">
								<table class="table table-bordered">	
										
									 <tr>  
										<td style="width:150px"><label>Transação:</label></td>  
										<?php
										
										$sql = "SELECT id_acesso_transac_tratamento, nm_acesso_transac_tratamento from tratamento.tb_c_acesso_transac_tratamento order by 1";
										
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
											<select  class="form-control" id="macesso" onchange=" 
														var selObj = document.getElementById('macesso');
														var selValue = selObj.options[selObj.selectedIndex].value;
														document.getElementById('id_acesso_transac_tratamento').value = selValue;">
											<option value="N"></option>
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
										<td style="width:150px"><label>Grupo de Acesso:</label></td>  
										<?php
										
										$sql = "SELECT id_grupo_acesso, nm_grupo_acesso from tratamento.tb_c_grupo_acesso order by 1";
										
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
											<select  id="gacesso" class="form-control" onchange=" 
														var selObj = document.getElementById('gacesso');
														var selValue = selObj.options[selObj.selectedIndex].value;
														document.getElementById('id_grupo_acesso').value = selValue;">
											<option value="N"></option>
														
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
								<input type="submit" class="btn btn-danger" name="insere" value="Inserir">&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="button" class="btn btn-primary" onclick="history.go()" value="Voltar">									
							</div>									
						</div>
						<input type="text" id="id_grupo_acesso" name="id_grupo_acesso" style="display:none"> 
						<input type="text" id="id_acesso_transac_tratamento" name="id_acesso_transac_tratamento" style="display:none"> 
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
