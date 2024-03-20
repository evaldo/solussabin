-- FUNCTION: integracao.prc_atualiza_medico()

-- DROP FUNCTION integracao.prc_atualiza_medico();

CREATE OR REPLACE FUNCTION integracao.prc_atualiza_medico(
	)
    RETURNS character
    LANGUAGE 'plpgsql'

    COST 100
    VOLATILE 
AS $BODY$
DECLARE 

	cur_smart_medico REFCURSOR;
	rec_smart_medico RECORD;
		
	rows_affected int;	
	qtde_reg_smart int;
	
BEGIN

	rows_affected := 0;		
	
	OPEN cur_smart_medico FOR 
	  SELECT distinct smart.id_memb_equip_hosptr_mdco
		   , trim(smart.nm_memb_equip_hosptr) as nm_memb_equip_hosptr	   
	FROM integracao.tb_ctrl_leito_smart smart 
	where smart.id_memb_equip_hosptr_mdco is not null order by 2;
	
	LOOP
	
		FETCH cur_smart_medico INTO rec_smart_medico;			
		EXIT WHEN NOT FOUND;
		
		SELECT count(1) into qtde_reg_smart 
			from integracao.tb_equip_hosptr
		where id_memb_equip_hosptr = rec_smart_medico.id_memb_equip_hosptr_mdco;
		
		if qtde_reg_smart = 0 then		
			INSERT INTO integracao.tb_equip_hosptr(
				id_memb_equip_hosptr
			  , nm_memb_equip_hosptr
			  , tp_memb_equip_hosptr
			  , cd_usua_incs
			  , dt_incs)
				VALUES (rec_smart_medico.id_memb_equip_hosptr_mdco
					  , rec_smart_medico.nm_memb_equip_hosptr
					  , 'MDCO'
					  , 'carga_medico'
					  , current_timestamp);
					  
			rows_affected := rows_affected + 1;		
		end if;
	
	END LOOP;

	CLOSE cur_smart_medico;	

	RETURN 'Proc. Ok. QtRegProcessados: '||rows_affected;

EXCEPTION WHEN OTHERS THEN 
	RAISE;
END;
$BODY$;

ALTER FUNCTION integracao.prc_atualiza_medico()
    OWNER TO postgres;



-- FUNCTION: integracao.prc_processa_bmh_online()

-- DROP FUNCTION integracao.prc_processa_bmh_online();

-- FUNCTION: integracao.prc_processa_bmh_online()

-- DROP FUNCTION integracao.prc_processa_bmh_online();

-- FUNCTION: integracao.prc_processa_bmh_online()

-- DROP FUNCTION integracao.prc_processa_bmh_online();

CREATE OR REPLACE FUNCTION integracao.prc_processa_bmh_online(
	)
    RETURNS character
    LANGUAGE 'plpgsql'

    COST 100
    VOLATILE 
AS $BODY$
DECLARE 

	cur_smart REFCURSOR;
	rec_smart RECORD;
	
	cur_smart_alta REFCURSOR;
	rec_smart_alta RECORD;
	
	cur_leito REFCURSOR;
	rec_leito RECORD;
		
	rows_affected int;	
	qtde_reg_smart int;
	
	dt_alta_smart timestamp without time zone;
	ds_cidade_smart character varying(255);
	
