PGDMP     6                    y            desenv    10.9    13.3     O           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
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
                   postgres    false    2898            �            1259    3786103    tb_c_status_trtmto    TABLE     �  CREATE TABLE tratamento.tb_c_status_trtmto (
    id_status_trtmto integer NOT NULL,
    ds_status_trtmto character varying(255) NOT NULL,
    fl_ativo integer NOT NULL,
    cd_cor_status_trtmto character varying(255) NOT NULL,
    cd_usua_incs character varying(255) NOT NULL,
    dt_incs timestamp without time zone NOT NULL,
    cd_usua_altr character varying(255),
    dt_altr timestamp without time zone
);
 *   DROP TABLE tratamento.tb_c_status_trtmto;
    
   tratamento            postgres    false            U           0    0    TABLE tb_c_status_trtmto    COMMENT     T   COMMENT ON TABLE tratamento.tb_c_status_trtmto IS 'Cadastro dos status por equipe';
       
   tratamento          postgres    false    226            V           0    0 *   COLUMN tb_c_status_trtmto.id_status_trtmto    COMMENT     m   COMMENT ON COLUMN tratamento.tb_c_status_trtmto.id_status_trtmto IS 'Identificador do status do tratamento';
       
   tratamento          postgres    false    226            W           0    0 *   COLUMN tb_c_status_trtmto.ds_status_trtmto    COMMENT     k   COMMENT ON COLUMN tratamento.tb_c_status_trtmto.ds_status_trtmto IS 'Descrição do status do tratamento';
       
   tratamento          postgres    false    226            X           0    0 "   COLUMN tb_c_status_trtmto.fl_ativo    COMMENT     �   COMMENT ON COLUMN tratamento.tb_c_status_trtmto.fl_ativo IS 'Flag do status ativo para aparecer ou não no painel de tratamento';
       
   tratamento          postgres    false    226            Y           0    0 .   COLUMN tb_c_status_trtmto.cd_cor_status_trtmto    COMMENT     r   COMMENT ON COLUMN tratamento.tb_c_status_trtmto.cd_cor_status_trtmto IS 'Código da cor do status do tratamento';
       
   tratamento          postgres    false    226            Z           0    0 &   COLUMN tb_c_status_trtmto.cd_usua_incs    COMMENT     n   COMMENT ON COLUMN tratamento.tb_c_status_trtmto.cd_usua_incs IS 'Código do usuário que incluiu o registro';
       
   tratamento          postgres    false    226            [           0    0 !   COLUMN tb_c_status_trtmto.dt_incs    COMMENT     \   COMMENT ON COLUMN tratamento.tb_c_status_trtmto.dt_incs IS 'Data de inclusão do registro';
       
   tratamento          postgres    false    226            \           0    0 &   COLUMN tb_c_status_trtmto.cd_usua_altr    COMMENT        COMMENT ON COLUMN tratamento.tb_c_status_trtmto.cd_usua_altr IS 'Código do usuário que alterpu pela última vez o registro';
       
   tratamento          postgres    false    226            ]           0    0 !   COLUMN tb_c_status_trtmto.dt_altr    COMMENT     f   COMMENT ON COLUMN tratamento.tb_c_status_trtmto.dt_altr IS 'Data da última alteração do registro';
       
   tratamento          postgres    false    226            ^           0    0    TABLE tb_c_status_trtmto    ACL     T   GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE tratamento.tb_c_status_trtmto TO evaldo;
       
   tratamento          postgres    false    226            L          0    3786103    tb_c_status_trtmto 
   TABLE DATA           �   COPY tratamento.tb_c_status_trtmto (id_status_trtmto, ds_status_trtmto, fl_ativo, cd_cor_status_trtmto, cd_usua_incs, dt_incs, cd_usua_altr, dt_altr) FROM stdin;
 
   tratamento          postgres    false    226   .       �
           2606    3786110 #   tb_c_status_trtmto pk_status_trtmto 
   CONSTRAINT     s   ALTER TABLE ONLY tratamento.tb_c_status_trtmto
    ADD CONSTRAINT pk_status_trtmto PRIMARY KEY (id_status_trtmto);
 Q   ALTER TABLE ONLY tratamento.tb_c_status_trtmto DROP CONSTRAINT pk_status_trtmto;
    
   tratamento            postgres    false    226            L   H   x�3�(�K���KL��4�L���/�L-K���u�t��ͭ�M��M�-�8c���+F��� �#�     