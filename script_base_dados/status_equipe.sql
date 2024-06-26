PGDMP                         y            desenv    10.9    13.3     Q           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
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
                   postgres    false    2900            �            1259    3770098    tb_c_status_equipe    TABLE     '  CREATE TABLE tratamento.tb_c_status_equipe (
    id_status_equipe integer NOT NULL,
    id_equipe integer NOT NULL,
    ds_status_equipe character varying(255) NOT NULL,
    fl_ativo integer NOT NULL,
    fl_status_intrpe_trtmto_equipe integer NOT NULL,
    fl_status_finaliza_trtmto_equipe integer NOT NULL,
    cd_cor_status_equipe character varying(255) NOT NULL,
    cd_usua_incs character varying(255) NOT NULL,
    dt_incs timestamp without time zone NOT NULL,
    cd_usua_altr character varying(255),
    dt_altr timestamp without time zone
);
 *   DROP TABLE tratamento.tb_c_status_equipe;
    
   tratamento            postgres    false            W           0    0    TABLE tb_c_status_equipe    COMMENT     T   COMMENT ON TABLE tratamento.tb_c_status_equipe IS 'Cadastro dos status por equipe';
       
   tratamento          postgres    false    199            X           0    0 *   COLUMN tb_c_status_equipe.id_status_equipe    COMMENT     i   COMMENT ON COLUMN tratamento.tb_c_status_equipe.id_status_equipe IS 'Identificador do status da equipe';
       
   tratamento          postgres    false    199            Y           0    0 #   COLUMN tb_c_status_equipe.id_equipe    COMMENT     X   COMMENT ON COLUMN tratamento.tb_c_status_equipe.id_equipe IS 'Identificador da equipe';
       
   tratamento          postgres    false    199            Z           0    0 *   COLUMN tb_c_status_equipe.ds_status_equipe    COMMENT     g   COMMENT ON COLUMN tratamento.tb_c_status_equipe.ds_status_equipe IS 'Descrição do status da equipe';
       
   tratamento          postgres    false    199            [           0    0 "   COLUMN tb_c_status_equipe.fl_ativo    COMMENT     t   COMMENT ON COLUMN tratamento.tb_c_status_equipe.fl_ativo IS 'Flag do status ativo para aparecer ou não no painel';
       
   tratamento          postgres    false    199            \           0    0 8   COLUMN tb_c_status_equipe.fl_status_intrpe_trtmto_equipe    COMMENT     �   COMMENT ON COLUMN tratamento.tb_c_status_equipe.fl_status_intrpe_trtmto_equipe IS 'Flag para indicar se o status interrompe a solicitação do tratamento pela equipe';
       
   tratamento          postgres    false    199            ]           0    0 :   COLUMN tb_c_status_equipe.fl_status_finaliza_trtmto_equipe    COMMENT     �   COMMENT ON COLUMN tratamento.tb_c_status_equipe.fl_status_finaliza_trtmto_equipe IS 'Flag que determina a finalização da solicitação do tratamento pela equipe';
       
   tratamento          postgres    false    199            ^           0    0 .   COLUMN tb_c_status_equipe.cd_cor_status_equipe    COMMENT     n   COMMENT ON COLUMN tratamento.tb_c_status_equipe.cd_cor_status_equipe IS 'Código da cor do status da equipe';
       
   tratamento          postgres    false    199            _           0    0 &   COLUMN tb_c_status_equipe.cd_usua_incs    COMMENT     n   COMMENT ON COLUMN tratamento.tb_c_status_equipe.cd_usua_incs IS 'Código do usuário que incluiu o registro';
       
   tratamento          postgres    false    199            `           0    0 !   COLUMN tb_c_status_equipe.dt_incs    COMMENT     \   COMMENT ON COLUMN tratamento.tb_c_status_equipe.dt_incs IS 'Data de inclusão do registro';
       
   tratamento          postgres    false    199            a           0    0 &   COLUMN tb_c_status_equipe.cd_usua_altr    COMMENT        COMMENT ON COLUMN tratamento.tb_c_status_equipe.cd_usua_altr IS 'Código do usuário que alterpu pela última vez o registro';
       
   tratamento          postgres    false    199            b           0    0 !   COLUMN tb_c_status_equipe.dt_altr    COMMENT     f   COMMENT ON COLUMN tratamento.tb_c_status_equipe.dt_altr IS 'Data da última alteração do registro';
       
   tratamento          postgres    false    199            c           0    0    TABLE tb_c_status_equipe    ACL     T   GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE tratamento.tb_c_status_equipe TO evaldo;
       
   tratamento          postgres    false    199            N          0    3770098    tb_c_status_equipe 
   TABLE DATA           �   COPY tratamento.tb_c_status_equipe (id_status_equipe, id_equipe, ds_status_equipe, fl_ativo, fl_status_intrpe_trtmto_equipe, fl_status_finaliza_trtmto_equipe, cd_cor_status_equipe, cd_usua_incs, dt_incs, cd_usua_altr, dt_altr) FROM stdin;
 
   tratamento          postgres    false    199   �       �
           2606    3770105 #   tb_c_status_equipe pk_status_equipe 
   CONSTRAINT     s   ALTER TABLE ONLY tratamento.tb_c_status_equipe
    ADD CONSTRAINT pk_status_equipe PRIMARY KEY (id_status_equipe);
 Q   ALTER TABLE ONLY tratamento.tb_c_status_equipe DROP CONSTRAINT pk_status_equipe;
    
   tratamento            postgres    false    199            �
           1259    3784751    fki_fk_status_equipe_equipe    INDEX     c   CREATE INDEX fki_fk_status_equipe_equipe ON tratamento.tb_c_status_equipe USING btree (id_equipe);
 3   DROP INDEX tratamento.fki_fk_status_equipe_equipe;
    
   tratamento            postgres    false    199            �
           2606    3784746 *   tb_c_status_equipe fk_status_equipe_equipe    FK CONSTRAINT     �   ALTER TABLE ONLY tratamento.tb_c_status_equipe
    ADD CONSTRAINT fk_status_equipe_equipe FOREIGN KEY (id_equipe) REFERENCES tratamento.tb_c_equipe(id_equipe) NOT VALID;
 X   ALTER TABLE ONLY tratamento.tb_c_status_equipe DROP CONSTRAINT fk_status_equipe_equipe;
    
   tratamento          postgres    false    199            d           0    0 8   CONSTRAINT fk_status_equipe_equipe ON tb_c_status_equipe    COMMENT     �   COMMENT ON CONSTRAINT fk_status_equipe_equipe ON tratamento.tb_c_status_equipe IS 'Chave estrangeira para a tabela de equipes';
       
   tratamento          postgres    false    2768            N   a   x�u��	�0 ���
H����g� jD����ﴀCYm�Kg���6+W>�0��YΜwȏ�s��>6����HR��k�'ԉ%��P����{1l�     