BEGIN

	rows_affected := 0;		
	
	OPEN cur_smart FOR 
	  SELECT pac_reg
	       , nm_pcnt
		   , dt_admss		   
		   , ds_sexo
		   , dt_nasc_pcnt
		   , nm_cnvo		   
	FROM integracao.tb_ctrl_leito_smart order by 1;
	
	LOOP
	
		FETCH cur_smart INTO rec_smart;			
		EXIT WHEN NOT FOUND;
		
		SELECT count(1) into qtde_reg_smart 
			from integracao.tb_bmh_online 
		where pac_reg = rec_smart.pac_reg
		   and dt_admss = rec_smart.dt_admss;
		
		if qtde_reg_smart = 0 then		
			INSERT into integracao.tb_bmh_online (pac_reg, nm_pcnt, dt_admss, ds_sexo, dt_nasc_pcnt, nm_cnvo)
			values
			    (rec_smart.pac_reg
				   , rec_smart.nm_pcnt
				   , rec_smart.dt_admss		   
				   , rec_smart.ds_sexo
				   , rec_smart.dt_nasc_pcnt
				   , rec_smart.nm_cnvo);
		else
		
			OPEN cur_leito FOR 
				SELECT    pac_reg 
						 , dt_nasc_pcnt
						 , nm_pcnt
						 , ds_leito
						 , ds_andar
						 , nm_mdco
						 , nm_cnvo
						 , nm_psco
						 , nm_trpa
						 , ds_ocorr
						 , ds_cid
						 , dt_admss
						 , ds_dieta
						 , fl_fmnte
						 , ds_const
						 , ds_crtr_intnc
						 , fl_status_leito
						 , fl_acmpte
						 , fl_rtgrd
						 , id_status_leito
						 , id_memb_equip_hosptr_mdco
						 , id_memb_equip_hosptr_psco
						 , id_memb_equip_hosptr_trpa	 
					FROM integracao.tb_ctrl_leito
					where pac_reg = rec_smart.pac_reg;

				FETCH cur_leito INTO rec_leito;			
					EXIT WHEN NOT FOUND;

				UPDATE integracao.tb_bmh_online SET 
					fl_fmnte = rec_leito.fl_fmnte , 
					fl_rtgrd = rec_leito.fl_rtgrd , 
					fl_acmpte = rec_leito.fl_acmpte , 
					fl_status_leito = rec_leito.fl_status_leito ,  
					id_status_leito = rec_leito.id_status_leito ,				
					id_memb_equip_hosptr_mdco = rec_leito.id_memb_equip_hosptr_mdco , 
					nm_mdco = rec_leito.nm_mdco , 
					id_memb_equip_hosptr_psco = rec_leito.id_memb_equip_hosptr_psco , 
					nm_psco = rec_leito.nm_psco , 
					id_memb_equip_hosptr_trpa = rec_leito.id_memb_equip_hosptr_trpa , 				
					nm_trpa =   rec_leito.nm_trpa ,				
					ds_cid = 	rec_leito.ds_cid ,
					ds_leito = 	rec_leito.ds_leito ,
					ds_dieta =  rec_leito.ds_dieta ,
					ds_const = rec_leito.ds_const ,
					ds_ocorr = rec_leito.ds_ocorr , 
					ds_crtr_intnc = rec_leito.ds_crtr_intnc 				 
					WHERE pac_reg = rec_smart.pac_reg
					  and dt_admss = rec_smart.dt_admss;
				
				close cur_leito;
				
		end if;
		
		rows_affected := rows_affected + 1;		
	
	END LOOP;

	open cur_smart_alta for
	
		SELECT pac_reg, dt_admss			
		from integracao.tb_bmh_online
		WHERE dt_alta is null;
		
	LOOP
		FETCH cur_smart_alta INTO rec_smart_alta;			
			EXIT WHEN NOT FOUND;

		SELECT dt_alta, ds_cidade
		into dt_alta_smart, ds_cidade_smart
			FROM integracao.tb_ctrl_leito_smart_alta
		where pac_reg = rec_smart_alta.pac_reg
		  and dt_admss = rec_smart_alta.dt_admss;

		if dt_alta_smart is not null then
			UPDATE integracao.tb_bmh_online SET
				dt_alta = dt_alta_smart ,
				ds_cidade = ds_cidade_smart
			WHERE pac_reg =rec_smart_alta.pac_reg
			  and dt_admss = rec_smart_alta.dt_admss;
			  
			 UPDATE integracao.tb_ctrl_leito_temp SET 
				fl_fmnte = false, 
				fl_rtgrd = false, 
				fl_acmpte = false, 		
				id_memb_equip_hosptr_mdco = null, 
				id_memb_equip_hosptr_psco = null, 
				id_memb_equip_hosptr_trpa = null,
				nm_mdco=null, 		
				nm_psco=null,
				nm_trpa=null,
				ds_cid = null,			
				ds_dieta = null,
				ds_const = null,
				ds_ocorr = null, 
				ds_crtr_intnc = null,				 
				pac_reg = null
				WHERE pac_reg =rec_smart_alta.pac_reg; 	
				
			delete from pts.tb_agdmto_atvd_pts 
			where nu_pac_reg = rec_smart_alta.pac_reg 
			  and dt_agdmto_atvd_pts >= dt_alta_smart;
			  
			update pts.tb_agdmto_atvd_pts
			set dt_hsp_dthra = dt_alta_smart
			where nu_pac_reg = rec_smart_alta.pac_reg
			  and dt_hsp_dthre = rec_smart_alta.dt_admss;
			 
			qtde_reg_smart:=qtde_reg_smart + 1;
			 
		end if;		
		
	end loop;
	
	close cur_smart_alta;	

	CLOSE cur_smart;	

	RETURN 'Proc. Ok. QtRegProcessados do BMHOnline: '||rows_affected||' QtRegProcessados de Alta: :'||rows_affected;

EXCEPTION WHEN OTHERS THEN 
	RAISE;
END;
$BODY$;

ALTER FUNCTION integracao.prc_processa_bmh_online()
    OWNER TO postgres;
