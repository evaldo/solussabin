CREATE EXTENSION dblink;

SELECT pg_namespace.nspname, pg_proc.proname 
    FROM pg_proc, pg_namespace 
    WHERE pg_proc.pronamespace=pg_namespace.oid 
       AND pg_proc.proname LIKE '%dblink%';

SELECT dblink_connect('host=192.168.0.250 port=5430 user=postgres password=!V3rd3V1l4# dbname=vilaverde_dw');

-- Foreign Data Wrapper: db_link_vilaverde
-- DROP FOREIGN DATA WRAPPER db_link_vilaverde

CREATE FOREIGN DATA WRAPPER db_link_vilaverde
    VALIDATOR pg_catalog.postgresql_fdw_validator;

ALTER FOREIGN DATA WRAPPER db_link_vilaverde
    OWNER TO postgres;
	
CREATE SERVER vila_verde FOREIGN DATA WRAPPER db_link_vilaverde OPTIONS (host '192.168.0.250', port '5430', dbname 'vila_verde');
CREATE USER MAPPING FOR postgres SERVER vila_verde OPTIONS (user 'postgres', password '!V3rd3V1l4#');
--CREATE USER MAPPING FOR evaldo SERVER vila_verde OPTIONS (user 'postgres', password '!V3rd3V1l4#');

SELECT dblink_connect('vila_verde');

GRANT USAGE ON FOREIGN SERVER vila_verde TO postgres;
--GRANT USAGE ON FOREIGN SERVER vilaverde_dw TO evaldo;


SELECT data.nu_pac_reg,
    data.dt_hsp_dthra
   FROM dblink('vilaverde_dw'::text, 'select nu_pac_reg, dt_hsp_dthra from  vilaverde_dw.ocupacao.tb_f_alta_rlzd'::text) data(nu_pac_reg integer, dt_hsp_dthra timestamp without time zone);

create or replace view ocupacao.vw_ctrl_leito as 
	select data.* from 
	dblink('vila_verde'::text, '
    select cd_ctrl_leito 
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
		, ds_apto_atvd_fisica  
		, dt_prvs_alta 
		, ds_progra 
		, hr_progra 
		, fl_txclg_agndd  
		, dt_rlzd  
		, fl_rstc_visita  
		, fl_fmnte  
		, ds_pssoa_rtrta 
		, ds_sexo  
		, ds_const  
		, ds_crtr_intnc 
		, fl_status_leito 
		, fl_acmpte 
		, fl_rtgrd 
		, tp_dia_leito_manut  
     from vila_verde.integracao.tb_ctrl_leito'::text) data(
		  cd_ctrl_leito integer
		, dt_nasc_pcnt timestamp without time zone
		, nm_pcnt character varying(255) 
		, ds_leito character varying(255) 
		, ds_andar character varying(255) 
		, nm_mdco character varying(255) 
		, nm_cnvo character varying(255) 
		, nm_psco character varying(255)
		, nm_trpa character varying(255) 
		, ds_ocorr text 
		, ds_cid character varying(255) 
		, dt_admss character varying(255) 
		, ds_dieta character varying(255) 
		, ds_apto_atvd_fisica character varying(255) 
		, dt_prvs_alta timestamp without time zone
		, ds_progra character varying(255) 
		, hr_progra timestamp without time zone
		, fl_txclg_agndd boolean 
		, dt_rlzd character varying(255) 
		, fl_rstc_visita boolean 
		, fl_fmnte boolean 
		, ds_pssoa_rtrta character varying(255) 
		, ds_sexo character varying(255) 
		, ds_const character varying(255) 
		, ds_crtr_intnc character varying(100) 
		, fl_status_leito character varying(255)
		, fl_acmpte boolean
		, fl_rtgrd boolean
		, tp_dia_leito_manut integer	  
	);

-- View: ocupacao.vw_hstr_tp_ocpa_leito_status_nova
-- DROP VIEW ocupacao.vw_hstr_tp_ocpa_leito_status_nova;

CREATE OR REPLACE VIEW ocupacao.vw_hstr_tp_ocpa_leito_status_nova AS
 SELECT data.id_hstr_status_leito,
    data.ds_leito,
    data.dt_inicio_mvto,
	data.ds_status	
   FROM dblink('vila_verde'::text, '
    SELECT id_hstr_status_leito,
		   ds_leito,
		   dt_inicio_mvto,
		   ds_status  
     from vila_verde.integracao.tb_f_hstr_ocpa_leito_status'::text) data(id_hstr_status_leito integer, ds_leito character varying(255), dt_inicio_mvto timestamp without time zone, ds_status character varying(255));

ALTER TABLE ocupacao.vw_hstr_tp_ocpa_leito_status_nova
    OWNER TO postgres;

GRANT SELECT ON TABLE ocupacao.vw_hstr_tp_ocpa_leito_status_nova TO rl_consulta_ctrl_leito;
GRANT ALL ON TABLE ocupacao.vw_hstr_tp_ocpa_leito_status_nova TO postgres;