<?php

class importacsv
{
    private static $pg;

    public function __construct()
    {
        die('Init function is not allowed');
    }

    public static function connect()
    {
        if ( null == self::$pg )
        {
            try
            {
				if(isset($_SESSION['usuario']))
				{
					self::$pg = @pg_connect("host=".Config::$dbHost." port=".Config::$dbPort." dbname=solussabin user=".$_SESSION['usuario']. " password=".$_SESSION['senha']."");
				}				
            }
            catch(PDOException $e)
            {
                die($e->getMessage());
            }
        }
        return self::$pg;
    }

    public static function disconnect()
    {
        return @pg_close(self::$pg);
    }

	
	public static function importapedidocsv($id_reg, $nm_pcnt, $nm_cnvo, $nu_peso_pcnt,$vl_altura_pcnt, $vl_sup_corp, $ds_indic_clnic, $dt_diagn, $cd_cid, $ds_estmt, $ds_tipo_linha_trtmto, $ds_fnlde, $ic_tipo_tumor, $ic_tipo_nodulo, $ic_tipo_metastase, $ds_plano_trptco, $ds_info_rlvnte, $ds_diagn_cito_hstpagico, $ds_tp_cirurgia, $ds_area_irrda, $dt_rlzd, $dt_aplc, $ds_obs_jfta, $nu_qtde_ciclo_prta, $ds_ciclo_atual,$ds_dia_ciclo_atual, $ds_intrv_entre_ciclo_dia, $nm_mdco_encaminhador){
		
		$sql = "insert into tratamento.tb_log_importa_csv (nm_arquivo_csv, id_reg_arquivo_csv) values ('".$nm_pcnt."', ".$id_reg.");"; 
		
		$pdo = $this->connect();
				
		$result = pg_query($pdo, $sql);
			
		if($result){
			echo "";
		}
				
		return null;
	}
}	

?>
