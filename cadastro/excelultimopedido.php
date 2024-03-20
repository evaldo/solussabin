 <?php  
	
	session_start();
	
	error_reporting(0); 
	
	$arquivo = "ultimopedidodigitado.xls";		
	$fp = fopen($arquivo, "w");
	
	$html = '';
	$html .= '<!DOCTYPE html>';
	$html .= '<html lang="pt-br">';
	$html .= '<head>';
	$html .= '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
	$html .= '</head>';	
	$html .= '<body>';	
	$html .= '<table>';	
	$html .= '<tr>';
	$html .= "<td>Codigo Paciente: ".$_SESSION['cd_pcnt']."</td>";
	$html .= '</tr>';
	$html .= '<tr>';
	$html .= "<td>Usuário que incluiu: ".$_SESSION['usuario']."</td>";
	$html .= '<tr>';
	$html .= "<td>Convênio: ".$_SESSION['cd_cnvo']."</td>";
	$html .= '</tr>';
	$html .= '<tr>';
	$html .= "<td>Peso: ".$_SESSION['nu_peso_pcnt']."</td>";
	$html .= '</tr>';
	$html .= '<tr>';
	$html .= "<td>Altura: ".$_SESSION['vl_altura_pcnt']."</td>";
	$html .= '</tr>';
	$html .= '<tr>';
	$html .= "<td>Sup Corp: ".$_SESSION['vl_sup_corp']."</td>";
	$html .= '</tr>';
	$html .= '<tr>';
	$html .= "<td>Indicacao Clinica: ".$_SESSION['ds_indic_clnic']."</td>";
	$html .= '</tr>';
	$html .= '<tr>';
	$html .= "<td>Data do Diagnostico: ".$_SESSION['dt_diagn']."</td>";
	$html .= '</tr>';
	$html .= '<tr>';
	$html .= "<td>CID: ".$_SESSION['cd_cid']."</td>";
	$html .= '</tr>';
	$html .= '<tr>';
	$html .= "<td>Estadiamento: ".$_SESSION['ds_estmt']."</td>";
	$html .= '</tr>';
	$html .= '<tr>';
	$html .= "<td>Tipo Quimio (Linha): ".$_SESSION['ds_tipo_linha_trtmto']."</td>";
	$html .= '</tr>';
	$html .= '<tr>';
	$html .= "<td>Finalidade: ".$_SESSION['ds_fnlde']."</td>";
	$html .= '</tr>';
	$html .= '<tr>';
	$html .= "<td>Tipo de Tumor: ".$_SESSION['ic_tipo_tumor']."</td>";
	$html .= '</tr>';
	$html .= '<tr>';
	$html .= "<td>Tipo de Nodulo: ".$_SESSION['ic_tipo_nodulo']."</td>";
	$html .= '</tr>';
	$html .= '<tr>';
	$html .= "<td>Tipo de Metastase: ".$_SESSION['ic_tipo_metastase']."</td>";
	$html .= '</tr>';
	$html .= '<tr>';
	$html .= "<td>Plano Terapêutio: ".$_SESSION['ds_plano_trptco']."</td>";
	$html .= '</tr>';
	$html .= '<tr>';
	$html .= "<td>Informações Relevantes: ".$_SESSION['ds_info_rlvnte']."</td>";
	$html .= '</tr>';
	$html .= '<tr>';
	$html .= "<td>Diagnóstico Histopatologico: ".$_SESSION['ds_diagn_cito_hstpagico']."</td>";
	$html .= '</tr>';
	$html .= '<tr>';
	$html .= "<td>Tipo de Cirurgia: ".$_SESSION['ds_tp_cirurgia']."</td>";
	$html .= '</tr>';
	$html .= '<tr>';
	$html .= "<td>Área Irradiada: ".$_SESSION['ds_area_irrda']."</td>";
	$html .= '</tr>';
	$html .= '<tr>';
	$html .= "<td>Data de Realização: ".$_SESSION['dt_rlzd']."</td>";
	$html .= '</tr>';
	$html .= '<tr>';
	$html .= "<td>Data da Aplicação: ".$_SESSION['dt_aplc']."</td>";
	$html .= '</tr>';
	$html .= '<tr>';
	$html .= "<td>Observação Justificativa: ".$_SESSION['ds_obs_jfta']."</td>";
	$html .= '</tr>';
	$html .= '<tr>';
	$html .= "<td>Quantidade de Ciclos Prevsitos: ".$_SESSION['nu_qtde_ciclo_prta']."</td>";
	$html .= '</tr>';
	$html .= '<tr>';
	$html .= "<td>Ciclo Atual: ".$_SESSION['ds_ciclo_atual']."</td>";
	$html .= '</tr>';
	$html .= '<tr>';
	$html .= "<td>Dias do ciclo atual: ".$_SESSION['ds_dia_ciclo_atual']."</td>";			
	$html .= '</tr>';
	$html .= '<tr>';
	$html .= "<td>Intervalo de Ciclos: ".$_SESSION['ds_intrv_entre_ciclo_dia']."</td>";			
	$html .= '</tr>';
	
	
	
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
						<h4 class="modal-title">Relatório no Formato de Excel do Último Pedido Inserido</h4>
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