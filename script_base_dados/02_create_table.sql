CREATE TABLE IF NOT EXISTS tratamento.tb_c_local_trtmto
(
    id_local_trtmto integer NOT NULL,
    ds_local_trtmto character varying(255) NOT NULL,
	nu_seq_local_pnel integer NOT NULL,
	cd_usua_incs character varying(255) COLLATE pg_catalog."default" NOT NULL,
    dt_incs timestamp without time zone NOT NULL,
    cd_usua_altr character varying(255) COLLATE pg_catalog."default",
    dt_altr timestamp without time zone,
    CONSTRAINT pk_local_trtmto PRIMARY KEY (id_local_trtmto)
)
WITH (
    OIDS = FALSE
);

ALTER TABLE tratamento.tb_c_local_trtmto
    OWNER to postgres;

COMMENT ON TABLE tratamento.tb_c_local_trtmto
    IS 'Tabela de locais de Tratamento';

COMMENT ON COLUMN tratamento.tb_c_local_trtmto.id_local_trtmto
    IS 'Identificador do local de tratamento.';

COMMENT ON COLUMN tratamento.tb_c_local_trtmto.ds_local_trtmto
    IS 'Descrição do local de tratamento.';
	
COMMENT ON COLUMN tratamento.tb_c_local_trtmto.cd_usua_incs
    IS 'Código do usuário que incluiu o registro';

COMMENT ON COLUMN tratamento.tb_c_local_trtmto.dt_incs
    IS 'Data de inclusão do registro';

COMMENT ON COLUMN tratamento.tb_c_local_trtmto.cd_usua_altr
    IS 'Código do usuário que alterpu pela última vez o registro';

COMMENT ON COLUMN tratamento.tb_c_local_trtmto.dt_altr
    IS 'Data da última alteração do registro';	
	
------------------------------------------------------------------------------------------------------------------

-- Table: tratamento.tb_c_risco_pcnt
-- DROP TABLE tratamento.tb_c_risco_pcnt;

