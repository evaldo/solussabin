<?php
//altera_cores.php
	session_start();
	
	include '../database.php';
	
	$pdo = database::connect();	
	
	$sql = '';
	
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
						<h4 class="modal-title">Inclusão de Menus</h4>
					</div>								
					<form class="form-inline" method="post" >
						<div class="modal-body">
							<div class="table-responsive">  							
								<table class="table table-bordered">												 
									  <tr>  
										<td style="width:150px"><label>Nome do Menu:</label></td>  
										<td style="width:400px"><input type="text" class="form-control" name="nm_menu_sist_tratamento"></td> 							
									  </tr>									  
									  <tr>  
										<td style="width:150px"><label>Menu Principal?</label></td> 										
										<td style="width:400px"><input type="checkbox" class="form-control" name="fl_menu_princ" id="fl_menu_princ" onchange=" 
														
											document.getElementById('fl_menu_princ_text').value = this.checked;"></td>										
									  </tr>	
									  <tr>  
										<td style="width:150px"><label>Menu Superior:</label></td>  
										
										<?php
										
										$sql = "SELECT nm_menu_sist_tratamento, id_menu_sist_tratamento from tratamento.tb_c_menu_sist_tratamento order by 1";
										
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
											<select  id="gmenu" class="form-control" onchange=" 
														var selObj = document.getElementById('gmenu');
														var selValue = selObj.options[selObj.selectedIndex].value;
														document.getElementById('id_menu_supr').value = selValue;">
											<option value="null"></option>
														
											<?php
												$cont=1;																	
											
												while($row = pg_fetch_row($ret)) {																											
												?>																								
													<option value="<?php echo $row[1]; ?>"><?php echo $row[0]; ?></option>												
													<?php  
												$cont=$cont+1;} ?>	
											</select>
										
										</td> 							
									  </tr>
									  <tr>  
										<td style="width:150px"><label>Nome do Objeto na Aplicação:</label></td>  
										<td style="width:400px"><input type="text" class="form-control" name="nm_objt"></td> 							
									  </tr>									  
									  <tr>  
										<td style="width:150px"><label>Nome do Link para o Objeto:</label></td>  
										<td style="width:400px"><input type="text" class="form-control" name="nm_link_objt" size="65"></td> 							
									  </tr>
									  <input type="text" id="fl_menu_princ_text" name="fl_menu_princ_text" style="display:none"> 
									  <input type="text" id="id_menu_supr" name="id_menu_supr" style="display:none"> 
								</table>																
							</div>								
							<div class="modal-footer">	
								<input type="submit" class="btn btn-danger" name="insere" value="Inserir">&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="submit" class="btn btn-primary" onclick="history.go()" value="Voltar">						
							</div>									
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
