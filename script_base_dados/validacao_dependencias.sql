--Views que devem ser alteradas para a view vw_f_risco_leito
SELECT distinct dependent_ns.nspname as dependent_schema
, dependent_view.relname as dependent_view 
, source_ns.nspname as source_schema
, source_table.relname as source_table
--, pg_attribute.attname as column_name
FROM pg_depend 
JOIN pg_rewrite ON pg_depend.objid = pg_rewrite.oid 
JOIN pg_class as dependent_view ON pg_rewrite.ev_class = dependent_view.oid 
JOIN pg_class as source_table ON pg_depend.refobjid = source_table.oid 
JOIN pg_attribute ON pg_depend.refobjid = pg_attribute.attrelid 
    AND pg_depend.refobjsubid = pg_attribute.attnum 
JOIN pg_namespace dependent_ns ON dependent_ns.oid = dependent_view.relnamespace
JOIN pg_namespace source_ns ON source_ns.oid = source_table.relnamespace
WHERE 
source_ns.nspname = 'ocupacao'
AND source_table.relname = 'tb_f_ctrl_leito'
--AND pg_attribute.attnum > 0 
--AND pg_attribute.attname = 'my_column'
ORDER BY 1,2;

--Procedures que devem ser alteradas para a view vw_f_risco_leito
select *
from (
    select proname, row_number() over (partition by proname) as line, textline, nspname
    from (
        select proname, unnest(string_to_array(prosrc, chr(10))) textline, nspname
        from pg_proc p
        join pg_namespace n on n.oid = p.pronamespace
        where nspname = 'ocupacao'
        --and prosrc ilike 'tb_f_ctrl_leito'
        ) lines
    ) x
    where textline ilike '%tb_f_ctrl_leito%';
	
	
-- View: ocupacao.vw_hstr_ocpa_leito_status
-- DROP VIEW ocupacao.vw_hstr_ocpa_leito_status;

CREATE OR REPLACE VIEW ocupacao.vw_hstr_ocpa_leito_status AS
 SELECT hstr_dt_1.ds_leito,
    hstr_dt_1.dt_inicio_mvto,
    COALESCE(( SELECT min(tb_f_hstr_ocpa_leito_status.dt_inicio_mvto) AS min
           FROM ocupacao.tb_f_hstr_ocpa_leito_status
          WHERE tb_f_hstr_ocpa_leito_status.dt_inicio_mvto > hstr_dt_1.dt_inicio_mvto AND tb_f_hstr_ocpa_leito_status.ds_leito::text = hstr_dt_1.ds_leito::text), CURRENT_TIMESTAMP::timestamp(0) without time zone - '01:00:00'::time without time zone::interval) AS dt_fim_mvto,
    hstr_dt_1.ds_status
   FROM ocupacao.tb_f_hstr_ocpa_leito_status hstr_dt_1
  ORDER BY hstr_dt_1.ds_leito, hstr_dt_1.dt_inicio_mvto;

ALTER TABLE ocupacao.vw_hstr_ocpa_leito_status
    OWNER TO postgres;

GRANT SELECT ON TABLE ocupacao.vw_hstr_ocpa_leito_status TO gabriela;
GRANT SELECT ON TABLE ocupacao.vw_hstr_ocpa_leito_status TO posto02;
GRANT SELECT ON TABLE ocupacao.vw_hstr_ocpa_leito_status TO posto03;
GRANT SELECT ON TABLE ocupacao.vw_hstr_ocpa_leito_status TO bcorrea;
GRANT SELECT ON TABLE ocupacao.vw_hstr_ocpa_leito_status TO alinediniz;
GRANT SELECT ON TABLE ocupacao.vw_hstr_ocpa_leito_status TO fcampos;
GRANT SELECT ON TABLE ocupacao.vw_hstr_ocpa_leito_status TO posto04;
GRANT ALL ON TABLE ocupacao.vw_hstr_ocpa_leito_status TO postgres;
GRANT SELECT ON TABLE ocupacao.vw_hstr_ocpa_leito_status TO lamorim;
GRANT SELECT ON TABLE ocupacao.vw_hstr_ocpa_leito_status TO mvilela;
GRANT SELECT ON TABLE ocupacao.vw_hstr_ocpa_leito_status TO posto01;
	