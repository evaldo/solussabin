<?php
//delete_cores.php
	session_start();
	$_SESSION['id_pddo_trtmto']=$_POST['id_pddo_trtmto'];
		
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
						<h4 class="modal-title">Impressao do Pedido de Tratamento</h4>
					</div>										
					<div class="modal-body">
						<div class="table-responsive">  
							<table class="table table-bordered">
								 <tr>  
									<td width="50%"><label>Id do Pedido:</label></td>  
									<td width="500%"><?php echo $_POST['id_pddo_trtmto']; ?></td>  
								 </tr>
								  <tr>  
									<td width="50%"><label>Nome do paciente:</label></td>  
									<td width="500%"><?php echo $_POST['nm_pcnt']; ?></td>  
								 </tr>								 
								 <tr>  
									<td width="50%"><label>Data de Realização:</label></td>  
									<td width="500%"><?php echo $_POST['dt_rlzd']; ?></td>  
								 </tr>
							</table>
						</div>
					</div>
					<div class="modal-footer">					
						<form class="form-inline" action="#" method="post" >
							<input type="submit" class="btn btn-danger" name="imprimirpdf" value="Imprimir PDF" onclick="window.open('../tcpdf/relatorio/impressao_pedidotratamento.php?id_pddo_trtmto=<?php echo $_POST['id_pddo_trtmto']; ?>');">&nbsp;&nbsp;&nbsp;&nbsp;
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
