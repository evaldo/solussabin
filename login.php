<?php	
	error_reporting(0);
	
	if (isset($_POST['acessar']))
	{	   		
	   
	   conexao();
	   
	}

	function conexao()
	{
		include 'conexao.php';
		
		$pdo = conexao::connect();			
		$user_ip = conexao::getUserIP();
		
		if ($pdo==null){
			header(Config::$webLogin);
		}	
		
		$sql="SELECT cd_faixa_ip_1, cd_faixa_ip_2, fl_acesso_ip, fl_sist_admn FROM tratamento.tb_c_usua_acesso where nm_usua_acesso = '" . $_SESSION['usuario'] . "'";
		
				
		$ret = pg_query($pdo, $sql);
		if(!$ret) {
			echo pg_last_error($pdo);
			exit;
		}	
		$row = pg_fetch_row($ret);
		$ip_1 = $row[0];	
		$ip_2 = $row[1];
		$fl_acesso_ip = $row[2];
		$_SESSION['fl_sist_admn'] = $row[3];
		
		//echo substr($user_ip, 0, 9);
		//echo substr($ip_1, 0, 9); 
		//echo substr($ip_2, 0, 9); 

		if ($fl_acesso_ip != 'S'){
			if (substr($user_ip, 0, 9)==substr($ip_1, 0, 9) or substr($user_ip, 0, 9)==substr($ip_2, 0, 9)){
				echo "<div class=\"alert alert-sucess alert-dismissible\">
						<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
						<strong>Sucesso!</strong>  Login realizado.</div>";


				$sql = "insert into tratamento.tb_c_log_acesso (id_log_acesso, cd_usua_acesso, nm_usua_acesso, dt_log_acesso) values ((select NEXTVAL('tratamento.sq_log_acesso')), (select cd_usua_acesso from tratamento.tb_c_usua_acesso where nm_usua_acesso = '". $_SESSION['usuario']."'), '". $_SESSION['usuario']."', current_timestamp)";

				$result = pg_query($pdo, $sql);

				if($result){
					echo "";
				} 

						
				$secondsWait = 5;
				header("Refresh:$secondsWait");
				header(Config::$webServer);				
				//echo "<a href=". Config::$webServer . "></a>";
				
			}else{
				echo "<div class=\"alert alert-warning alert-dismissible\">
						<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
						<strong>Atenção!</strong>  Tentativa de acesso negada. <?php echo $user_ip; echo $ip_2;?> Por favor, utilize uma rede de dados habilitada para consulta dos dados.</div>";
						
				$secondsWait = 5;
				header("Refresh:$secondsWait");	

			}
		}else{
			
			$sql = "insert into tratamento.tb_c_log_acesso (id_log_acesso, cd_usua_acesso, nm_usua_acesso, dt_log_acesso) values ((select NEXTVAL('tratamento.sq_log_acesso')), (select cd_usua_acesso from tratamento.tb_c_usua_acesso where nm_usua_acesso = '". $_SESSION['usuario']."'), '". $_SESSION['usuario']."', current_timestamp)";

			$result = pg_query($pdo, $sql);

			if($result){
				echo "";
			} 
			
			header(Config::$webServer);
		}
		
	}	
?>
	<!DOCTYPE html>
	<html>
	<head>
		<link rel="shortcut icon" href="./img/tratamento.ico" type="image/x-icon" />
		<meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>					
		<title>Acompanhamento de Tratamento</title>
	</head>
	<body style="background-color:white">						
		<br><br><br><br>
		<div class="container" style="width:50%; border:2px solid black;  border-radius:5px">
			<div align="center"><img src="./img/solussabin.jpg" style="width:45%;opacity:1;position:relative;"></div>
			<br>			
			<h4>Login</h4>
			<form  class="was-validated" method="post">
			  <div class="form-group">
				<label for="usuariolabel">Usuário:</label>
				<input type="text" class="form-control" id="usuario" placeholder="Entre com o usuário" name="usuario" required>
				<div class="valid-feedback">Validação.</div>
				<div class="invalid-feedback"><font color="black">Preencha totalmente este campo.</a></div>
			  </div>
			  <div class="form-group">
				<label for="senhalabel">Senha:</label>
				<input type="password" class="form-control" id="senha" placeholder="Entre com a senha" name="senha" required>
				<div class="valid-feedback">Validação.</div>
				<div class="invalid-feedback"><font color="black">Preencha totalmente este campo.</a></div>
			  </div>	
			  <hr>
			  <button type="submit" name="acessar" class="btn btn-primary">Acessar</button>
			  <br>
			  <br>
			</form>	
		</div>
	</body>	
</html>
<?php ?>
