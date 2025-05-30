PGDMP                         y            desenv    10.9    13.3     Q           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            R           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            S           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            T           1262    3769902    desenv    DATABASE     f   CREATE DATABASE desenv WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE = 'Portuguese_Brazil.1252';
    DROP DATABASE desenv;
                postgres    false            U           0    0    DATABASE desenv    COMMENT     >   COMMENT ON DATABASE desenv IS 'Banco de Dados Transacionais';
                   postgres    false    2900            V           0    0    DATABASE desenv    ACL     ,   GRANT CONNECT ON DATABASE desenv TO evaldo;
                   postgres    false    2900            �            1259    3770090    tb_c_equipe    TABLE     M  CREATE TABLE tratamento.tb_c_equipe (
    id_equipe integer NOT NULL,
    ds_equipe character varying(255) NOT NULL,
    cd_usua_incs character varying(255) NOT NULL,
    dt_incs timestamp without time zone NOT NULL,
    cd_usua_altr character varying(255),
    dt_altr timestamp without time zone,
    nu_seq_equipe_pnel integer
);
 #   DROP TABLE tratamento.tb_c_equipe;
    
   tratamento            postgres    false            W           0    0    TABLE tb_c_equipe    COMMENT     \   COMMENT ON TABLE tratamento.tb_c_equipe IS 'Taela de equipes do agendamento do tratamento';
       
   tratamento          postgres    false    198            X           0    0    COLUMN tb_c_equipe.id_equipe    COMMENT     Q   COMMENT ON COLUMN tratamento.tb_c_equipe.id_equipe IS 'Identificador da equipe';
       
   tratamento          postgres    false    198            Y           0    0    COLUMN tb_c_equipe.ds_equipe    COMMENT     O   COMMENT ON COLUMN tratamento.tb_c_equipe.ds_equipe IS 'Descrição da Equipe';
       
   tratamento          postgres    false    198            Z           0    0    COLUMN tb_c_equipe.cd_usua_incs    COMMENT     g   COMMENT ON COLUMN tratamento.tb_c_equipe.cd_usua_incs IS 'Código do usuário que incluiu o registro';
       
   tratamento          postgres    false    198            [           0    0    COLUMN tb_c_equipe.dt_incs    COMMENT     U   COMMENT ON COLUMN tratamento.tb_c_equipe.dt_incs IS 'Data de inclusão do registro';
       
   tratamento          postgres    false    198            \           0    0    COLUMN tb_c_equipe.cd_usua_altr    COMMENT     x   COMMENT ON COLUMN tratamento.tb_c_equipe.cd_usua_altr IS 'Código do usuário que alterpu pela última vez o registro';
       
   tratamento          postgres    false    198            ]           0    0    COLUMN tb_c_equipe.dt_altr    COMMENT     _   COMMENT ON COLUMN tratamento.tb_c_equipe.dt_altr IS 'Data da última alteração do registro';
       
   tratamento          postgres    false    198            ^           0    0 %   COLUMN tb_c_equipe.nu_seq_equipe_pnel    COMMENT     j   COMMENT ON COLUMN tratamento.tb_c_equipe.nu_seq_equipe_pnel IS 'Numero da sequencia da equipe no painel';
       
   tratamento          postgres    false    198            _           0    0    TABLE tb_c_equipe    ACL     M   GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE tratamento.tb_c_equipe TO evaldo;
       
   tratamento          postgres    false    198            N          0    3770090    tb_c_equipe 
   TABLE DATA           �   COPY tratamento.tb_c_equipe (id_equipe, ds_equipe, cd_usua_incs, dt_incs, cd_usua_altr, dt_altr, nu_seq_equipe_pnel) FROM stdin;
 
   tratamento          postgres    false    198   4       �
           2606    3770097    tb_c_equipe pk_equipe 
   CONSTRAINT     ^   ALTER TABLE ONLY tratamento.tb_c_equipe
    ADD CONSTRAINT pk_equipe PRIMARY KEY (id_equipe);
 C   ALTER TABLE ONLY tratamento.tb_c_equipe DROP CONSTRAINT pk_equipe;
    
   tratamento            postgres    false    198            �
           2606    3784464    tb_c_equipe uk_seq_equipe_panel 
   CONSTRAINT     l   ALTER TABLE ONLY tratamento.tb_c_equipe
    ADD CONSTRAINT uk_seq_equipe_panel UNIQUE (nu_seq_equipe_pnel);
 M   ALTER TABLE ONLY tratamento.tb_c_equipe DROP CONSTRAINT uk_seq_equipe_panel;
    
   tratamento            postgres    false    198            `           0    0 -   CONSTRAINT uk_seq_equipe_panel ON tb_c_equipe    COMMENT     v   COMMENT ON CONSTRAINT uk_seq_equipe_panel ON tratamento.tb_c_equipe IS 'Unique Key da Sequencia da Equipe no Painel';
       
   tratamento          postgres    false    2768            N   �   x�}ϻ��@����*h��}���K@2b���6t�(č!����~������5�<��[��������"3�JbEl���E�,���<]�q2�B�01��ٖC�7�#S6�49;1�L��];^�_���]
~R������6���KY����yd���u�r��T�HM�B�Ǹ1�� �SWq     