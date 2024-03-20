<?php
//delete_cores.php
	session_start();
	$_SESSION['id_equipe']=$_POST['id_equipe'];
		
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
						<h4 class="modal-title">Exclusão de Equipes</h4>
					</div>										
					<div class="modal-body">
						<div class="table-responsive">  
							<table class="table table-bordered">
								 <tr>  
									<td width="50%"><label>Id da Equipe:</label></td>  
									<td width="500%"><?php echo $_POST['id_equipe']; ?></td>  
								 </tr>
								  <tr>  
									<td width="50%"><label>Descrição da Equipe:</label></td>  
									<td width="500%"><?php echo $_POST['ds_equipe']; ?></td>  
								 </tr>								 
								 <tr>  
									<td width="50%"><label>No. da Seq. da Equipe no Painel:</label></td>  
									<td width="500%"><?php echo $_POST['nu_seq_equipe_pnel']; ?></td>  
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
