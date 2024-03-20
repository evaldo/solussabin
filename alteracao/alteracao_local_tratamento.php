<?php
//altera_cores.php
	session_start();
	$_SESSION['id_local_trtmto']=$_POST['id_local_trtmto'];
	
    include '../database.php';	
	
	$pdo = database::connect();

	$sql = "SELECT id_local_trtmto, ds_local_trtmto, nu_seq_local_pnel from tratamento.tb_c_local_trtmto where id_local_trtmto = '".$_POST['id_local_trtmto']."'";

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
						<h4 class="modal-title">Alteração do Local de Tratamento</h4>
					</div>								
					<form class="form-inline" method="post" >
						<div class="modal-body">
							<div class="table-responsive">  							
								<table class="table table-bordered">
									 <tr>  
										<td style="width:150px"><label>Id do Local de Tratamento:</label></td>  
										<td style="width:150px"><p class="form-control-static" name="id_local_trtmto"><?php echo $_POST['id_local_trtmto']; ?></p>
										</td>  
									 </tr>
									  <tr>  
										<td style="width:150px"><label>Descrição do Local de Tratamento:</label></td>  
										<td style="width:400px"><input type="text" class="form-control" name="ds_local_trtmto" value="<?php echo $_POST['ds_local_trtmto']; ?>"></td> 							
									  </tr>	

									  <tr>  
										<td style="width:150px"><label>Número da Seq. Local de Tratamento no Painel:</label></td>  
										<td style="width:400px"><input type="text" class="form-control" name="nu_seq_local_pnel" value="<?php echo $_POST['nu_seq_local_pnel']; ?>"></td> 							
									  </tr>	
									  
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
