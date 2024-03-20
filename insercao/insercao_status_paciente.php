<?php
//insercao_usuario.php
	session_start();			
	
    include '../database.php';	
	
	$pdo = database::connect();
	$optconsulta = "";
	$textoconsulta = "";
	
	$sql = "SELECT id_status_pcnt, ds_status_pcnt, cd_cor_status_pcnt from tratamento.tb_c_status_pcnt  order by 1";
	
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
						<h4 class="modal-title">Inserção do Status do Paciente</h4>
					</div>								
					<form class="form-inline" method="post" >
						<div class="modal-body">
							<div class="table-responsive">  							
								<table class="table table-bordered">									 									  
									  <tr>  
										<td style="width:150px"><label>Descrição do Status do Paciente:</label></td>  
										<td style="width:200px"><input type="text" class="form-control" name="ds_status_pcnt"></td>  
									 </tr>
									<tr>  
										<td style="width:150px"><label>Flag Ativo?</label></td>
										<td style="width:150px">
											<select  class="form-control" id="flativo" onchange=" 
														var selObj = document.getElementById('flativo');
														var selValue = selObj.options[selObj.selectedIndex].value;
														document.getElementById('fl_ativo').value = selValue;">
													<option value="null"></option>
													<option value="1">Sim</option>
													<option value="0">Não</option>
											</select>
										</td>  
									 </tr>
									 <tr>  
										<td style="width:150px"><label>Cor no Painel:</label></td>  
										<td style="width:200px"><input type="text" class="form-control" name="cd_cor_status_pcnt"></td>  
									 </tr>	
								</table>																
							</div>								
							<div class="modal-footer">	
								<input type="submit" class="btn btn-danger" name="insere" value="Inserir">&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="submit" class="btn btn-primary" onclick="history.go()" value="Voltar">						
							</div>									
						</div>
						<input type="text" id="fl_ativo" name="fl_ativo" style="display:none" value="<?php echo $fl_ativo; ?>"> 
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