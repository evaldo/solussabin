<?php
//insercao_usuario.php
	session_start();			
	
    include '../database.php';	
	
	$pdo = database::connect();
	$optconsulta = "";
	$textoconsulta = "";
	
	$sql = "SELECT cd_usua_acesso, nm_usua_acesso, ds_usua_acesso, cd_faixa_ip_1, cd_faixa_ip_2, fl_acesso_ip from tratamento.tb_c_usua_acesso  order by 1";
	
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
						<h4 class="modal-title">Inserção de Usuários</h4>
					</div>								
					<form class="form-inline" method="post" >
						<div class="modal-body">
							<div class="table-responsive">  							
								<table class="table table-bordered">									 									  
									  <tr>  
										<td style="width:150px"><label>Nome do usuário:</label></td>  
										<td style="width:200px"><input type="text" class="form-control" name="nm_usua_acesso"></td>  
									 </tr>
									 <tr>  
										<td style="width:150px"><label>Usuário Administrador?</label></td>  
										<td style="width:200px"><input type="checkbox" class="form-control" name="fl_sist_admn"></td>  
									 </tr>
									 <tr>  
										<td style="width:150px"><label>Descrição do nome do usuário:</label></td>  
										<td style="width:200px"><input type="text" class="form-control" name="ds_usua_acesso"></td>  
									 </tr>
									 <tr>  
										<td style="width:150px"><label>Faixa de IP 1 permitida para acesso:</label></td>  
										<td style="width:200px"><input type="text" class="form-control" name="cd_faixa_ip_1"></td>  
									 </tr>
									 <tr>  
										<td style="width:150px"><label>Faixa de IP 2 permitida para acesso:</label></td>  
										<td style="width:200px"><input type="text" class="form-control" name="cd_faixa_ip_2"></td>  
									 </tr>
									 <tr>  
										<td style="width:150px"><label>Usuário pode acessar em qualquer rede de dados?</label></td>  
										<td style="width:200px"><input type="checkbox" class="form-control" name="fl_acesso_ip"></td>  
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
