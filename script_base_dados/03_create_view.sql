-- View: tratamento.vw_acesso_transac_tratamento

-- DROP VIEW tratamento.vw_acesso_transac_tratamento;

CREATE OR REPLACE VIEW tratamento.vw_acesso_transac_tratamento
 AS
 SELECT grupo.nm_grupo_acesso,
    usua.nm_usua_acesso,
    transac.nm_acesso_transac_tratamento,
    transac.cd_transac_tratamento,
    transac.cd_form_transac_tratamento
   FROM tratamento.tb_c_grupo_usua_transac_acesso grupo_usua_transac,
    tratamento.tb_c_grupo_acesso grupo,
    tratamento.tb_c_usua_acesso usua,
    tratamento.tb_c_grupo_usua_acesso grupo_usua,
    tratamento.tb_c_acesso_transac_tratamento transac
  WHERE grupo_usua_transac.id_grupo_acesso = grupo.id_grupo_acesso AND grupo_usua_transac.id_acesso_transac_tratamento = transac.id_acesso_transac_tratamento AND grupo.id_grupo_acesso = grupo_usua.id_grupo_acesso AND grupo_usua.cd_usua_acesso = usua.cd_usua_acesso;

ALTER TABLE tratamento.vw_acesso_transac_tratamento
    OWNER TO postgres;

---------------------------------------------------------------------------------------------------------

-- View: tratamento.vw_menu_princ_tratamento

-- DROP VIEW tratamento.vw_menu_princ_tratamento;

CREATE OR REPLACE VIEW tratamento.vw_menu_princ_tratamento
 AS
 SELECT menu_princ.nm_menu_sist_tratamento AS menu_principal,
    COALESCE(sub_menu.nm_menu_sist_tratamento, '-'::character varying) AS sub_menu,
    COALESCE(menu_princ.nm_objt, '-'::character varying) AS nm_objt_menu_princ,
    COALESCE(sub_menu.nm_objt, '-'::character varying) AS nm_objt_sub_menu_princ,
    COALESCE(menu_princ.nm_link_objt, '-'::character varying) AS nm_link_objt_menu_princ,
    COALESCE(sub_menu.nm_link_objt, '-'::character varying) AS nm_link_objt_sub_menu_princ,
    ( SELECT count(1) AS count
           FROM tratamento.tb_c_menu_sist_tratamento
          WHERE tb_c_menu_sist_tratamento.id_menu_supr = menu_princ.id_menu_sist_tratamento) AS qt_menu_nivel_1,
    ( SELECT count(1) AS count
           FROM tratamento.tb_c_menu_sist_tratamento
          WHERE tb_c_menu_sist_tratamento.id_menu_supr = sub_menu.id_menu_sist_tratamento) AS qt_menu_nivel_2,
    menu_princ.nu_pcao_menu
   FROM tratamento.tb_c_menu_sist_tratamento menu_princ
     FULL JOIN tratamento.tb_c_menu_sist_tratamento sub_menu ON menu_princ.id_menu_sist_tratamento = sub_menu.id_menu_supr
  WHERE menu_princ.nm_menu_sist_tratamento IS NOT NULL AND menu_princ.fl_menu_princ::text = 'S'::text
  ORDER BY menu_princ.nu_pcao_menu;

ALTER TABLE tratamento.vw_menu_princ_tratamento
    OWNER TO postgres;

---------------------------------------------------------------------------------------------------------

-- View: tratamento.vw_menu_princ_tratamento_usua

-- DROP VIEW tratamento.vw_menu_princ_tratamento_usua;

CREATE OR REPLACE VIEW tratamento.vw_menu_princ_tratamento_usua
 AS
 SELECT menu.id_menu_sist_tratamento,
    menu.nm_menu_sist_tratamento,
    menu.fl_menu_princ,
    menu.id_menu_supr,
    menu.nm_objt,
    menu.nm_link_objt,
    menu.cd_usua_incs,
    menu.dt_incs,
    menu.cd_usua_altr,
    menu.dt_altr,
    menu.nu_pcao_menu,
    usua_acesso.nm_usua_acesso
   FROM tratamento.tb_c_grupo_usua_menu_sist_tratamento grupo_menu,
    tratamento.tb_c_usua_acesso usua_acesso,
    tratamento.tb_c_grupo_acesso grupo_acesso,
    tratamento.tb_c_menu_sist_tratamento menu,
    tratamento.tb_c_grupo_usua_acesso grupo_usua
  WHERE grupo_menu.id_grupo_acesso = grupo_acesso.id_grupo_acesso AND grupo_menu.id_menu_sist_tratamento = menu.id_menu_sist_tratamento AND grupo_acesso.id_grupo_acesso = grupo_usua.id_grupo_acesso AND grupo_usua.cd_usua_acesso = usua_acesso.cd_usua_acesso;

ALTER TABLE tratamento.vw_menu_princ_tratamento_usua
    OWNER TO postgres;

--------------------------------------------------------------------------------------------------------------
-- View: tratamento.vw_menu_princ_usua

-- DROP VIEW tratamento.vw_menu_princ_usua;

CREATE OR REPLACE VIEW tratamento.vw_menu_princ_usua
 AS
 SELECT menu_princ.menu_principal,
    menu_princ.sub_menu,
    menu_princ.nm_objt_menu_princ,
    menu_princ.nm_objt_sub_menu_princ,
    menu_princ.nm_link_objt_menu_princ,
    menu_princ.nm_link_objt_sub_menu_princ,
    menu_princ.qt_menu_nivel_1,
    menu_princ.qt_menu_nivel_2,
    menu_princ.nu_pcao_menu,
    menu_princ_usua.nm_usua_acesso
   FROM tratamento.vw_menu_princ_tratamento menu_princ,
    tratamento.vw_menu_princ_tratamento_usua menu_princ_usua
  WHERE menu_princ.sub_menu::text = menu_princ_usua.nm_menu_sist_tratamento::text;

ALTER TABLE tratamento.vw_menu_princ_usua
    OWNER TO postgres;



