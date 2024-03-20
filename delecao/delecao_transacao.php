<?php
//delete_cores.php
	session_start();
	$_SESSION['id_acesso_transac_tratamento']=$_POST['id_acesso_transac_tratamento'];
		
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
						<h4 class="modal-title">Exclusão das Transações</h4>
					</div>										
					<div class="modal-body">
						<div class="table-responsive">  
							<table class="table table-bordered">
								 <tr>  
									<td width="50%"><label>Identificação da Transação:</label></td>  
									<td width="500%"><?php echo $_POST['id_acesso_transac_tratamento']; ?></td>  
								 </tr>
								 <tr>  
									<td width="50%"><label>Nome do Menu/Funcionalidade:</label></td>  
									<td width="500%"><?php echo $_POST['nm_menu_sist_tratamento']; ?></td>  
								 </tr>								 
								 <tr>  
									<td width="50%"><label>Nome da Transação:</label></td>  
									<td width="500%"><?php echo $_POST['nm_acesso_transac_tratamento']; ?></td>  
								 </tr>
								 <tr>  
									<td width="50%"><label>Código da Transação:</label></td>  
									<td width="500%"><?php echo $_POST['cd_transac_tratamento']; ?></td>  
								 </tr>
								 <tr>  
									<td width="50%"><label>Cód da Func/Menu no Integração:</label></td>  
									<td width="500%"><?php echo $_POST['cd_form_transac_tratamento']; ?></td>  
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
