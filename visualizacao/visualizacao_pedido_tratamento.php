<?php
//visualizacao_cores_risco.php
	session_start();
    
	$output = '';
    include '../database.php';
	
    $pdo = database::connect();
	
    $query = "SELECT id_pddo_trtmto
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
				, ic_crioterapia
				, ds_exame_enviado
				from tratamento.tb_pddo_trtmto
	where id_pddo_trtmto = ".$_POST['id_pddo_trtmto']."  ";
	
    $ret = pg_query($pdo, $query);
    if(!$ret) {
        echo pg_last_error($pdo);
        exit;
    }
	   
    $row = pg_fetch_row($ret);
	
    $output = ' <div class="table-responsive">  
					<p><b>Nome do paciente:</b> '.$row[3].'&nbsp; </p>
					<p><b>Data de Nascimento: </b>'.$row[4].'</p>
					<p><b>Convenio: </b>'.$row[34].'. </p>
					<p><b>Idade: </b>'.$row[5].'.</p>
					<p><b>Data do Diagn&oacute;stico: </b>'.$row[10].'. </p>
					<p><b>CID 10 Principal: </b>'.$row[11].'</p>
					<p><b>Nome do médico encaminhador: </b>'.$row[35].'</p>					
					<table style="border-collapse: collapse; width: 58.8694%; height: 25px;" border="1">
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

					<p><b>Indica&ccedil;&atilde;o Cl&iacute;nica:</b> '.$row[9].'&nbsp;</p>
					
					<table style="border-collapse: collapse; width: 118.548%; height: 68px;" border="1">
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


					<p><b>Plano Terap&ecirc;utico: </b>'.$row[12].'.</p>
					
					<p><b>Informa&ccedil;&otilde;es Relevantes: </b>'.$row[13].' .</p>
					
					<p><b>Diagn&oacute;stico Cito/Histopatol&oacute;gico:</b> '.$row[14].'.</p>
					
					<p><b>Cirurgia: </b>'.$row[15].'.</p>
					
					<p><b>&Aacute;rea Irradiada: </b>'.$row[16].'.</p>
					
					<p><b>Data da Realiza&ccedil;&atilde;o: </b>'.$row[17].' </p>
					
					<p><b>Data da Aplica&ccedil;&atilde;o: </b>'.$row[18].'</p>
					
					<p><b>Crioterapia: </b>'.$row[36].' .</p>
					
					<p><b>Observa&ccedil;&atilde;o/Justificativa: </b>'.$row[19].' .</p>
					
					<table style="border-collapse: collapse; width: 100%;" border="1">
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
					
					<p><b>Exames enviados: </b>'.$row[37].' .</p>
					
					<p>&nbsp;</p>';
					
    $output .= '</div>';
    echo $output;

?>
