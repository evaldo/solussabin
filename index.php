<?php	
	
	session_start();
	
	include 'database.php';
	
	$pdo = database::connect();	
	$sql="";
	$menu_princ_anterior="";
	$fl_sist_admn="";
	
	$sql = "SELECT fl_sist_admn from tratamento.tb_c_usua_acesso where nm_usua_acesso = '".$_SESSION['usuario']."'";
	
	try {
		if ($pdo==null){
			header(Config::$webLogin);
		}			
		$ret_usua = pg_query($pdo, $sql);	
		$ret_usua_row = pg_fetch_row($ret_usua);
		if ($ret_usua_row[0]=="S"){
			$fl_sist_admn="S";			
			$sql = "SELECT * from tratamento.vw_menu_princ_tratamento order by nu_pcao_menu, menu_principal asc ";			
			$ret_menu_princ = pg_query($pdo, $sql);	
		}else{
			$fl_sist_admn="N";			
			$sql = "SELECT distinct * from tratamento.vw_menu_princ_usua where nm_usua_acesso = '".$_SESSION['usuario']."' order by nu_pcao_menu, menu_principal asc ";			
			$ret_menu_princ = pg_query($pdo, $sql);	
		}					
	} catch (PDOException $e) {
		$this->status = "Falha ao tentar conectar: \n" . $e->getMessage();
	}
	