CREATE TABLE IF NOT EXISTS tratamento.tb_c_risco_pcnt
(
    id_risco_pcnt integer NOT NULL,
    ds_risco_pcnt character varying(255) COLLATE pg_catalog."default" NOT NULL,    
    cd_cor_risco_pcnt character varying(255) COLLATE pg_catalog."default" NOT NULL,
    cd_usua_incs character varying(255) COLLATE pg_catalog."default" NOT NULL,
    dt_incs timestamp without time zone NOT NULL,
    cd_usua_altr character varying(255) COLLATE pg_catalog."default",
    dt_altr timestamp without time zone,
    CONSTRAINT pk_risco_pcnt PRIMARY KEY (id_risco_pcnt)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE tratamento.tb_c_risco_pcnt
    OWNER to postgres;

GRANT DELETE, INSERT, SELECT, UPDATE ON TABLE tratamento.tb_c_risco_pcnt TO evaldo;

GRANT ALL ON TABLE tratamento.tb_c_risco_pcnt TO postgres;

COMMENT ON TABLE tratamento.tb_c_risco_pcnt
    IS 'Cadastro dos riscos de pacientes';

COMMENT ON COLUMN tratamento.tb_c_risco_pcnt.id_risco_pcnt
    IS 'Identificador do risco';

COMMENT ON COLUMN tratamento.tb_c_risco_pcnt.ds_risco_pcnt
    IS 'Descrição do risco';

COMMENT ON COLUMN tratamento.tb_c_risco_pcnt.cd_cor_risco_pcnt
    IS 'Código da cor do risco';

COMMENT ON COLUMN tratamento.tb_c_risco_pcnt.cd_usua_incs
    IS 'Código do usuário que incluiu o registro';

COMMENT ON COLUMN tratamento.tb_c_risco_pcnt.dt_incs
    IS 'Data de inclusão do registro';

COMMENT ON COLUMN tratamento.tb_c_risco_pcnt.cd_usua_altr
    IS 'Código do usuário que alterpu pela última vez o registro';

COMMENT ON COLUMN tratamento.tb_c_risco_pcnt.dt_altr
    IS 'Data da última alteração do registro';

----------------------------------------------------------------------------------------------------

-- Table: tratamento.tb_c_equipe

-- DROP TABLE tratamento.tb_c_equipe;

CREATE TABLE tratamento.tb_c_equipe
(
    id_equipe integer NOT NULL,
    ds_equipe character varying(255) COLLATE pg_catalog."default" NOT NULL,
	cd_usua_incs character varying(255) NOT NULL,
    dt_incs timestamp without time zone NOT NULL,
    cd_usua_altr character varying(255)  NULL,
    dt_altr timestamp without time zone  NULL,
    CONSTRAINT pk_equipe PRIMARY KEY (id_equipe)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE tratamento.tb_c_equipe
    OWNER to postgres;

COMMENT ON TABLE tratamento.tb_c_equipe
    IS 'Taela de equipes do agendamento do tratamento';

COMMENT ON COLUMN tratamento.tb_c_equipe.id_equipe
    IS 'Identificador da equipe';

COMMENT ON COLUMN tratamento.tb_c_equipe.ds_equipe
    IS 'Descrição da Equipe';
	
COMMENT ON COLUMN tratamento.tb_c_equipe.cd_usua_incs
    IS 'Código do usuário que incluiu o registro';

COMMENT ON COLUMN tratamento.tb_c_equipe.dt_incs
    IS 'Data de inclusão do registro';

COMMENT ON COLUMN tratamento.tb_c_equipe.cd_usua_altr
    IS 'Código do usuário que alterpu pela última vez o registro';

COMMENT ON COLUMN tratamento.tb_c_equipe.dt_altr
    IS 'Data da última alteração do registro';	
-----------------------------------------------------------------------------------------------

CREATE TABLE tratamento.tb_c_status_equipe
(
    id_status_equipe integer NOT NULL,
    id_equipe integer NOT NULL,
    ds_status_equipe character varying(255) NOT NULL,
    fl_ativo integer NOT NULL,
    fl_status_intrpe_trtmto_equipe integer NOT NULL,
    fl_status_finaliza_trtmto_equipe integer NOT NULL,
    cd_cor_status_equipe character varying(255) NOT NULL,
	cd_usua_incs character varying(255) NOT NULL,
    dt_incs timestamp without time zone NOT NULL,
    cd_usua_altr character varying(255)  NULL,
    dt_altr timestamp without time zone  NULL,
    CONSTRAINT pk_status_equipe PRIMARY KEY (id_status_equipe),
    CONSTRAINT fk_equipe_status_equipe FOREIGN KEY (id_equipe)
        REFERENCES tratamento.tb_c_equipe (id_equipe) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
        NOT VALID
)
WITH (
    OIDS = FALSE
);

ALTER TABLE DROP CONSTRAINT fk_equipe_status_equipe;

ALTER TABLE tratamento.tb_c_status_equipe
    ADD CONSTRAINT fk_status_equipe_equipe FOREIGN KEY (id_equipe)
    REFERENCES tratamento.tb_c_equipe (id_equipe)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION
    NOT VALID;

COMMENT ON CONSTRAINT fk_status_equipe_equipe ON tratamento.tb_c_status_equipe
    IS 'Chave estrangeira para a tabela de equipes';

CREATE INDEX fki_fk_status_equipe_equipe
    ON tratamento.tb_c_status_equipe(id_equipe);

ALTER TABLE tratamento.tb_c_status_equipe
    OWNER to postgres;

COMMENT ON TABLE tratamento.tb_c_status_equipe
    IS 'Cadastro dos status por equipe';

COMMENT ON COLUMN tratamento.tb_c_status_equipe.id_status_equipe
    IS 'Identificador do status da equipe';

COMMENT ON COLUMN tratamento.tb_c_status_equipe.id_equipe
    IS 'Identificador da equipe';

COMMENT ON COLUMN tratamento.tb_c_status_equipe.ds_status_equipe
    IS 'Descrição do status da equipe';

COMMENT ON COLUMN tratamento.tb_c_status_equipe.fl_ativo
    IS 'Flag do status ativo para aparecer ou não no painel';

COMMENT ON COLUMN tratamento.tb_c_status_equipe.fl_status_intrpe_trtmto_equipe
    IS 'Flag para indicar se o status interrompe a solicitação do tratamento pela equipe';

COMMENT ON COLUMN tratamento.tb_c_status_equipe.fl_status_finaliza_trtmto_equipe
    IS 'Flag que determina a finalização da solicitação do tratamento pela equipe';

COMMENT ON COLUMN tratamento.tb_c_status_equipe.cd_cor_status_equipe
    IS 'Código da cor do status da equipe';

COMMENT ON CONSTRAINT fk_equipe_status_equipe ON tratamento.tb_c_status_equipe
    IS 'Foreign Key da Equipe para o Status da Equipe';	
	
COMMENT ON COLUMN tratamento.tb_c_status_equipe.cd_usua_incs
    IS 'Código do usuário que incluiu o registro';

COMMENT ON COLUMN tratamento.tb_c_status_equipe.dt_incs
    IS 'Data de inclusão do registro';

COMMENT ON COLUMN tratamento.tb_c_status_equipe.cd_usua_altr
    IS 'Código do usuário que alterpu pela última vez o registro';

COMMENT ON COLUMN tratamento.tb_c_status_equipe.dt_altr
    IS 'Data da última alteração do registro';	

-----------------------------------------------------------------------------------------------
-- Table: tratamento.tb_c_status_trtmto
-- DROP TABLE tratamento.tb_c_status_trtmto;

CREATE TABLE IF NOT EXISTS tratamento.tb_c_status_trtmto
(
    id_status_trtmto integer NOT NULL,    
    ds_status_trtmto character varying(255) COLLATE pg_catalog."default" NOT NULL,
    fl_ativo integer NOT NULL,    
    cd_cor_status_trtmto character varying(255) COLLATE pg_catalog."default" NOT NULL,
    cd_usua_incs character varying(255) COLLATE pg_catalog."default" NOT NULL,
    dt_incs timestamp without time zone NOT NULL,
    cd_usua_altr character varying(255) COLLATE pg_catalog."default",
    dt_altr timestamp without time zone,
    CONSTRAINT pk_status_trtmto PRIMARY KEY (id_status_trtmto)           
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE tratamento.tb_c_status_trtmto
    OWNER to postgres;

GRANT DELETE, INSERT, SELECT, UPDATE ON TABLE tratamento.tb_c_status_trtmto TO evaldo;

GRANT ALL ON TABLE tratamento.tb_c_status_trtmto TO postgres;

COMMENT ON TABLE tratamento.tb_c_status_trtmto
    IS 'Cadastro dos status por equipe';

COMMENT ON COLUMN tratamento.tb_c_status_trtmto.id_status_trtmto
    IS 'Identificador do status do tratamento';

COMMENT ON COLUMN tratamento.tb_c_status_trtmto.ds_status_trtmto
    IS 'Descrição do status do tratamento';

COMMENT ON COLUMN tratamento.tb_c_status_trtmto.fl_ativo
    IS 'Flag do status ativo para aparecer ou não no painel de tratamento';

COMMENT ON COLUMN tratamento.tb_c_status_trtmto.cd_cor_status_trtmto
    IS 'Código da cor do status do tratamento';

COMMENT ON COLUMN tratamento.tb_c_status_trtmto.cd_usua_incs
    IS 'Código do usuário que incluiu o registro';

COMMENT ON COLUMN tratamento.tb_c_status_trtmto.dt_incs
    IS 'Data de inclusão do registro';

COMMENT ON COLUMN tratamento.tb_c_status_trtmto.cd_usua_altr
    IS 'Código do usuário que alterpu pela última vez o registro';

COMMENT ON COLUMN tratamento.tb_c_status_trtmto.dt_altr
    IS 'Data da última alteração do registro';

-----------------------------------------------------------------------------------------------

-- Table: tratamento.tb_pnel_solic_trtmto

-- DROP TABLE tratamento.tb_pnel_solic_trtmto;

CREATE TABLE IF NOT EXISTS tratamento.tb_pnel_solic_trtmto
(
    id_pnel_solic_trtmto integer NOT NULL,
    cd_pcnt integer NOT NULL,
    nm_pcnt character varying(255) COLLATE pg_catalog."default" NOT NULL,
    id_equipe integer NOT NULL,
    id_status_equipe integer NOT NULL,
    ds_obs_pcnt character varying(255) COLLATE pg_catalog."default" NOT NULL,
    cd_usua_incs character varying(255) COLLATE pg_catalog."default" NOT NULL,
    dt_incs timestamp without time zone NOT NULL,
    cd_usua_altr character varying(255) COLLATE pg_catalog."default" NOT NULL,
    dt_altr timestamp without time zone NOT NULL,
    CONSTRAINT pk_pnel_solic_trtmto PRIMARY KEY (id_pnel_solic_trtmto),
    CONSTRAINT fk_painel_trtmto_01 FOREIGN KEY (id_equipe)
        REFERENCES tratamento.tb_c_equipe (id_equipe) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT fk_painel_trtmto_02 FOREIGN KEY (id_status_equipe)
        REFERENCES tratamento.tb_c_status_equipe (id_status_equipe) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE tratamento.tb_pnel_solic_trtmto
    OWNER to postgres;

COMMENT ON TABLE tratamento.tb_pnel_solic_trtmto
    IS 'Painel das solicitações de tratamento';

COMMENT ON COLUMN tratamento.tb_pnel_solic_trtmto.id_pnel_solic_trtmto
    IS 'Identificador do painel de solicitação do tratamento';

COMMENT ON COLUMN tratamento.tb_pnel_solic_trtmto.cd_pcnt
    IS 'Código do paciente';

COMMENT ON COLUMN tratamento.tb_pnel_solic_trtmto.nm_pcnt
    IS 'Nome do paciente';

COMMENT ON COLUMN tratamento.tb_pnel_solic_trtmto.id_equipe
    IS 'Identificador do paciente';

COMMENT ON COLUMN tratamento.tb_pnel_solic_trtmto.id_status_equipe
    IS 'Identificador do status da equipe';

COMMENT ON COLUMN tratamento.tb_pnel_solic_trtmto.ds_obs_pcnt
    IS 'Descrição da observação do paciente';

COMMENT ON COLUMN tratamento.tb_pnel_solic_trtmto.cd_usua_incs
    IS 'Código do usuário que incluiu o registro';

COMMENT ON COLUMN tratamento.tb_pnel_solic_trtmto.dt_incs
    IS 'Data de inclusão do registro';

COMMENT ON COLUMN tratamento.tb_pnel_solic_trtmto.cd_usua_altr
    IS 'Código do usuário que alterpu pela última vez o registro';

COMMENT ON COLUMN tratamento.tb_pnel_solic_trtmto.dt_altr
    IS 'Data da última alteração do registro';

COMMENT ON CONSTRAINT fk_painel_trtmto_01 ON tratamento.tb_pnel_solic_trtmto
    IS 'Chave estrangeira do código da equipe para o painel de tratamento';
COMMENT ON CONSTRAINT fk_painel_trtmto_02 ON tratamento.tb_pnel_solic_trtmto
    IS 'Chave estrangeira do código do status da equipe para o painel de tratamento';	
	
-----------------------------------------------------------------------------------------------

-- Table: tratamento.tb_c_grupo_acesso
-- DROP TABLE tratamento.tb_c_grupo_acesso;

CREATE TABLE tratamento.tb_c_grupo_acesso
(
    id_grupo_acesso integer NOT NULL,
    nm_grupo_acesso character varying(255) COLLATE pg_catalog."default" NOT NULL,
    cd_usua_incs character varying(255) COLLATE pg_catalog."default" NOT NULL,
    dt_incs timestamp without time zone NOT NULL,
    cd_usua_altr character varying(255) COLLATE pg_catalog."default",
    dt_altr timestamp without time zone,
    CONSTRAINT pk_grupo_acesso PRIMARY KEY (id_grupo_acesso)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE tratamento.tb_c_grupo_acesso
    OWNER to postgres;

COMMENT ON TABLE tratamento.tb_c_grupo_acesso
    IS 'Armazena os grupos de acesso para controle de perfil de acesso.';

COMMENT ON COLUMN tratamento.tb_c_grupo_acesso.id_grupo_acesso
    IS 'Identificador da tabela de grupos de acesso para controle de perfil de acesso.';

COMMENT ON COLUMN tratamento.tb_c_grupo_acesso.nm_grupo_acesso
    IS 'Nome do grupo de acesso para controle de perfil de acesso.';

COMMENT ON COLUMN tratamento.tb_c_grupo_acesso.cd_usua_incs
    IS 'Código do usuário que realizou a inclusão do registro.';

COMMENT ON COLUMN tratamento.tb_c_grupo_acesso.dt_incs
    IS 'Data de inclusão registro.';

COMMENT ON COLUMN tratamento.tb_c_grupo_acesso.cd_usua_altr
    IS 'Código do usuário que realizou a alteração do registro.';

COMMENT ON COLUMN tratamento.tb_c_grupo_acesso.dt_altr
    IS 'Data de alteração do registro.';
	
---------------------------------------------------------------------------------------------------

-- Table: tratamento.tb_c_usua_acesso

-- DROP TABLE tratamento.tb_c_usua_acesso;

CREATE TABLE tratamento.tb_c_usua_acesso
(
    cd_usua_acesso integer NOT NULL,
    nm_usua_acesso character varying(255) COLLATE pg_catalog."default" NOT NULL,
    fl_sist_admn character varying(255) COLLATE pg_catalog."default",
    cd_usua_incs character varying(255) COLLATE pg_catalog."default" NOT NULL,
    dt_incs timestamp without time zone NOT NULL,
    cd_usua_altr character varying(255) COLLATE pg_catalog."default",
    dt_altr timestamp without time zone,
    ds_usua_acesso character varying(400) COLLATE pg_catalog."default",
    cd_faixa_ip_1 character varying(50) COLLATE pg_catalog."default",
    cd_faixa_ip_2 character varying(50) COLLATE pg_catalog."default",
    fl_acesso_ip character varying(1) COLLATE pg_catalog."default",
    CONSTRAINT pk_usua_acesso PRIMARY KEY (cd_usua_acesso)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE tratamento.tb_c_usua_acesso
    OWNER to postgres;

COMMENT ON TABLE tratamento.tb_c_usua_acesso
    IS 'Armazena os usuários de acesso para controle de perfil de acesso.';

COMMENT ON COLUMN tratamento.tb_c_usua_acesso.cd_usua_acesso
    IS 'Código identificador da tabela de usuários de acesso para controle de perfil de acesso.';

COMMENT ON COLUMN tratamento.tb_c_usua_acesso.nm_usua_acesso
    IS 'Nome do usuário de acesso para controle de perfil de acesso.';

COMMENT ON COLUMN tratamento.tb_c_usua_acesso.fl_sist_admn
    IS 'Flag (S/N) se o usuário é administrador ou não.';

COMMENT ON COLUMN tratamento.tb_c_usua_acesso.cd_usua_incs
    IS 'Código do usuário que realizou a inclusão do registro.';

COMMENT ON COLUMN tratamento.tb_c_usua_acesso.dt_incs
    IS 'Data de inclusão registro.';

COMMENT ON COLUMN tratamento.tb_c_usua_acesso.cd_usua_altr
    IS 'Código do usuário que realizou a alteração do registro.';

COMMENT ON COLUMN tratamento.tb_c_usua_acesso.dt_altr
    IS 'Data de alteração do registro.';

COMMENT ON COLUMN tratamento.tb_c_usua_acesso.ds_usua_acesso
    IS 'Descrição do usuário de acesso ao sistema. Por exemplo, o nome completo.';

COMMENT ON COLUMN tratamento.tb_c_usua_acesso.cd_faixa_ip_1
    IS 'Código de faixa de IP 1';

COMMENT ON COLUMN tratamento.tb_c_usua_acesso.cd_faixa_ip_2
    IS 'Código de faixa de IP 2';

COMMENT ON COLUMN tratamento.tb_c_usua_acesso.fl_acesso_ip
    IS 'Flag de acesso de (S) por IP ou (N) em qualquer lugar.';	
	
---------------------------------------------------------------------------------------------------

-- Table: tratamento.tb_c_grupo_usua_acesso

-- DROP TABLE tratamento.tb_c_grupo_usua_acesso;

CREATE TABLE tratamento.tb_c_grupo_usua_acesso
(
    id_grupo_usua_acesso integer NOT NULL,
    id_grupo_acesso integer NOT NULL,
    cd_usua_acesso integer NOT NULL,
    cd_usua_incs character varying(255) COLLATE pg_catalog."default" NOT NULL,
    dt_incs timestamp without time zone NOT NULL,
    cd_usua_altr character varying(255) COLLATE pg_catalog."default",
    dt_altr timestamp without time zone,
    CONSTRAINT pk_grupo_usua_acesso PRIMARY KEY (id_grupo_usua_acesso),
    CONSTRAINT uk_grupo_usua_acesso UNIQUE (id_grupo_acesso, cd_usua_acesso),
    CONSTRAINT fk_grupo_grupo_usua FOREIGN KEY (id_grupo_acesso)
        REFERENCES tratamento.tb_c_grupo_acesso (id_grupo_acesso) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT fk_usua_grupo_usua FOREIGN KEY (cd_usua_acesso)
        REFERENCES tratamento.tb_c_usua_acesso (cd_usua_acesso) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE tratamento.tb_c_grupo_usua_acesso
    OWNER to postgres;

COMMENT ON TABLE tratamento.tb_c_grupo_usua_acesso
    IS 'Armazena os grupos e respectivos usuários de acesso para controle de perfil de acesso.';

COMMENT ON COLUMN tratamento.tb_c_grupo_usua_acesso.id_grupo_acesso
    IS 'Identificador da tabela de usuários de acesso para controle de perfil de acesso.';

COMMENT ON COLUMN tratamento.tb_c_grupo_usua_acesso.cd_usua_acesso
    IS 'Identificador da tabela de grupos de acesso para controle de perfil de acesso.';

COMMENT ON COLUMN tratamento.tb_c_grupo_usua_acesso.cd_usua_incs
    IS 'Código do usuário que realizou a inclusão do registro.';

COMMENT ON COLUMN tratamento.tb_c_grupo_usua_acesso.dt_incs
    IS 'Data de inclusão registro.';

COMMENT ON COLUMN tratamento.tb_c_grupo_usua_acesso.cd_usua_altr
    IS 'Código do usuário que realizou a alteração do registro.';

COMMENT ON COLUMN tratamento.tb_c_grupo_usua_acesso.dt_altr
    IS 'Data de alteração do registro.';	
	
----------------------------------------------------------------------------------------------------------

-- Table: tratamento.tb_c_menu_sist_tratamento

-- DROP TABLE tratamento.tb_c_menu_sist_tratamento;

CREATE TABLE tratamento.tb_c_menu_sist_tratamento
(
    id_menu_sist_tratamento integer NOT NULL,
    nm_menu_sist_tratamento character varying(255) COLLATE pg_catalog."default" NOT NULL,
    fl_menu_princ character varying(1) COLLATE pg_catalog."default" NOT NULL,
    id_menu_supr integer,
    nm_objt character varying(255) COLLATE pg_catalog."default",
    nm_link_objt character varying(4000) COLLATE pg_catalog."default",
    cd_usua_incs character varying(255) COLLATE pg_catalog."default" NOT NULL,
    dt_incs timestamp without time zone NOT NULL,
    cd_usua_altr character varying(255) COLLATE pg_catalog."default",
    dt_altr timestamp without time zone,
    nu_pcao_menu integer,
    CONSTRAINT pk_menu_sist_tratamento PRIMARY KEY (id_menu_sist_tratamento),
    CONSTRAINT uk_nm_objt UNIQUE (nm_objt),
    CONSTRAINT fk_menu_menu_supr FOREIGN KEY (id_menu_supr)
        REFERENCES tratamento.tb_c_menu_sist_tratamento (id_menu_sist_tratamento) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE tratamento.tb_c_menu_sist_tratamento
    OWNER to postgres;

COMMENT ON TABLE tratamento.tb_c_menu_sist_tratamento
    IS 'Tabela de Cadastro de Menus utilizados para configurar a aplicação Web do sistema de tratamento.';

COMMENT ON COLUMN tratamento.tb_c_menu_sist_tratamento.id_menu_sist_tratamento
    IS 'Identificador da tabela de menu do sistema sistema de tratamento.';

COMMENT ON COLUMN tratamento.tb_c_menu_sist_tratamento.nm_menu_sist_tratamento
    IS 'Nome do menu do sistema de tratamento.';

COMMENT ON COLUMN tratamento.tb_c_menu_sist_tratamento.fl_menu_princ
    IS 'Flag se o menu é o principal (S para menu principal, ou N caso contrário).';

COMMENT ON COLUMN tratamento.tb_c_menu_sist_tratamento.id_menu_supr
    IS 'Identificador do menu superior ao atual.';

COMMENT ON COLUMN tratamento.tb_c_menu_sist_tratamento.nm_objt
    IS 'Nome do objeto que o menu irá acessar.';

COMMENT ON COLUMN tratamento.tb_c_menu_sist_tratamento.nm_link_objt
    IS 'Nome ou endereço do link para o objeto que o menu irá acessar.';

COMMENT ON COLUMN tratamento.tb_c_menu_sist_tratamento.cd_usua_incs
    IS 'Código do usuário que realizou a inclusão do registro.';

COMMENT ON COLUMN tratamento.tb_c_menu_sist_tratamento.dt_incs
    IS 'Data de inclusão registro.';

COMMENT ON COLUMN tratamento.tb_c_menu_sist_tratamento.cd_usua_altr
    IS 'Código do usuário que realizou a alteração do registro.';

COMMENT ON COLUMN tratamento.tb_c_menu_sist_tratamento.dt_altr
    IS 'Data de alteração do registro.';

COMMENT ON COLUMN tratamento.tb_c_menu_sist_tratamento.nu_pcao_menu
    IS 'Número da posição do menu.';

COMMENT ON CONSTRAINT uk_nm_objt ON tratamento.tb_c_menu_sist_tratamento
    IS 'Chave única do objeto de menu';

COMMENT ON CONSTRAINT fk_menu_menu_supr ON tratamento.tb_c_menu_sist_tratamento
    IS 'Foreign key de autorelacionamento entre o menu e submenu.';
-- Index: fki_fk_menu_menu_supr

-- DROP INDEX tratamento.fki_fk_menu_menu_supr;

CREATE INDEX fki_fk_menu_menu_supr
    ON tratamento.tb_c_menu_sist_tratamento USING btree
    (id_menu_supr ASC NULLS LAST)
    TABLESPACE pg_default;

------------------------------------------------------------------------------------------------

-- Table: tratamento.tb_c_grupo_usua_menu_sist_tratamento

-- DROP TABLE tratamento.tb_c_grupo_usua_menu_sist_tratamento;

CREATE TABLE tratamento.tb_c_grupo_usua_menu_sist_tratamento
(
    id_grupo_usua_menu_sist_tratamento integer NOT NULL,
    id_grupo_acesso integer NOT NULL,
    id_menu_sist_tratamento integer NOT NULL,
    cd_usua_incs character varying(255) COLLATE pg_catalog."default" NOT NULL,
    dt_incs timestamp without time zone NOT NULL,
    cd_usua_altr character varying(255) COLLATE pg_catalog."default",
    dt_altr timestamp without time zone,
    CONSTRAINT pk_grupo_usua_menu_sist_tratamento PRIMARY KEY (id_grupo_usua_menu_sist_tratamento),
    CONSTRAINT uk_grupo_usua_menu_sist_tratamento UNIQUE (id_grupo_acesso, id_menu_sist_tratamento),
    CONSTRAINT fk_grupo_sist_tratamento_grupo_usua FOREIGN KEY (id_grupo_acesso)
        REFERENCES tratamento.tb_c_grupo_acesso (id_grupo_acesso) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT fk_menu_sist_tratamento_grupo_usua FOREIGN KEY (id_menu_sist_tratamento)
        REFERENCES tratamento.tb_c_menu_sist_tratamento (id_menu_sist_tratamento) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE tratamento.tb_c_grupo_usua_menu_sist_tratamento
    OWNER to postgres;

COMMENT ON TABLE tratamento.tb_c_grupo_usua_menu_sist_tratamento
    IS 'Armazena os grupos e respectivos menus de acesso para controle de perfil de acesso ao sistema tratamento.';

COMMENT ON COLUMN tratamento.tb_c_grupo_usua_menu_sist_tratamento.id_grupo_usua_menu_sist_tratamento
    IS 'Identificador da tabela de grupos de usuários e seus respectivos menus de acesso para controle de perfil de acesso.';

COMMENT ON COLUMN tratamento.tb_c_grupo_usua_menu_sist_tratamento.id_grupo_acesso
    IS 'Identificador do grupos de usuários de acesso para controle de perfil de acesso.';

COMMENT ON COLUMN tratamento.tb_c_grupo_usua_menu_sist_tratamento.cd_usua_incs
    IS 'Código do usuário que realizou a inclusão do registro.';

COMMENT ON COLUMN tratamento.tb_c_grupo_usua_menu_sist_tratamento.dt_incs
    IS 'Data de inclusão registro.';

COMMENT ON COLUMN tratamento.tb_c_grupo_usua_menu_sist_tratamento.cd_usua_altr
    IS 'Código do usuário que realizou a alteração do registro.';

COMMENT ON COLUMN tratamento.tb_c_grupo_usua_menu_sist_tratamento.dt_altr
    IS 'Data de alteração do registro.';	
	
--------------------------------------------------------------------------------------------------------

-- Table: tratamento.tb_c_log_acesso

-- DROP TABLE tratamento.tb_c_log_acesso;

CREATE TABLE tratamento.tb_c_log_acesso
(
    id_log_acesso integer NOT NULL,
    cd_usua_acesso integer NOT NULL,
    nm_usua_acesso character varying(255) COLLATE pg_catalog."default",
    dt_log_acesso timestamp without time zone,
    CONSTRAINT pk_c_log_acesso PRIMARY KEY (id_log_acesso)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE tratamento.tb_c_log_acesso
    OWNER to postgres;
	
-------------------------------------------------------------------------------------------------------

-- Table: tratamento.tb_c_acesso_transac_tratamento

-- DROP TABLE tratamento.tb_c_acesso_transac_tratamento;

CREATE TABLE tratamento.tb_c_acesso_transac_tratamento
(
    id_acesso_transac_tratamento integer NOT NULL,
    id_menu_sist_tratamento integer NOT NULL,
    nm_acesso_transac_tratamento character varying(255) COLLATE pg_catalog."default" NOT NULL,
    cd_transac_tratamento character varying(255) COLLATE pg_catalog."default",
    cd_form_transac_tratamento character varying(255) COLLATE pg_catalog."default",
    cd_usua_incs character varying(255) COLLATE pg_catalog."default",
    dt_incs timestamp without time zone,
    cd_usua_altr character varying(255) COLLATE pg_catalog."default",
    dt_altr timestamp without time zone,
    CONSTRAINT pk_acesso_transac_tratamento PRIMARY KEY (id_acesso_transac_tratamento),
    CONSTRAINT fk_transac_tratamento_menu_sist FOREIGN KEY (id_menu_sist_tratamento)
        REFERENCES tratamento.tb_c_menu_sist_tratamento (id_menu_sist_tratamento) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE tratamento.tb_c_acesso_transac_tratamento
    OWNER to postgres;

COMMENT ON COLUMN tratamento.tb_c_acesso_transac_tratamento.id_acesso_transac_tratamento
    IS 'Identificador da tabela de acesso às transações do sistema integração.';

COMMENT ON COLUMN tratamento.tb_c_acesso_transac_tratamento.id_menu_sist_tratamento
    IS 'Identificador da tabela de menu do sistema sistema de tratamento.';

COMMENT ON COLUMN tratamento.tb_c_acesso_transac_tratamento.nm_acesso_transac_tratamento
    IS 'Nome da transação de acesso ao sistema integração.';
	
COMMENT ON COLUMN tratamento.tb_c_acesso_transac_tratamento.cd_transac_tratamento
    IS 'Código da transação de acesso no sistema integração.,';

COMMENT ON COLUMN tratamento.tb_c_acesso_transac_tratamento.cd_form_transac_tratamento
    IS 'Código do formulário de transação do integração';

COMMENT ON COLUMN tratamento.tb_c_acesso_transac_tratamento.cd_usua_incs
    IS 'Código do usuário que incluiu o registro';

COMMENT ON COLUMN tratamento.tb_c_acesso_transac_tratamento.dt_incs
    IS 'Data de inclusão do registro';

COMMENT ON COLUMN tratamento.tb_c_acesso_transac_tratamento.cd_usua_altr
    IS 'Código do usuário que alterou o registro';

COMMENT ON COLUMN tratamento.tb_c_acesso_transac_tratamento.dt_altr
    IS 'Data da última alteração do registro';
COMMENT ON CONSTRAINT pk_acesso_transac_tratamento ON tratamento.tb_c_acesso_transac_tratamento
    IS 'Chave primária da tabela de transação das funcionalidades do sistema integração';

COMMENT ON CONSTRAINT fk_transac_tratamento_menu_sist ON tratamento.tb_c_acesso_transac_tratamento
    IS 'Chave estrangeira da funcionalidade de transação de um menu do sistema integração';
	
---------------------------------------------------------------------------------------------------

-- Table: adbd.tb_vocon

-- DROP TABLE adbd.tb_vocon;

CREATE TABLE adbd.tb_vocon
(
    cd_abtr_vocon character varying(255) COLLATE pg_catalog."default" NOT NULL,
    ds_vocon character varying(255) COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT pk_vocon PRIMARY KEY (cd_abtr_vocon)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE adbd.tb_vocon
    OWNER to postgres;

-----------------------------------------------------------------------------------------------------
-- Table: tratamento.tb_c_grupo_usua_transac_acesso

-- DROP TABLE tratamento.tb_c_grupo_usua_transac_acesso;

CREATE TABLE IF NOT EXISTS tratamento.tb_c_grupo_usua_transac_acesso
(
    id_grupo_usua_transac_acesso integer NOT NULL,
    id_acesso_transac_tratamento integer NOT NULL,
    id_grupo_acesso integer NOT NULL,
    cd_usua_incs character varying(255) COLLATE pg_catalog."default",
    dt_incs timestamp without time zone,
    cd_usua_altr character varying(255) COLLATE pg_catalog."default",
    dt_altr timestamp without time zone,
    CONSTRAINT pk_grupo_usua_transac_acesso PRIMARY KEY (id_grupo_usua_transac_acesso),
    CONSTRAINT fk_acesso_transac_tratamento FOREIGN KEY (id_acesso_transac_tratamento)
        REFERENCES tratamento.tb_c_acesso_transac_tratamento (id_acesso_transac_tratamento) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT fk_grupo_acesso_transac_tratamento FOREIGN KEY (id_grupo_acesso)
        REFERENCES tratamento.tb_c_grupo_acesso (id_grupo_acesso) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE tratamento.tb_c_grupo_usua_transac_acesso
    OWNER to postgres;

COMMENT ON TABLE tratamento.tb_c_grupo_usua_transac_acesso
    IS 'Tabela do grupo de usuários que possuem direito de acesso às transações do sistema integração.';

COMMENT ON COLUMN tratamento.tb_c_grupo_usua_transac_acesso.id_grupo_usua_transac_acesso
    IS 'Identificador do grupo de usuários que possuem acesso às transações do sistema integração.';

COMMENT ON COLUMN tratamento.tb_c_grupo_usua_transac_acesso.id_acesso_transac_tratamento
    IS 'Identificador da tabela de acesso às transações do sistema integração.';

COMMENT ON COLUMN tratamento.tb_c_grupo_usua_transac_acesso.cd_usua_incs
    IS 'Código do usuário que incluiu o registro.';

COMMENT ON COLUMN tratamento.tb_c_grupo_usua_transac_acesso.dt_incs
    IS 'Data de inclusão do registro.';

COMMENT ON COLUMN tratamento.tb_c_grupo_usua_transac_acesso.cd_usua_altr
    IS 'Código do usuário que alterou o registro pela última vez.';

COMMENT ON COLUMN tratamento.tb_c_grupo_usua_transac_acesso.dt_altr
    IS 'Data da última alteração do registro.';
COMMENT ON CONSTRAINT pk_grupo_usua_transac_acesso ON tratamento.tb_c_grupo_usua_transac_acesso
    IS 'Chave primária do grupo de acesso de acesso às transações do sistema integração';

COMMENT ON CONSTRAINT fk_acesso_transac_tratamento ON tratamento.tb_c_grupo_usua_transac_acesso
    IS 'Chave estrangeira para o cadastro de acesso à transações do sistema integração.';
COMMENT ON CONSTRAINT fk_grupo_acesso_transac_tratamento ON tratamento.tb_c_grupo_usua_transac_acesso
    IS 'Chave estrangeira para a tabela do acesso à transação do sistema integração.';
	