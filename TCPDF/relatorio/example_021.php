<?php


// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Hospital Vila Verde Saúde Mental');
$pdf->SetTitle('Relatório');
$pdf->SetSubject('Gestão de Leitos');
$pdf->SetKeywords('leito, gestão');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' Leitos', PDF_HEADER_STRING);

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

$pdf->SetDisplayMode('fullpage', 'SinglePage', 'UseNone');

// set font
$pdf->SetFont('times', 'B', 10);

$pdf->AddPage('L', 'A4');
// create some HTML content
// create some HTML content

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 9);

date_default_timezone_set('America/Sao_Paulo');
$html = ' 
		<h1>Relatório de Gestão de Leitos<h1>
		<h4>Hospital Vila Verde Saúde Mental - Data/Hora da Emissão: '. date("d/m/Y h:i:s").'<h4>	
		
        <table>					
			<tr>
				<th>Leito</th>
				<th>Andar</th>
				<th>Admissão</th>
				<th>Paciente</th>
				<th>Carater de Internação</th>		
				<th>Data de Nasc.</th>
				<th>Convênio</th>
				<th>Médico</th>
				<th>Psicólogo</th>
				<th>Terapeuta</th>
				<th>Grupo de CID</th>
				<th>Fumante</th>
				<th colspan="2" >Dieta/Consistência</th>
				<th>Prvs. de Alta</th>		
				<th>Retagd.</th>
				<th>Acomp.</th>
				<th>Status</th>						
			</tr>
			<hr>
			<tr >
				<td>Leito</td>									
				<td>Andar</td>	
				<td>Admissão</td>
				<td>Paciente</td>									
				<td>Carater de Internação</td>									
				<td>Data de Nasc.</td>
				<td>Convênio</td>									
				<td>Médico</td>									
				<td>Psicólogo</td>									
				<td>Terapeuta</td>									
				<td>Grupo de CID</td>									
				<td>Fumante</td>									
				<td>Dieta</td>									
				<td>Consistência</td>									
				<td>Prvs. de Alta</td>													
				<td>Retagd.</td>									
				<td>Acomp.</td>									
				<td>Status</td>	
				<td>Status</td>							
			</tr>			
			<tr >
				<td>Leito</td>									
				<td>Andar</td>	
				<td>Admissão</td>
				<td>Paciente</td>									
				<td>Carater de Internação</td>									
				<td>Data de Nasc.</td>
				<td>Convênio</td>									
				<td>Médico</td>									
				<td>Psicólogo</td>									
				<td>Terapeuta</td>									
				<td>Grupo de CID</td>									
				<td>Fumante</td>									
				<td>Dieta</td>									
				<td>Consistência</td>									
				<td>Prvs. de Alta</td>													
				<td>Retagd.</td>									
				<td>Acomp.</td>									
				<td>Status</td>	
				<td>Status</td>							
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
