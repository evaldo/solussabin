PGDMP                         y            desenv    10.9    13.3     O           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
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
                   postgres    false    2898            �            1259    3786383    tb_c_local_trtmto    TABLE     g  CREATE TABLE tratamento.tb_c_local_trtmto (
    id_local_trtmto integer NOT NULL,
    ds_local_trtmto character varying(255) NOT NULL,
    nu_seq_local_pnel integer NOT NULL,
    cd_usua_incs character varying(255) NOT NULL,
    dt_incs timestamp without time zone NOT NULL,
    cd_usua_altr character varying(255),
    dt_altr timestamp without time zone
);
 )   DROP TABLE tratamento.tb_c_local_trtmto;
    
   tratamento            postgres    false            U           0    0    TABLE tb_c_local_trtmto    COMMENT     S   COMMENT ON TABLE tratamento.tb_c_local_trtmto IS 'Tabela de locais de Tratamento';
       
   tratamento          postgres    false    230            V           0    0 (   COLUMN tb_c_local_trtmto.id_local_trtmto    COMMENT     k   COMMENT ON COLUMN tratamento.tb_c_local_trtmto.id_local_trtmto IS 'Identificador do local de tratamento.';
       
   tratamento          postgres    false    230            W           0    0 (   COLUMN tb_c_local_trtmto.ds_local_trtmto    COMMENT     i   COMMENT ON COLUMN tratamento.tb_c_local_trtmto.ds_local_trtmto IS 'Descrição do local de tratamento.';
       
   tratamento          postgres    false    230            X           0    0 %   COLUMN tb_c_local_trtmto.cd_usua_incs    COMMENT     m   COMMENT ON COLUMN tratamento.tb_c_local_trtmto.cd_usua_incs IS 'Código do usuário que incluiu o registro';
       
   tratamento          postgres    false    230            Y           0    0     COLUMN tb_c_local_trtmto.dt_incs    COMMENT     [   COMMENT ON COLUMN tratamento.tb_c_local_trtmto.dt_incs IS 'Data de inclusão do registro';
       
   tratamento          postgres    false    230            Z           0    0 %   COLUMN tb_c_local_trtmto.cd_usua_altr    COMMENT     ~   COMMENT ON COLUMN tratamento.tb_c_local_trtmto.cd_usua_altr IS 'Código do usuário que alterpu pela última vez o registro';
       
   tratamento          postgres    false    230            [           0    0     COLUMN tb_c_local_trtmto.dt_altr    COMMENT     e   COMMENT ON COLUMN tratamento.tb_c_local_trtmto.dt_altr IS 'Data da última alteração do registro';
       
   tratamento          postgres    false    230            \           0    0    TABLE tb_c_local_trtmto    ACL     S   GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE tratamento.tb_c_local_trtmto TO evaldo;
       
   tratamento          postgres    false    230            L          0    3786383    tb_c_local_trtmto 
   TABLE DATA           �   COPY tratamento.tb_c_local_trtmto (id_local_trtmto, ds_local_trtmto, nu_seq_local_pnel, cd_usua_incs, dt_incs, cd_usua_altr, dt_altr) FROM stdin;
 
   tratamento          postgres    false    230   �       �
           2606    3786390 !   tb_c_local_trtmto pk_local_trtmto 
   CONSTRAINT     p   ALTER TABLE ONLY tratamento.tb_c_local_trtmto
    ADD CONSTRAINT pk_local_trtmto PRIMARY KEY (id_local_trtmto);
 O   ALTER TABLE ONLY tratamento.tb_c_local_trtmto DROP CONSTRAINT pk_local_trtmto;
    
   tratamento            postgres    false    230            L   H   x�34���))��KT0�4�L-K�I��4202�50�52V04�26�26ճ0�4�)ob�ghfhha����� ���     