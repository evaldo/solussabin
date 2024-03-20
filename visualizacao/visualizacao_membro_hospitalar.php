<?php
//visualizacao_cores_risco.php
if(isset($_POST['id_memb_equip_hosptr']))
{
	session_start();
    
	$output = '';
    include '../database.php';
	
    $pdo = database::connect();
	
    $query = "SELECT id_memb_equip_hosptr
			 , nm_memb_equip_hosptr
			 , tp_memb_equip_hosptr
			 , case when tp_memb_equip_hosptr = 'MDCO' then
					'MEDICO'
			   else	case when tp_memb_equip_hosptr = 'PSCO' then
						'PSICÓLOGO'
					else case when tp_memb_equip_hosptr = 'TRPA' then 
							'TERAPEUTA'
						 else ''
			   end end end ds_memb_equip_hosptr
		from tratamento.tb_equip_hosptr 
		where id_memb_equip_hosptr = '".$_POST['id_memb_equip_hosptr']."'";
	
    $ret = pg_query($pdo, $query);
    if(!$ret) {
        echo pg_last_error($pdo);
        exit;
    }

    $output .= '  
      <div class="table-responsive">  
           <table class="table table-bordered">';
		   
    $row = pg_fetch_row($ret);
	
    $output .= '
     <tr>  
        <td width="30%"><label><b>Identificador do Membro da Equipe Hospitalar</b></label></td>  
        <td width="200%">'.$row[0].'</td>  
     </tr>
	 <tr>  
        <td width="30%"><label><b>Nome do Membro da Equipe Hospitalar</b></label></td>  
        <td width="200%">'.$row[1].'</td>  
     </tr>
	 <tr>  
        <td width="30%"><label><b>Tipo de Membro</b></label></td>  
        <td width="200%">'.$row[2].'</td>  
     </tr>
	 <tr>  
        <td width="30%"><label><b>Descrição do Tipo de Membro</b></label></td>  
        <td width="200%">'.$row[3].'</td>  
     </tr>  ';
    $output .= '</table></div>';
    echo $output;
}
?>
