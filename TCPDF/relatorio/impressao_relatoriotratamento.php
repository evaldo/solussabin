<?php

		session_start();
		
		include '../../database.php';
		$pdo = database::connect();
				
		
		$sql ="select * from tratamento.vw_painel_trtmto order by nm_pcnt ";			
		
		$ret = pg_query($pdo, $sql);
		
		if(!$ret) {
			echo pg_last_error($pdo);
			//header(Config::$webLogin);
			exit;
		}
		
	
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
$pdf->SetTitle('Acompanhamento de tratamento');
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
			<h2>Acompanhamento do Tratamento</h2>
			<h3>Data/Hora da Emissão: '. date("d/m/Y H:i:s"). '</h3>
			<hr>
        <table>					
			<tr>';			
				$sqlequipe ="select ds_equipe from tratamento.tb_c_equipe order by nu_seq_equipe_pnel asc";		
				$retequipe = pg_query($pdo, $sqlequipe);						
				if(!$retequipe) {
					echo pg_last_error($pdo);		
					exit;
				}				
				$html .= '<th style="text-align:center; font-weight: bold">ID</th>';
				$html .= '<th style="text-align:center; font-weight: bold">PACIENTE</th>';
			
				while($rowequipe = pg_fetch_row($retequipe)) {
			
					$html .= '<th style="text-align:center; font-weight: bold">'.strtoupper($rowequipe[0]).'</th>';
			
				
				} 
		$html .= '</tr> ';
		$html .= '<hr> ';
	
	$contalinha = 0;	
	while($row = pg_fetch_row($ret)) {
		
		$html .= ' 
			<tr>
				<td style="text-align:center">'.$row[0].'</td>				
				<td style="text-align:center">'.$row[1].'</td>
				<td style="text-align:center">'.$row[2].'</td>				
				<td style="text-align:center">'.$row[3].'</td>
				<td style="text-align:center">'.$row[4].'</td>
				<td style="text-align:center">'.$row[5].'</td>
				<td style="text-align:center">'.$row[6].'</td>
				<td style="text-align:center">'.$row[7].'</td>';
		$html .= '</tr>	';
		$html .= '<hr>  ';			
		$contalinha = $contalinha + 1;
			
	}
	$html .= '</table>';

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
