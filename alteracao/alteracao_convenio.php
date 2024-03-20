<?php
//altera_cores.php
	session_start();
	$_SESSION['id_cnvo']=$_POST['id_cnvo'];
	
    include '../database.php';	
	
	$pdo = database::connect();

	$sql = "SELECT id_cnvo, cd_cnvo from tratamento.tb_c_cnvo where id_cnvo = '".$_POST['id_cnvo']."'";

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
						<h4 class="modal-title">Alteração de Convênios</h4>
					</div>								
					<form class="form-inline" method="post" >
						<div class="modal-body">
							<div class="table-responsive">  							
								<table class="table table-bordered">
									 <tr>  
										<td style="width:150px"><label>Id do Convênio:</label></td>  
										<td style="width:150px"><p class="form-control-static" name="id_cnvo"><?php echo $_POST['id_cnvo']; ?></p>
										</td>  
									 </tr>
									  <tr>  
										<td style="width:150px"><label>Código/Descrição do Convênio:</label></td>  
										<td style="width:400px"><input type="text" class="form-control" name="cd_cnvo" value="<?php echo $_POST['cd_cnvo']; ?>"></td> 							
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
