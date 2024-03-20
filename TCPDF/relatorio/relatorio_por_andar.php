<?php

require_once('tcpdf_include.php');
class MYPDF extends TCPDF {

	//Page header
	public function Header() {
		// Logo
		$image_file = K_PATH_IMAGES.'logo_vilaverde.png';
		$this->Image($image_file, 15, 5, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		// Set font
		$this->SetFont('helvetica', 'B', 20);
		// Title
		$this->Cell(0, 30, 'Relatório de Gestão de Leitos', 0, false, 'C', 0, '', 0, false, 'M', 'M');
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
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 003');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

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
$pdf->SetFont('times', 'B', 10);

$pdf->AddPage('L', 'A4');

date_default_timezone_set('America/Sao_Paulo');

$html = ' 				
		<h4>Data/Hora da Emissão: '. date("d/m/Y h:i:s").'<h4>
        <table>					
			<tr>
				<th>Leito</th>				
				<th>Admissão</th>
				<th>Paciente</th>				
				<th>Data de Nasc.</th>
				<th>Convênio</th>
				<th>Médico</th>
				<th>Psicólogo</th>
				<th>Terapeuta</th>
				<th>Grupo de CID</th>
				<th>Fumante</th>
				<th>Prvs. de Alta</th>					
				<th>Retagd.</th>
				<th>Acomp.</th>
				<th>Ocorrências</th>						
			</tr>
			<hr>
			<tr >
				<td>Leito</td>				
				<td>Admissão</td>
				<td>Paciente</td>				
				<td>Data de Nasc.</td>
				<td>Convênio</td>
				<td>Médico</td>
				<td>Psicólogo</td>
				<td>Terapeuta</td>
				<td>Grupo de CID</td>
				<td>Fumante</td>
				<td>Prvs. de Alta</td>					
				<td>Retagd.</td>
				<td>Acomp.</td>
				<td>Ocorrências</td>							
			</tr>						
		</table>';

// output the HTML content
$pdf->writeHTML($html, true, 0, true, 0);

// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('gestao_leitos.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
