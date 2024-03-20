<?php
//altera_cores.php
	session_start();
	$_SESSION['cd_usua_acesso']=$_POST['cd_usua_acesso'];
	
    include '../database.php';	
	
	$pdo = database::connect();

	$sql = "SELECT cd_usua_acesso, nm_usua_acesso, ds_usua_acesso,cd_faixa_ip_1,cd_faixa_ip_2, fl_sist_admn, fl_acesso_ip from tratamento.tb_c_usua_acesso where cd_usua_acesso = '".$_POST['cd_usua_acesso']."'";

	if ($pdo==null){
			header(Config::$webLogin);
	}	
	$ret = pg_query($pdo, $sql);
	if(!$ret) {
		echo pg_last_error($pdo);
		exit;
	}
	
	$row = pg_fetch_row($ret);	
	
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
						<h4 class="modal-title">Alteração de Usuários</h4>
					</div>								
					<form class="form-inline" method="post" >
						<div class="modal-body">
							<div class="table-responsive">  							
								<table class="table table-bordered">
									 <tr>  
										<td style="width:150px"><label>Id do Usuário:</label></td>  
										<td style="width:150px"><p class="form-control-static" name="cd_usua_acesso"><?php echo $_POST['cd_usua_acesso']; ?></p>
										</td>  
									 </tr>
									  <tr>  
										<td style="width:150px"><label>Nome do Usuário:</label></td>  
										<td style="width:400px"><input type="text" class="form-control" name="nm_usua_acesso" value="<?php echo $_POST['nm_usua_acesso']; ?>"></td> 							
									  </tr>									  
									  <tr>  
										<td style="width:150px"><label>Usuário Administrador?</label></td> 
										<?php if ($row[5]<>"S"){											
											?>											
											<td style="width:400px"><input type="checkbox" class="form-control" name="fl_sist_admn" id="fl_sist_admn" onchange=" 
														
														document.getElementById('fl_sist_admn_text').value = this.checked;"></td>
										<?php } else { 
											?>											
											<td style="width:400px"><input type="checkbox" class="form-control" name="fl_sist_admn" id="fl_sist_admn" checked onchange=" 
														document.getElementById('fl_sist_admn_text').value = this.checked;"> 
										<?php }	?>
									  </tr>										  
									  <tr>  
										<td style="width:150px"><label>Descrição do nome do usuário:</label></td>  
										<td style="width:200px"><input type="text" class="form-control" name="ds_usua_acesso" value="<?php echo $row[2]; ?>"></td>  
									 </tr>
									 <tr>  
										<td style="width:150px"><label>Faixa de IP 1 permitida para acesso:</label></td>  
										<td style="width:200px"><input type="text" class="form-control" name="cd_faixa_ip_1" value="<?php echo $row[3]; ?>"></td>  
									 </tr>
									 <tr>  
										<td style="width:150px"><label>Faixa de IP 2 permitida para acesso:</label></td>  
										<td style="width:200px"><input type="text" class="form-control" name="cd_faixa_ip_2" value="<?php echo $row[4]; ?>"></td>  
									 </tr>
									 <tr>  
										<td style="width:150px"><label>Usuário pode acessar em qualquer rede de dados?</label></td> 
										<?php if ($row[6]<>"S"){
											?>
											<td style="width:400px"><input type="checkbox" class="form-control" name="fl_acesso_ip" id="fl_acesso_ip" onchange=" 
														
														document.getElementById('fl_acesso_ip_text').value = this.checked;"></td>
										<?php } else { 
											?>
											<td style="width:400px"><input type="checkbox" class="form-control" name="fl_acesso_ip" id="fl_acesso_ip" checked onchange=" 
														document.getElementById('fl_acesso_ip_text').value = this.checked;"> 
										<?php }	?>
									  </tr>	
									  <input type="text" id="fl_sist_admn_text" name="fl_sist_admn_text" style="display:none"> 
									  <input type="text" id="fl_acesso_ip_text" name="fl_acesso_ip_text" style="display:none"> 
								</table>																
							</div>								
							<div class="modal-footer">	
								<input type="submit" class="btn btn-danger" name="altera" value="Alterar">&nbsp;&nbsp;&nbsp;&nbsp;
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
