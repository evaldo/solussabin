<?php
//altera_cores.php
	session_start();
	$_SESSION['id_grupo_acesso']=$_POST['id_grupo_acesso'];
	
    include '../database.php';	
	
	$pdo = database::connect();

	$sql = "SELECT id_grupo_acesso, nm_grupo_acesso from tratamento.tb_c_grupo_acesso where id_grupo_acesso = '".$_POST['id_grupo_acesso']."'";

	if ($pdo==null){
			header(Config::$webLogin);
	}	
	$ret = pg_query($pdo, $sql);
	if(!$ret) {
		echo pg_last_error($pdo);
		exit;
	}
	
	$row = pg_fetch_row($ret);
		
	$codigo_cor_smart = $row[1];
	$codigo_html = $row[2];
	
	$sql = "SELECT id_grupo_acesso, nm_grupo_acesso from tratamento.tb_c_grupo_acesso order by 1";
	
	if ($pdo==null){
			header(Config::$webLogin);
	}	
    $ret = pg_query($pdo, $sql);
    if(!$ret) {
        echo pg_last_error($pdo);
        exit;
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
		<div class="container" style="width: 100%;  margin-right: 0; margin-left: 0; position: relative;">
		  <div class="modal-dialog">
				<div class="modal-content" style="width:800px">
					<div class="container">						
						<h4 class="modal-title">Alteração de Grupos de Usuários</h4>
					</div>								
					<form class="form-inline" method="post" >
						<div class="modal-body">
							<div class="table-responsive">  							
								<table class="table table-bordered">
									 <tr>  
										<td style="width:150px"><label>Id do Grupo de Usuário:</label></td>  
										<td style="width:150px"><p class="form-control-static" name="id_grupo_acesso"><?php echo $_POST['id_grupo_acesso']; ?></p>
										</td>  
									 </tr>
									  <tr>  
										<td style="width:150px"><label>Nome do Grupo de Usuário:</label></td>  
										<td style="width:400px"><input type="text" class="form-control" name="nm_grupo_acesso" value="<?php echo $_POST['nm_grupo_acesso']; ?>"></td> 							
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
