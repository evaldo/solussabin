-- SEQUENCE: tratamento.sq_risco_pcnt
-- DROP SEQUENCE tratamento.sq_risco_pcnt;

CREATE SEQUENCE tratamento.sq_risco_pcnt
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 999999999
    CACHE 1;

ALTER SEQUENCE tratamento.sq_risco_pcnt
    OWNER TO postgres;

COMMENT ON SEQUENCE tratamento.sq_risco_pcnt
    IS 'Sequence para o cadastro dos riscos dos pacientes';

GRANT ALL ON SEQUENCE tratamento.sq_risco_pcnt TO evaldo;

GRANT ALL ON SEQUENCE tratamento.sq_risco_pcnt TO postgres;

-- SEQUENCE: tratamento.sq_status_trtmto
-- DROP SEQUENCE tratamento.sq_status_trtmto;

CREATE SEQUENCE tratamento.sq_status_trtmto
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 999999999
    CACHE 1;

ALTER SEQUENCE tratamento.sq_status_trtmto
    OWNER TO postgres;

COMMENT ON SEQUENCE tratamento.sq_status_trtmto
    IS 'Sequence para o cadastro dos status por tratamentos';

GRANT ALL ON SEQUENCE tratamento.sq_status_trtmto TO evaldo;

GRANT ALL ON SEQUENCE tratamento.sq_status_trtmto TO postgres;

-- SEQUENCE: tratamento.sq_local_trtmto
-- DROP SEQUENCE tratamento.sq_local_trtmto;

CREATE SEQUENCE tratamento.sq_local_trtmto
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 999999999
    CACHE 1;

ALTER SEQUENCE tratamento.sq_local_trtmto
    OWNER TO postgres;

COMMENT ON SEQUENCE tratamento.sq_local_trtmto
    IS 'Sequence para o cadastro de locais de tratamento';

GRANT ALL ON SEQUENCE tratamento.sq_local_trtmto TO evaldo;
GRANT ALL ON SEQUENCE tratamento.sq_local_trtmto TO postgres;

-- SEQUENCE: tratamento.sq_acesso_transac_tratamento
-- DROP SEQUENCE tratamento.sq_acesso_transac_tratamento;

CREATE SEQUENCE tratamento.sq_acesso_transac_tratamento
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 999999999
    CACHE 1;

ALTER SEQUENCE tratamento.sq_acesso_transac_tratamento
    OWNER TO postgres;

COMMENT ON SEQUENCE tratamento.sq_acesso_transac_tratamento
    IS 'Sequence para o cadastro de transação do sistema tratamento';

-- SEQUENCE: tratamento.sq_grupo_acesso
-- DROP SEQUENCE tratamento.sq_grupo_acesso;

CREATE SEQUENCE tratamento.sq_grupo_acesso
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9999999999
    CACHE 1;

ALTER SEQUENCE tratamento.sq_grupo_acesso
    OWNER TO postgres;
	
-- SEQUENCE: tratamento.sq_grupo_usua_acesso
-- DROP SEQUENCE tratamento.sq_grupo_usua_acesso;

CREATE SEQUENCE tratamento.sq_grupo_usua_acesso
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9999999999
    CACHE 1;

ALTER SEQUENCE tratamento.sq_grupo_usua_acesso
    OWNER TO postgres;	
	
-- SEQUENCE: integracao.sq_grupo_usua_menu_sist_tratamento
-- DROP SEQUENCE integracao.sq_grupo_usua_menu_sist_tratamento;

CREATE SEQUENCE tratamento.sq_grupo_usua_menu_sist_tratamento
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9999999999
    CACHE 1;

ALTER SEQUENCE tratamento.sq_grupo_usua_menu_sist_tratamento
    OWNER TO postgres;	
	
-- SEQUENCE: tratamento.sq_grupo_usua_transac_acesso
-- DROP SEQUENCE tratamento.sq_grupo_usua_transac_acesso;

CREATE SEQUENCE tratamento.sq_grupo_usua_transac_acesso
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 99999999
    CACHE 1;

ALTER SEQUENCE tratamento.sq_grupo_usua_transac_acesso
    OWNER TO postgres;

COMMENT ON SEQUENCE tratamento.sq_grupo_usua_transac_acesso
    IS 'Sequence para tabela de grupo de usuários por transação';
	
-- SEQUENCE: tratamento.sq_log_acesso

-- DROP SEQUENCE tratamento.sq_log_acesso;

CREATE SEQUENCE tratamento.sq_log_acesso
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9999999999
    CACHE 1;

ALTER SEQUENCE tratamento.sq_log_acesso
    OWNER TO postgres;
	
-- SEQUENCE: tratamento.sq_menu_sist_integracao

-- DROP SEQUENCE tratamento.sq_menu_sist_integracao;

CREATE SEQUENCE tratamento.sq_menu_sist_tratamento
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9999999999
    CACHE 1;

ALTER SEQUENCE tratamento.sq_menu_sist_tratamento
    OWNER TO postgres;	
	
-- SEQUENCE: tratamento.sq_usua_acesso

-- DROP SEQUENCE tratamento.sq_usua_acesso;

CREATE SEQUENCE tratamento.sq_usua_acesso
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9999999999
    CACHE 1;

ALTER SEQUENCE tratamento.sq_usua_acesso
    OWNER TO postgres;	
	
-- SEQUENCE: tratamento.sq_equipe

-- DROP SEQUENCE tratamento.sq_equipe;

CREATE SEQUENCE tratamento.sq_equipe
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 999999999
    CACHE 1;

ALTER SEQUENCE tratamento.sq_equipe
    OWNER TO postgres;

COMMENT ON SEQUENCE tratamento.sq_equipe
    IS 'Sequence para o cadastro de equipes';


-- SEQUENCE: tratamento.sq_status_equipe

-- DROP SEQUENCE tratamento.sq_status_equipe;

CREATE SEQUENCE tratamento.sq_status_equipe
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 999999999
    CACHE 1;

ALTER SEQUENCE tratamento.sq_status_equipe
    OWNER TO postgres;

COMMENT ON SEQUENCE tratamento.sq_status_equipe
    IS 'Sequence para o cadastro dos status por equipes';
	
-- SEQUENCE: tratamento.sq_pnel_solic_trtmto

-- DROP SEQUENCE tratamento.sq_pnel_solic_trtmto;

CREATE SEQUENCE tratamento.sq_pnel_solic_trtmto
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 999999999
    CACHE 1;

ALTER SEQUENCE tratamento.sq_pnel_solic_trtmto
    OWNER TO postgres;

COMMENT ON SEQUENCE tratamento.sq_pnel_solic_trtmto
    IS 'Sequence para o cadastro dos paineis solicitados para o tratamento';	