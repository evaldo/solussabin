<?php
//insercao_usuario.php
	session_start();	
	$_SESSION['cd_pcnt']=$_POST['cd_pcnt'];	
	
    include '../database.php';	
	
	$pdo = database::connect();
	
	$nm_pcnt = '';	
	$dt_nasc_pcnt = '';	
	$ds_mncp_pcnt = '';
	$cd_cnvo = '';
	
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
						<h4 class="modal-title">Exclusão de pacientes</h4>
					</div>								
					<form class="form-inline" method="post" id="formulario">
						<div class="modal-body">
							<div class="table-responsive">
								<table class="table table-bordered">
									
									 <tr>  
										<td width="50%"><label>Identificador no Sistema de Gestão:</label></td>  
										<td width="500%"><?php echo $_POST['cd_pcnt']; ?></td>  
									 </tr>
									  <tr>  
										<td width="50%"><label>Nome do Paciente:</label></td>  
										<td width="500%"><?php echo $_POST['nm_pcnt']; ?></td>  
									 </tr>
									 
								</table>																
							</div>
							<div class="modal-footer">	
								<input type="submit" class="btn btn-danger" name="deleta" value="Apagar">&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="button" class="btn btn-primary" onclick="history.go()" value="Voltar">									
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
