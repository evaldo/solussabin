<?php
//delete_cores.php
	session_start();
	$_SESSION['id_status_trtmto']=$_POST['id_status_trtmto'];
		
?>
	<!DOCTYPE html>
	<html lang="pt-br">
	<head>
	 <meta charset="utf-8">
	 <link href="../css/bootstrap.min.css" rel="stylesheet">
	 <link href="../css/style.css" rel="stylesheet">
	</head>
	<body>	
		<div class="container">
		  <div class="modal-dialog">
				<div class="modal-content">
					<div class="container">						
						<h4 class="modal-title">Exclusão do Status de Tratamento</h4>
					</div>	

					<div class="modal-body">
						<div class="table-responsive">  
							<table class="table table-bordered">
								 <tr>  
									<td width="50%"><label>Id do Status do Tratamento:</label></td>  
									<td width="500%"><?php echo $_POST['id_status_trtmto']; ?></td>  
								 </tr>
								  <tr>  
									<td width="50%"><label>Descrição do Status do Tratamento:</label></td>  
									<td width="500%"><?php echo $_POST['ds_status_trtmto']; ?></td>  
								 </tr>								 
								 <tr>  
									<td width="50%"><label>Descrição da Equipe:</label></td>  
									<td width="500%"><?php echo $_POST['ds_equipe']; ?></td>  
								 </tr>
								 <tr>  
									<td width="50%"><label>Flag Ativo?</label></td>  
									<td width="500%"><?php echo $_POST['fl_ativo']; ?></td>  
								 </tr>
								 <tr>  
									<td width="50%"><label>Flag Interrompe o Tratamento?</label></td>  
									<td width="500%"><?php echo $_POST['fl_status_intrpe_trtmto_equipe']; ?></td>  
								 </tr>
								 <tr>  
									<td width="50%"><label>Flag Finaliza o Tratamento?</label></td>  
									<td width="500%"><?php echo $_POST['fl_status_finaliza_trtmto_equipe']; ?></td>  
								 </tr>
								 <tr>  
									<td width="50%"><label>Cor no Painel</label></td>  
									<td width="500%"><?php echo $_POST['cd_cor_status_trtmto']; ?></td>  
								 </tr>
								 <tr>  
									<td width="50%"><label>Flag para o Status Inicial do Tratamento?</label></td>  
									<td width="500%"><?php echo $_POST['fl_status_inicial_trtmto']; ?></td>  
								 </tr>
							</table>
						</div>
					</div>
					<div class="modal-footer">					
						<form class="form-inline" action="#" method="post" >
							<input type="submit" class="btn btn-danger" name="deleta" value="Apagar">&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="submit" class="btn btn-primary" onclick="history.go()" value="Voltar">
						</form>
					</div>
				</div>
			</div>
		</div>		
		<script src="../js/jquery.min.js"></script>
		<script src="../js/bootstrap.min.js"></script>
	</body>
	</html>
		
<?php 
    
	
?>
