<?php
//insercao_usuario.php
	session_start();			
	
    include '../database.php';	
	
	$pdo = database::connect();
	
	if(isset($_POST['autoriza'])){					
		
		if ($pdo==null){
			header(Config::$webLogin);
		}
		
		try
		{	
			
			if ($_POST['fl_autrz_trtmto'] == 1){
							
				$sql = "UPDATE tratamento.tb_hstr_pnel_solic_trtmto SET fl_autrz_trtmto = 1, cd_usua_altr = '".$_SESSION['usuario']."', dt_altr = current_timestamp WHERE cd_pcnt = '". $_POST['cd_pcnt'] ."' and fl_trtmto_fchd = 0";
				
				//echo $sql;
				
				$result = pg_query($pdo, $sql);
				
				if($result){
					echo "";
				} 
				
				echo "<div class=\"alert alert-warning alert-dismissible\">
							<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
							<strong>Atenção!</strong>Alteração da Autorização de Finalização Realizada!!</div>";
				
				$secondsWait = 3;
				header("Refresh:$secondsWait");
				
			} else {
			
				$sql = "UPDATE tratamento.tb_hstr_pnel_solic_trtmto SET fl_autrz_trtmto = 0, cd_usua_altr = '".$_SESSION['usuario']."', dt_altr = current_timestamp WHERE cd_pcnt = '". $_POST['cd_pcnt'] ."' and fl_trtmto_fchd = 0";
				
				//echo $sql;
				
				$result = pg_query($pdo, $sql);

				if($result){
					echo "";
				} 
				
				echo "<div class=\"alert alert-warning alert-dismissible\">
							<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
							<strong>Atenção!</strong>Alteração da Autorização de Finalização Realizada!!</div>";
				
				$secondsWait = 3;
				header("Refresh:$secondsWait");
			
			}
				
		} catch(PDOException $e)
		{
			die($e->getMessage());
		}
	}
	
	
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
						<h4 class="modal-title">Autorização para Finalizar o Tratamento</h4>
					</div>								
					<form class="form-inline" method="post" id="formulario">
						<div class="modal-body">
							<div class="table-responsive">
								<table class="table table-bordered">
								
									<tr>  
										<td style="width:150px"><label>Escolha o paciente para finalização do tratamento:</label></td>  
										<?php
										
										$sql = "SELECT distinct cd_pcnt, nm_pcnt from tratamento.tb_hstr_pnel_solic_trtmto where fl_trtmto_fchd = 0 order by 2";
										
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
										<td style="width:150px"><label>Autorizar a Finalização do Tratamento?</label></td>	
										<td style="width:150px">
											<select  id="selfl_autrz_trtmto" class="form-control" onchange=" 
														var selObj = document.getElementById('selfl_autrz_trtmto');
														var selValue = selObj.options[selObj.selectedIndex].value;
														document.getElementById('fl_autrz_trtmto').value = selValue;">
												<option value="0">Não Autorizar a Finalização</option>
												<option value="1">Autorizar a Finalização</option>
											</select>
										</td>  								
									 </tr>
									 
								</table>																
							</div>
							<div class="modal-footer">	
								<input type="submit" class="btn btn-danger" name="autoriza" value="Confirmar">&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="button" class="btn btn-primary" onclick="history.go()" value="Voltar">									
							</div>									
						</div>				
						<!--style="display:none"-->
						<input type="text" id="cd_pcnt" name="cd_pcnt" style="display:none"> 	
						<input type="text" id="fl_autrz_trtmto" name="fl_autrz_trtmto" value="0" style="display:none"> 							
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