?>
	<!DOCTYPE html>
	<html>
	<head>
		<link rel="shortcut icon" href="./img/tratamento.ico" type="image/x-icon" />
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">		
		<link rel="stylesheet" href="./css/font-awesome.min.css">
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">   
		<script src="http://metabase.example.com/app/iframeResizer.js"></script>					
		<script>		
			
			var v_iframeselecionado = "";
			var iframes;
			var i=0;
		
			iframes=['dadosassistenciais', 'painelleitos', 'historicoleito'] 
		
			function reloadScrollBars() {
				document.documentElement.style.overflow = 'auto';  // firefox, chrome			
			}

			function unloadScrollBars() {
				document.documentElement.style.overflow = 'hidden';  // firefox, chrome			
			}
		
			function iframeSelecionado(p_iframeselecionado){
				v_iframeselecionado = p_iframeselecionado;		
			}	
			
			$(document).ready(function(){
			$("#ler-pagina").click(function(){             
					$(function(){
						$("#conteudo-pagina-lida").load("google.com"); 
					});
				})
			});
			
			function loading() {
			  var x = document.getElementById("loading");
			  if (x.style.display === "none") {
				x.style.display = "block";
			  } else {
				x.style.display = "none";
			  }
			}			
					
			
			function prepareIframe(p_iframeselecionado, p_url) {			
				
				var div = document.createElement("div");
				var ifrm = document.createElement("iframe");
							
				div.setAttribute("class", "iframe-container");
				div.setAttribute("id", "usado_para_frame");
				
				ifrm.setAttribute("src", p_url);
				//ifrm.style.width = "1348px";
				//ifrm.style.height= "4100px";
				//ifrm.setAttribute("onLoad", "iFrameResize({}, this)");
				ifrm.setAttribute("name", p_iframeselecionado);		
				//ifrm.setAttribute("frameborder", "0");
				//ifrm.setAttribute("scrolling", "no");						
				ifrm.allowFullScreen = true;
				
				div.appendChild(ifrm);
				
				document.body.appendChild(div);
				
				var div = document.querySelectorAll('div');
				for (var i = 0; i < div.length; i++) {
					if (div[i].id == "divinforma1"){
						div[i].parentNode.removeChild(div[i]);
					}
					if (div[i].id == "divinforma2"){
						div[i].parentNode.removeChild(div[i]);
					}								
				}
				
				var br = document.querySelectorAll('br');
				for (var i = 0; i < div.length; i++) {
					if (br[i].id == "br1"){
						br[i].parentNode.removeChild(br[i]);
					}
					if (br[i].id == "br2"){
						br[i].parentNode.removeChild(br[i]);
					}
				}		
				
			}
		
			function removeIframe() {
				
				var div = document.querySelectorAll('div');
				for (var i = 0; i < div.length; i++) {
					if (div[i].id == "usado_para_frame"){
						div[i].parentNode.removeChild(div[i]);
					}
				}
				
				var iframes = document.querySelectorAll('iframe');
				for (var i = 0; i < iframes.length; i++) {
					iframes[i].parentNode.removeChild(iframes[i]);
				}			
			}

			function fuTopNav() {
			  var x = document.getElementById("topnav");
			  if (x.className === "topnav") {
				x.className += " responsive";
			  } else {
				x.className = "topnav";
			  }		  
			}

			function recarregar(){
				document.location.reload(true);
			}
			
	</script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>

	<script type="text/javascript">
		var auto_refresh = setInterval(
				function ()
					{
						$('#alerta').load('./alerta/alerta_transacao_crud.php?tipoconsultaalerta=telaprincipal').fadeIn("slow");
					}
					, 1000
				); 
					//refresh every 1000 milliseconds
	</script>
	
	<style>
			
			 textarea {
				float: right;
				margin-left: 10px;
			  }
			
			.loader {			  
			  border: 16px solid #f3f3f3;
			  border-radius: 50%;
			  border-top: 16px solid blue;
			  border-right: 16px solid gray;
			  border-bottom: 16px solid red;
			  border-left: 16px solid pink;
			  width: 120px;
			  height: 120px;
			  margin-left:580px; 
			  margin-top:100px;
			  -webkit-animation: spin 2s linear infinite;
			  animation: spin 2s linear infinite;
			}
			
			/* Safari */
			@-webkit-keyframes spin {
			  0% { -webkit-transform: rotate(0deg); }
			  100% { -webkit-transform: rotate(360deg); }
			}

			@keyframes spin {
			  0% { transform: rotate(0deg); }
			  100% { transform: rotate(360deg); }
			}
			
			
			ul {
				list-style-type: none;
				margin: 0;
				padding: 0;
				overflow: hidden;
				background-color: gray;
				<!--border: 1px solid green;-->
			}

			li {
				float: left;
			}

			li a {
				display: block;
				color: black;
				text-align: center;
				padding: 14px 16px;
				text-decoration: none;
			}

			li a:hover:not(.active) {
				background-color: gray;
			}

			.active {
				background-color: gray;
			}

			li a, .dropbtn {
				display: inline-block;
				color: black;
				text-align: center;
				padding: 14px 16px;
				text-decoration: none;
			}

			li a:hover, .dropdown:hover .dropbtn {
				background-color: gray;
			}

			li.dropdown {
				display: inline-block;
			}		

			#iframe {
				display: none;
			}
			body {
			  margin: 0;
			  font-family: Arial, Helvetica, sans-serif;
			}

			body {margin:0;font-family:Helvetica}

			.topnav {
				background-color: DarkSlateGray;
				overflow: hidden; 	
				font-size: 17px;	
			}

			.topnav a {						  
			  float: left;
			  color: #f2f2f2;
			  text-align: center;
			  padding: 18px 18px;
			  text-decoration: none;
			  font-size: 17px;			  
			}

			.active {
			  background-color: black;
			  color: black;
			}

			.topnav .icon {
			  display: none;
			}

			.dropdown {
			  float: left;
			  overflow: hidden;
			}
			
			.dropdown .dropbtn {
			  font-size: 17px;    
			  border: none;
			  outline: none;
			  color: white;
			  padding: 18px 18px;
			  background-color: inherit;
			  font-family: inherit;			  
			  margin: 0;
			}

			.dropdown-content {
			  display: none;
			  position: absolute;
			  background-color: #f9f9f9;
			  min-width: 160px;
			  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
			  z-index: 1;
			}

			.dropdown-content a {
			  float: none;
			  color: black;
			  padding: 10px 16px;
			  text-decoration: none;
			  display: block;
			  text-align: left;
			}

			.topnav a:hover, .dropdown:hover .dropbtn {
			  background-color: orange;
			  color: black;
			}

			.dropdown-content a:hover {
			  background-color: orange;
			  color: black;
			}

			.dropdown:hover .dropdown-content {
			  display: block;
			}

			@media screen and (max-width: 600px) {
			  .topnav a:not(:first-child), .dropdown .dropbtn {
				display: none;
			  }
			  .topnav a.icon {
				float: right;
				display: block;
			  }
			}

			@media screen and (max-width: 600px) {
			  .topnav.responsive {position: relative;}
			  .topnav.responsive .icon {
				position: absolute;
				right: 0;
				top: 0;
			  }
			  .topnav.responsive a {
				float: none;
				display: block;
				text-align: left;
			  }
			  .topnav.responsive .dropdown {float: none;}
			  .topnav.responsive .dropdown-content {position: relative;}
			  .topnav.responsive .dropdown .dropbtn {
				display: block;
				width: 100%;
				text-align: left;
			  }
			}
			.icon-bar {
			  width: 90px;
			  background-color: gray;
			}

			.icon-bar a {
			  display: block;
			  text-align: center;
			  padding: 16px;
			  transition: all 0.3s ease;
			  color: black;
			  font-size: 36px;
			}

			.icon-bar a:hover {
			  background-color: gray;
			}

			.active {
			  background-color: gray;
			}
			
			.container {
			  position: relative;
			  text-align: center;
			  color: black;
			  background-color:white;
			}					

			/* Bottom left text */
			.bottom-left {
			  position: absolute;
			  bottom: 8px;
			  left: 16px;
			}

			/* Top left text */
			.top-left {
			  position: absolute;
			  top: 8px;
			  left: 16px;
			}

			/* Top right text */
			.top-right {
			  position: absolute;
			  top: 8px;
			  right: 16px;
			}

			/* Bottom right text */
			.bottom-right {
			  position: absolute;
			  bottom: 8px;
			  right: 16px;
			}

			/* Centered text */
			.centered {
			  position: absolute;
			  top: 50%;
			  left: 50%;
			  transform: translate(-50%, -50%);
			  font-size: 36px;
			}
			
			.resp-container {
				position: relative;
				overflow: hidden;
				padding-top: 150%;
			}
			
			.resp-iframe-1 {
				 position: relative;
				 padding-bottom: 65.25%;
				 padding-top: 30px;
				 height: 0;
				 overflow: auto; 
				 -webkit-overflow-scrolling:touch;  
				 border: solid black 1px;
			} 
			.resp-iframe-1 iframe {
				 position: absolute;
				 top: 0;
				 left: 0;
				 width: 100%;
				 height: 100%;
			}
			
			.resp-iframe {
				position: absolute;
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
				border: 0;
			}
			#divbox {
			  background-color: gray ;
			  padding: 5px ;
			  border: 0px solid gray ;
			  left: 5;
			  width: 80%;
			  margin-left:100px; 
			}
			.column {
			  float: left;
			  width: 50%;
			}

			/* Clear floats after the columns */
			.row:after {
			  content: "";
			  display: table;
			  clear: both;
			}
			.padding-0{
				padding-right:2.5%;
				padding-left:2.5%;
				padding-top:2.5%;
				padding-bottom:2.5%;
			}

			.divinformaapp{
				margin-left:50px;
				margin-right:50px;
				padding:1rem 1rem;
				margin-bottom:2rem;
				background-color:#343a40!important;
				border-radius:.3rem;
				font-size:1.0rem;
				font-weight:300;
				line-height:1.2;
				color:#fff!important;
				border-radius:.25rem!important;
				padding:1rem!important;
				padding:3rem!important;
			}
			
			.pinformaapp{
				font-style:italic!important;
				font-family:Candara;
			}
			
			.pinformaapp-1{
				font-size:1.25rem;
				font-weight:300;
				margin-bottom:1rem!important;
				font-family:Candara;
			}
			
			.pinformaapp-2{
				font-weight:700!important;
				color:#fff!important;
			}
			.card{
				margin-left:50px;
				margin-right:50px;
				position:relative;
				display:-ms-flexbox;
				display:flex;
				-ms-flex-direction:column;
				flex-direction:column;
				min-width:0;
				word-wrap:break-word;
				background-color:#fff;
				background-clip:border-box;
				border:1px solid rgba(0,0,0,.125);
				border-radius:.25rem;
			}
			.card-title{
				margin-bottom:.75rem;
			}
			.card-subtitle{
				margin-top:-.375rem;
				margin-bottom:0;
			}
			.card-text:last-child{
				margin-bottom:0;	
			}
			.card-link:hover{
				text-decoration:none;
			}
			.card-link+
			
			.card-link{
				margin-left:1.25rem;
			}
			.card-header{
				padding:.75rem 1.25rem;
				margin-bottom:0;
				background-color:rgba(0,0,0,.03);
				border-bottom:1px solid rgba(0,0,0,.125);
			}
			.card-body{
				-ms-flex:1 1 auto;
				flex:1 1 auto;
				min-height:1px;
				padding:1.25rem;
			}
			.card-columns 
				.card{
					margin-bottom:.75rem;					
				}
				@media (min-width:576px){
					.card-columns{
						-webkit-column-count:3;
						-moz-column-count:3;
						column-count:3;
						-webkit-column-gap:1.25rem;
						-moz-column-gap:1.25rem;
						column-gap:1.25rem;
						orphans:1;
						widows:1;
						margin-right:100px;
					}
					.card-columns 
					.card{
						display:inline-block;
						width:100%;						
					}
				}
				
				.iframe-container {
				  overflow: hidden;				  
				  padding-top: 150%;
				  position: relative;
				  height: 150%;
				}
				 
				.iframe-container iframe {
				   border: 0;
				   height: 100%;
				   left: 0;
				   position: absolute;
				   top: 0;
				   width: 100%;
				}	
				
				.footer {
				   position: fixed;
				   left: 0;
				   bottom: 0;
				   width: 100%;
				   background-color: #333;
				   color: white;
				   text-align: right;
				}
				.notification {
				  background-color: #555;
				  color: white;
				  text-decoration: none;
				  padding: 15px 26px;
				  position: relative;
				  display: inline-block;
				  border-radius: 2px;
				}

				.notification:hover {
				  background: red;
				}

				.notification .badge {
				  position: absolute;
				  top: 0px;
				  right: -10px;
				  padding: 5px 10px;
				  border-radius: 50%;
				  background-color: red;
				  color: white;
				}				  
			
	</style>
		<title>Acompanhamento do Tratamento</title>
	</head>
	<body  bgcolor="MediumSeaGreen" id="bd">		
		<div class="container" id="divcabec">			
			<div class="left">
				<img src="./img/solussabin.jpg" style="width:15%;opacity:1" onclick="recarregar()">
			</div>					  		  
		</div>
		<div class="topnav" id="topnav">		
			<a class="active" href="#" onclick="recarregar()"><i class="fa fa-home" aria-hidden="true"></i></a> 
			<a href="#" class="notification" onclick="removeIframe();prepareIframe('manutalerta', './alerta/manut_alerta.php?tipoconsultaalerta=consultaregsnaolidos');"><span class="badge" id="alerta"></span><i class="fa fa-bell" aria-hidden="true"></i>
			</a>			
			<?php
			
				while($row_menu_princ = pg_fetch_row($ret_menu_princ)) {	
					
					if ($row_menu_princ[0]!=$menu_princ_anterior){				
						$menu_princ_anterior = $row_menu_princ[0];									
					
						if ($row_menu_princ[6]>'0'){
			
							$pdo = database::connect();					
							$sql="";
							
							if ($fl_sist_admn=="S"){
								$sql = "SELECT distinct * from tratamento.vw_menu_princ_tratamento where menu_principal = '" .$row_menu_princ[0]."' order by nu_pcao_menu, sub_menu asc" ;
							} else {
								$sql = "SELECT distinct * from tratamento.vw_menu_princ_usua where nm_usua_acesso = '".$_SESSION['usuario']."' and menu_principal='" .$row_menu_princ[0]."' order by nu_pcao_menu, menu_principal asc ";								
							}
							
							$ret_submenu = pg_query($pdo, $sql);
							if(!$ret_submenu) {
								pg_last_error($pdo);
								exit;
							}    
							
							echo "<div class=\"dropdown\"><button class=\"dropbtn\">". $row_menu_princ[0] ."<i class=\"fa fa-caret-down\"></i></button>";
							
							echo "<div class=\"dropdown-content\">";
							
								while($row_submenu = pg_fetch_row($ret_submenu)) {					
																 
										echo "<a href=\"#\" onclick=\"removeIframe();iframeSelecionado('" . trim($row_submenu[2]) . "');prepareIframe('". $row_submenu[2] ."', '" . trim($row_submenu[5]) . "');\">" . trim($row_submenu[1]). "</a>";
								}
								
								echo "</div>";
							echo "</div>";
							
						} else {
							
							echo "<a href=\"#\" onclick=\"removeIframe();iframeSelecionado('" . trim($row_menu_princ[2]) . "');prepareIframe('". $row_menu_princ[2] ."', '" . trim($row_menu_princ[4]) . "');\">" . trim($row_menu_princ[0]). "</a>";
							
						}
					}
				
				}
			?>
			<div class="dropdown"><button class="dropbtn">Acesso<i class="fa fa-caret-down"></i></button>
				<div class="dropdown-content">					
					<a href="logout.php">Logout</a>
					<?php if ($fl_sist_admn=="S") {?>
						<a href="#" onclick="removeIframe();prepareIframe('criarusuario', 'cria_usuario.php');">Criar usuário</a>
						<a href="#" onclick="removeIframe();prepareIframe('apagarusuario', 'apaga_usuario.php');">Apagar usuário</a>
					<?php } ?>
					<a href="#" onclick="removeIframe();prepareIframe('alterasenha', 'altera_senha.php');">Alterar Senha</a>
					<a href="#" onclick="removeIframe();prepareIframe('manutalertalidos', './alerta/manut_alerta.php?tipoconsultaalerta=consultaregslidos');">Historico de Alertas</a>
				</div>				
			</div>
			
			<a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="fuTopNav()">&#9776;</a>
		</div>		
		
	</body>	
</html>	
<?php  pg_close($pdo); database::disconnect();	 ?>
