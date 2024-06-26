PGDMP     ,                    y            desenv    10.9    13.3     O           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            P           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            Q           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            R           1262    3769902    desenv    DATABASE     f   CREATE DATABASE desenv WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE = 'Portuguese_Brazil.1252';
    DROP DATABASE desenv;
                postgres    false            S           0    0    DATABASE desenv    COMMENT     >   COMMENT ON DATABASE desenv IS 'Banco de Dados Transacionais';
                   postgres    false    2898            T           0    0    DATABASE desenv    ACL     ,   GRANT CONNECT ON DATABASE desenv TO evaldo;
                   postgres    false    2898            �            1259    3786142    tb_c_risco_pcnt    TABLE     p  CREATE TABLE tratamento.tb_c_risco_pcnt (
    id_risco_pcnt integer NOT NULL,
    ds_risco_pcnt character varying(255) NOT NULL,
    cd_cor_risco_pcnt character varying(255) NOT NULL,
    cd_usua_incs character varying(255) NOT NULL,
    dt_incs timestamp without time zone NOT NULL,
    cd_usua_altr character varying(255),
    dt_altr timestamp without time zone
);
 '   DROP TABLE tratamento.tb_c_risco_pcnt;
    
   tratamento            postgres    false            U           0    0    TABLE tb_c_risco_pcnt    COMMENT     S   COMMENT ON TABLE tratamento.tb_c_risco_pcnt IS 'Cadastro dos riscos de pacientes';
       
   tratamento          postgres    false    228            V           0    0 $   COLUMN tb_c_risco_pcnt.id_risco_pcnt    COMMENT     X   COMMENT ON COLUMN tratamento.tb_c_risco_pcnt.id_risco_pcnt IS 'Identificador do risco';
       
   tratamento          postgres    false    228            W           0    0 $   COLUMN tb_c_risco_pcnt.ds_risco_pcnt    COMMENT     V   COMMENT ON COLUMN tratamento.tb_c_risco_pcnt.ds_risco_pcnt IS 'Descrição do risco';
       
   tratamento          postgres    false    228            X           0    0 (   COLUMN tb_c_risco_pcnt.cd_cor_risco_pcnt    COMMENT     ]   COMMENT ON COLUMN tratamento.tb_c_risco_pcnt.cd_cor_risco_pcnt IS 'Código da cor do risco';
       
   tratamento          postgres    false    228            Y           0    0 #   COLUMN tb_c_risco_pcnt.cd_usua_incs    COMMENT     k   COMMENT ON COLUMN tratamento.tb_c_risco_pcnt.cd_usua_incs IS 'Código do usuário que incluiu o registro';
       
   tratamento          postgres    false    228            Z           0    0    COLUMN tb_c_risco_pcnt.dt_incs    COMMENT     Y   COMMENT ON COLUMN tratamento.tb_c_risco_pcnt.dt_incs IS 'Data de inclusão do registro';
       
   tratamento          postgres    false    228            [           0    0 #   COLUMN tb_c_risco_pcnt.cd_usua_altr    COMMENT     |   COMMENT ON COLUMN tratamento.tb_c_risco_pcnt.cd_usua_altr IS 'Código do usuário que alterpu pela última vez o registro';
       
   tratamento          postgres    false    228            \           0    0    COLUMN tb_c_risco_pcnt.dt_altr    COMMENT     c   COMMENT ON COLUMN tratamento.tb_c_risco_pcnt.dt_altr IS 'Data da última alteração do registro';
       
   tratamento          postgres    false    228            ]           0    0    TABLE tb_c_risco_pcnt    ACL     Q   GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE tratamento.tb_c_risco_pcnt TO evaldo;
       
   tratamento          postgres    false    228            L          0    3786142    tb_c_risco_pcnt 
   TABLE DATA           �   COPY tratamento.tb_c_risco_pcnt (id_risco_pcnt, ds_risco_pcnt, cd_cor_risco_pcnt, cd_usua_incs, dt_incs, cd_usua_altr, dt_altr) FROM stdin;
 
   tratamento          postgres    false    228   7       �
           2606    3786149    tb_c_risco_pcnt pk_risco_pcnt 
   CONSTRAINT     j   ALTER TABLE ONLY tratamento.tb_c_risco_pcnt
    ADD CONSTRAINT pk_risco_pcnt PRIMARY KEY (id_risco_pcnt);
 K   ALTER TABLE ONLY tratamento.tb_c_risco_pcnt DROP CONSTRAINT pk_risco_pcnt;
    
   tratamento            postgres    false    228            L   N   x�34��,N�WHIU,MMI�L�)M�L-K�I��4202�50�52V04�!c=ssc�*������LM�b���� �"     