<?php
//visualizacao_cores_risco.php
if(isset($_POST["id_equipe"]))
{
	session_start();
    
	$output = '';
    include '../database.php';
	
    $pdo = database::connect();
	
    $query = "SELECT id_equipe, ds_equipe, nu_seq_equipe_pnel from tratamento.tb_c_equipe where id_equipe = '".$_POST["id_equipe"]."'";
	
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
        <td width="30%"><label><b>Id da Equipe:</b></label></td>  
        <td width="200%">'.$row[0].'</td>  
     </tr>
     <tr>  
        <td width="30%"><label><b>Descrição da Equipe:</b></label></td>  
        <td width="200%">'.$row[1].'</td>  
      </tr>
	 <tr>  
        <td width="30%"><label><b>No. da Seq. da Equipe no Painel:</b></label></td>  
        <td width="200%">'.$row[2].'</td>  
      </tr>';
    $output .= '</table></div>';
    echo $output;
}
?>
