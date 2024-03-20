<?php
//visualizacao_cores_risco.php
if(isset($_POST["codigo_usua"]))
{
	session_start();
    
	$output = '';
    include '../database.php';
	
    $pdo = database::connect();
	
    $query = "SELECT cd_usua_acesso, nm_usua_acesso, ds_usua_acesso, cd_faixa_ip_1, cd_faixa_ip_2, fl_acesso_ip, fl_sist_admn 
				from tratamento.tb_c_usua_acesso where cd_usua_acesso = '".$_POST["codigo_usua"]."'";
	
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
        <td width="30%"><label><b>Código Usuário:</b></label></td>  
        <td width="200%">'.$row[0].'</td>  
     </tr>
     <tr>  
        <td width="30%"><label><b>Nome do usuário:</b></label></td>  
        <td width="200%">'.$row[1].'</td>  
      </tr>
	  <tr>  
        <td width="30%"><label><b>Usuário Administrador?</b></label></td>  
        <td width="200%">'.$row[6].'</td>  
      </tr> 	  
	  <tr>  
        <td width="30%"><label><b>Descrição do nome do usuário:</b></label></td>  
        <td width="200%">'.$row[2].'</td>  
      </tr> 
	  <tr>  
        <td width="30%"><label><b>Faixa de IP 1 permitida para acesso:</b></label></td>  
        <td width="200%">'.$row[3].'</td>  
      </tr> 
	  <tr>  
        <td width="30%"><label><b>Faixa de IP 2 permitida para acesso:</b></label></td>  
        <td width="200%">'.$row[4].'</td>  
      </tr> 
	  <tr>  
        <td width="30%"><label><b>Usuário pode acessar em qualquer rede de dados?</b></label></td>  
        <td width="200%">'.$row[5].'</td>  
      </tr>';
    $output .= '</table></div>';
    echo $output;
}
?>
