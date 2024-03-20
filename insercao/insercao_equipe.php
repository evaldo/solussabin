<?php
//insercao_usuario.php
	session_start();			
	
    include '../database.php';	
	
	$pdo = database::connect();
	$optconsulta = "";
	$textoconsulta = "";
	
	$sql = "SELECT id_equipe, ds_equipe, nu_seq_equipe_pnel from tratamento.tb_c_equipe  order by 1";
	
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
	</head>
	<body style="margin-right: 0; margin-left: 0">	
		<div class="container" style="width: 100%;  margin-right: 0; margin-left: 0; position: relative;">
		  <div class="modal-dialog">
				<div class="modal-content" style="width:800px">
					<div class="container">						
						<h4 class="modal-title">Inserção de Equipes</h4>
					</div>								
					<form class="form-inline" method="post" >
						<div class="modal-body">
							<div class="table-responsive">  							
								<table class="table table-bordered">									 									  
									  <tr>  
										<td style="width:150px"><label>Descrição da Equipe:</label></td>  
										<td style="width:200px"><input type="text" class="form-control" name="ds_equipe"></td>  
									 </tr>									 
									 <tr>  
										<td style="width:150px"><label>No. da Seq. da Equipe no Painel:</label></td>  
										<td style="width:200px"><input type="text" class="form-control" name="nu_seq_equipe_pnel"></td>  
									 </tr>	
								</table>																
							</div>								
							<div class="modal-footer">	
								<input type="submit" class="btn btn-danger" name="insere" value="Inserir">&nbsp;&nbsp;&nbsp;&nbsp;
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
