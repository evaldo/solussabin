 <?php  
	
	session_start();
	
	include '../database.php';
	$pdo = database::connect();			
		
				
	$sql ="select * from tratamento.vw_painel_trtmto order by nm_pcnt";
			
	if ($pdo==null){
		header(Config::$webLogin);
	}	
	$ret = pg_query($pdo, $sql);
	if(!$ret) {
		echo pg_last_error($pdo);
		exit;
	}

	$arquivo = "paineldetratamento.xls";		
	$fp = fopen($arquivo, "w");
	
	//Admissões
	
	$html = '';
	$html .= '<!DOCTYPE html>';
	$html .= '<html lang="pt-br">';
	$html .= '<head>';
	$html .= '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
	$html .= '</head>';	
	$html .= '<body>';	
	$html .= '<table>';	
	$html .= '<tr>';
	$html .= '<td>Id</td>';
	$html .= '<td>Paciente</td>';
	$html .= '<td>Oncologistas</td>';		
	$html .= '<td>Autorização</td>';
	$html .= '<td>Nutrição</td>';
	$html .= '<td>Psicologia</td>';
	$html .= '<td>Farmácia</td>';
	$html .= '<td>Enfermagem</td>';			
	$html .= '<td>Obs Oncologistas</td>';		
	$html .= '<td>Obs Autorização</td>';
	$html .= '<td>Obs Nutrição</td>';
	$html .= '<td>Obs Psicologia</td>';
	$html .= '<td>Obs Farmácia</td>';
	$html .= '<td>Obs Enfermagem</td>';		
	$html .= '</tr>';
	
	while($row = pg_fetch_row($ret)) {				
		$html .= '<tr>';			
		$html .= '<td>'.$row[0].'</td>';
		$html .= '<td>'.$row[1].'</td>';
		$html .= '<td>'.$row[2].'</td>';
		$html .= '<td>'.$row[3].'</td>';
		$html .= '<td>'.$row[4].'</td>';
		$html .= '<td>'.$row[5].'</td>';
		$html .= '<td>'.$row[6].'</td>';
		$html .= '<td>'.$row[7].'</td>';
		$html .= '<td>'.$row[8].'</td>';
		$html .= '<td>'.$row[9].'</td>';
		$html .= '<td>'.$row[10].'</td>';
		$html .= '<td>'.$row[11].'</td>';
		$html .= '<td>'.$row[12].'</td>';
		$html .= '<td>'.$row[13].'</td>';			
		$html .= '<td> </td>';
		$html .= '<td> </td>';					
		$html .= '</tr>';
	}	
	
	$html .= '</table>';
	$html .= '</body>';	
	$html .= '</html>';
	
	fwrite($fp, $html);
	fclose($fp);
	
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<link href="../css/bootstrap.min.css" rel="stylesheet">
		<link href="../css/style.css" rel="stylesheet">		
	</head>
	<body style="margin-right: 0; margin-left: 0">	
		<div class="container" style="width: 70%;  margin-right: 0; margin-left: 0; position: relative;">
		  <div class="modal-dialog">
				<div class="modal-content" style="width:800px">
					<div class="container">						
						<h4 class="modal-title">Relatório no Formato de Excel do Painel de Tratamento</h4>
					</div>						
					<form class="form-inline" method="post" >
							<div class="modal-footer">										
								<a href="<?php echo $arquivo;?>">Download do Relatório</a>
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