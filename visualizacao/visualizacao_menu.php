<?php
//visualizacao_cores_risco.php
if(isset($_POST['id_menu_sist_tratamento']))
{
	session_start();
    
	$output = '';
    include '../database.php';
	
    $pdo = database::connect();
	
    $query = "select menu.id_menu_sist_tratamento
			 , menu.nm_menu_sist_tratamento
			 , menu.fl_menu_princ
			 , (select nm_menu_sist_tratamento
				from tratamento.tb_c_menu_sist_tratamento
			   where id_menu_sist_tratamento = menu.id_menu_supr)
			 , menu.nm_objt
			 , menu.nm_link_objt
			 from tratamento.tb_c_menu_sist_tratamento menu
				where menu.id_menu_sist_tratamento = ".$_POST["id_menu_sist_tratamento"]." ";
	
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
        <td width="30%"><label><b>Identificador do Menu:</b></label></td>  
        <td width="200%">'.$row[0].'</td>  
     </tr>
	 <tr>  
        <td width="30%"><label><b>Nome do menu:</b></label></td>  
        <td width="200%">'.$row[1].'</td>  
     </tr>
	 <tr>  
        <td width="30%"><label><b>Menu Principal?</b></label></td>  
        <td width="200%">'.$row[2].'</td>  
     </tr>
	 <tr>  
        <td width="30%"><label><b>Menu Superior:</b></label></td>  
        <td width="200%">'.$row[3].'</td>  
     </tr>
     <tr>  
        <td width="30%"><label><b>Nome do objeto na aplicação:</b></label></td>  
        <td width="200%">'.$row[4].'</td>  
      </tr>
	 <tr>  
        <td width="30%"><label><b>Nome do link do objeto:</b></label></td>  
        <td width="200%">'.$row[5].'</td>  
     </tr>	  ';
    $output .= '</table></div>';
    echo $output;
}
?>
