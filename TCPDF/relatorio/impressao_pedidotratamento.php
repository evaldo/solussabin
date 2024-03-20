<?php

session_start();
		
include '../../database.php';
$pdo = database::connect();
				
if(isset($_GET['id_pddo_trtmto'])){
	
		$id_pddo_trtmto = $_GET['id_pddo_trtmto'];
		
		$sql ="SELECT id_pddo_trtmto
	            , id_hstr_pnel_solic_trtmto
				, cd_pcnt
				, nm_pcnt
				, to_char(dt_nasc_pcnt,'dd/mm/yyyy') as dt_nasc_pcnt
				, vl_idade_pcnt
				, nu_peso_pcnt
				, vl_altura_pcnt
				, vl_sup_corp
				, ds_indic_clnic
				, to_char(dt_diagn,'dd/mm/yyyy') as dt_diagn
				, cd_cid
				, ds_plano_trptco
				, ds_info_rlvnte
				, ds_diagn_cito_hstpagico
				, ds_tp_cirurgia
				, ds_area_irrda
				, to_char(dt_rlzd,'dd/mm/yyyy') as dt_rlzd
				, to_char(dt_aplc,'dd/mm/yyyy') as dt_aplc
				, ds_obs_jfta
				, nu_qtde_ciclo_prta
				, ds_ciclo_atual
				, ds_dia_ciclo_atual
				, ds_intrv_entre_ciclo_dia
				, ds_estmt
				, ds_tipo_linha_trtmto
				, ds_fnlde
				, ic_tipo_tumor
				, ic_tipo_nodulo
				, ic_tipo_metastase
				, cd_usua_incs
				, dt_incs
				, cd_usua_altr
				, dt_altr 
				, cd_cnvo
				, nm_mdco_encaminhador
				from tratamento.tb_pddo_trtmto
		where id_pddo_trtmto = ".$id_pddo_trtmto." ";			
		
		$ret = pg_query($pdo, $sql);
		
		if(!$ret) {
			echo pg_last_error($pdo);
			//header(Config::$webLogin);
			exit;
		}
		
		$row = pg_fetch_row($ret);
		
	
		require_once('tcpdf_include.php');
		class MYPDF extends TCPDF {

		//Page header
		public function Header() {
					
			$this->SetFont('helvetica', 'B', 20);
			
		}

		// Page footer
		public function Footer() {
			// Position at 15 mm from bottom
			$this->SetY(-15);
			// Set font
			$this->SetFont('helvetica', 'B', 8);
			// Page number
			$this->Cell(0, 10, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
		}
	}

	// create new PDF document
	$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

	// set document information
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('Solus Oncologia');
	$pdf->SetTitle('Pedido de tratamento');
	$pdf->SetSubject('Relatório em PDF');
	$pdf->SetKeywords('Tratamento');

	// set default header data
	$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

	// set header and footer fonts
	$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

	// set default monospaced font
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

	// set margins
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

	// set auto page breaks
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

	// set image scale factor
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

	// set some language-dependent strings (optional)
	if (@file_exists(dirname(__FILE__).'/lang/por.php')) {
		require_once(dirname(__FILE__).'/lang/por.php');
		$pdf->setLanguageArray($l);
	}

	// ---------------------------------------------------------

	$pdf->SetDisplayMode('fullpage', 'SinglePage', 'UseNone');

	// set font
	$pdf->SetFont('helvetica', 'N', 9);

	$pdf->AddPage('L', 'A4');

	date_default_timezone_set('America/Sao_Paulo');

		$html = ' 				
				<!DOCTYPE html>
				<html>
				<head>
					<style>		
					table {			
						width: 100%;
					}
					
					th {
						text-align: left;													
					}
					
					td {
						word-wrap: break-word;
						font-weight: normal;
					}

					</style>
				</head>
				<body>
					<img src="images/logosolus.jpg" border="0" height="80" width="80" ALIGN="left" HSPACE="50" VSPACE="50"/>
					<h2>Pedido de Tratamento</h2>
					<h3>Data/Hora da Emissão: '. date("d/m/Y H:i:s"). '</h3>
					<hr>
					<p><b>Nome do paciente:</b> '.$row[3].'&nbsp; </p>
					<p><b>Data de Nascimento: </b>'.$row[4].'</p>
					<p><b>Idade: </b>'.$row[5].'.</p>
					<p><b>Data do Diagn&oacute;stico: </b>'.$row[10].'. </p>
					<p><b>Convenio: </b>'.$row[34].'. </p>
					<p><b>CID 10 Principal: </b>'.$row[11].'</p>					
					<p><b>Nome do médico encaminhador: </b>'.$row[35].'</p>					
					<table style="border-collapse: collapse; width: 40%; height: 25px;" border="1">
						<tbody>
							<tr style="height: 18px;">
								<td style="width: 26.0762%; height: 18px; text-align: center;"><b>Peso (Kg)</b></td>
								<td style="width: 28.6423%; height: 18px; text-align: center;"><b>Altura(Cm)</b></td>
								<td style="width: 32.7815%; height: 18px; text-align: center;"><b>Sup.Corp(m2)</b></td>
							</tr>
							<tr style="height: 18px;">
								<td style="width: 26.0762%; height: 18px; text-align: center;">'.$row[6].'</td>
								<td style="width: 28.6423%; height: 18px; text-align: center;">'.$row[7].'</td>
								<td style="width: 32.7815%; height: 18px; text-align: center;">'.$row[8].'</td>
							</tr>
						</tbody>
					</table>
					
					<p>&nbsp;</p>

					<p><b>Indica&ccedil;&atilde;o Cl&iacute;nica:</b> '.htmlspecialchars($row[9], ENT_QUOTES).'&nbsp;</p>
					
					<table style="border-collapse: collapse; width: 80%; height: 68px;" border="1">
						<tbody>
							<tr>
								<td style="width: 16.6667%; text-align: center;"><b>Estadiamento</b></td>
								<td style="width: 26.2068%; text-align: center;"><b>Tipo Quimio. (Linha)</b></td>
								<td style="width: 10.0228%; text-align: center;"><b>Finalidade</b></td>
								<td style="width: 13.7706%; text-align: center;"><b>Tumor</b></td>
								<td style="width: 16.6667%; text-align: center;"><b>N&oacute;dulo</b></td>
								<td style="width: 16.6667%; text-align: center;"><b>Met&aacute;stase</b></td>
							</tr>
							<tr>
								<td style="width: 16.6667%; text-align: center;">'.$row[24].'</td>
								<td style="width: 26.2068%; text-align: center;">'.$row[25].'</td>
								<td style="width: 10.0228%; text-align: center;">'.$row[26].'</td>
								<td style="width: 13.7706%; text-align: center;">'.$row[27].'</td>
								<td style="width: 16.6667%; text-align: center;">'.$row[28].'</td>
								<td style="width: 16.6667%; text-align: center;">'.$row[29].'</td>
							</tr>
						</tbody>
					</table>
					
					<p>&nbsp;</p>

					
					<p><b>Plano Terap&ecirc;utico: </b>'.htmlspecialchars($row[12], ENT_QUOTES).'.</p>
					
					<p><b>Informa&ccedil;&otilde;es Relevantes: </b>'.htmlspecialchars($row[13], ENT_QUOTES).' .</p>
					
					<p><b>Diagn&oacute;stico Cito/Histopatol&oacute;gico:</b> '.htmlspecialchars($row[14], ENT_QUOTES).'.</p>
					
					<p><b>Cirurgia: </b>'.htmlspecialchars($row[15], ENT_QUOTES).'.</p>
					
					<p><b>&Aacute;rea Irradiada: </b>'.htmlspecialchars($row[16], ENT_QUOTES).'.</p>
					
					<p><b>Data da Realiza&ccedil;&atilde;o: </b>'.$row[17].' </p>
					
					<p><b>Data da Aplica&ccedil;&atilde;o: </b>'.$row[18].'</p>
					
					<p><b>Observa&ccedil;&atilde;o/Justificativa: </b>'.htmlspecialchars($row[19], ENT_QUOTES).' .</p>
					
					<table style="border-collapse: collapse; width: 70%;" border="1">
						<tbody>
							<tr>
								<td style="width: 25%; text-align: center;"><b>Qtde. Ciclos Previstos</b></td>
								<td style="width: 25%; text-align: center;"><b>Ciclo Atual</b></td>
								<td style="width: 25%; text-align: center;"><b>N&uacute;mero de dias do ciclo atual</b></td>
								<td style="width: 25%; text-align: center;"><b>Intervalo entre Ciclos (em dias)</b></td>
							</tr>
							<tr>
								<td style="width: 25%; text-align: center;">'.$row[20].'</td>
								<td style="width: 25%; text-align: center;">'.$row[21].'</td>
								<td style="width: 25%; text-align: center;">'.$row[22].'</td>
								<td style="width: 25%; text-align: center;">'.$row[23].'</td>
							</tr>
						</tbody>
					</table>			
				<p>&nbsp;</p>
			</body>
		</html>';

	$pdf->writeHTML($html, true, false, true, false, '');

	// reset pointer to the last page
	$pdf->lastPage();

	// ---------------------------------------------------------
	ob_end_clean();
	//Close and output PDF document
	$pdf->Output('relatoriotratamento.pdf', 'I');

	//============================================================+
	// END OF FILE
	//============================================================+
}
?>