PGDMP                         y            desenv    10.9    13.3     S           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            T           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            U           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            V           1262    3769902    desenv    DATABASE     f   CREATE DATABASE desenv WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE = 'Portuguese_Brazil.1252';
    DROP DATABASE desenv;
                postgres    false            W           0    0    DATABASE desenv    COMMENT     >   COMMENT ON DATABASE desenv IS 'Banco de Dados Transacionais';
                   postgres    false    2902            X           0    0    DATABASE desenv    ACL     ,   GRANT CONNECT ON DATABASE desenv TO evaldo;
                   postgres    false    2902            �            1259    3770277    tb_c_menu_sist_tratamento    TABLE     
  CREATE TABLE tratamento.tb_c_menu_sist_tratamento (
    id_menu_sist_tratamento integer NOT NULL,
    nm_menu_sist_tratamento character varying(255) NOT NULL,
    fl_menu_princ character varying(1) NOT NULL,
    id_menu_supr integer,
    nm_objt character varying(255),
    nm_link_objt character varying(4000),
    cd_usua_incs character varying(255) NOT NULL,
    dt_incs timestamp without time zone NOT NULL,
    cd_usua_altr character varying(255),
    dt_altr timestamp without time zone,
    nu_pcao_menu integer
);
 1   DROP TABLE tratamento.tb_c_menu_sist_tratamento;
    
   tratamento            postgres    false            Y           0    0    TABLE tb_c_menu_sist_tratamento    COMMENT     �   COMMENT ON TABLE tratamento.tb_c_menu_sist_tratamento IS 'Tabela de Cadastro de Menus utilizados para configurar a aplicação Web do sistema de tratamento.';
       
   tratamento          postgres    false    204            Z           0    0 8   COLUMN tb_c_menu_sist_tratamento.id_menu_sist_tratamento    COMMENT     �   COMMENT ON COLUMN tratamento.tb_c_menu_sist_tratamento.id_menu_sist_tratamento IS 'Identificador da tabela de menu do sistema sistema de tratamento.';
       
   tratamento          postgres    false    204            [           0    0 8   COLUMN tb_c_menu_sist_tratamento.nm_menu_sist_tratamento    COMMENT     |   COMMENT ON COLUMN tratamento.tb_c_menu_sist_tratamento.nm_menu_sist_tratamento IS 'Nome do menu do sistema de tratamento.';
       
   tratamento          postgres    false    204            \           0    0 .   COLUMN tb_c_menu_sist_tratamento.fl_menu_princ    COMMENT     �   COMMENT ON COLUMN tratamento.tb_c_menu_sist_tratamento.fl_menu_princ IS 'Flag se o menu é o principal (S para menu principal, ou N caso contrário).';
       
   tratamento          postgres    false    204            ]           0    0 -   COLUMN tb_c_menu_sist_tratamento.id_menu_supr    COMMENT     s   COMMENT ON COLUMN tratamento.tb_c_menu_sist_tratamento.id_menu_supr IS 'Identificador do menu superior ao atual.';
       
   tratamento          postgres    false    204            ^           0    0 (   COLUMN tb_c_menu_sist_tratamento.nm_objt    COMMENT     m   COMMENT ON COLUMN tratamento.tb_c_menu_sist_tratamento.nm_objt IS 'Nome do objeto que o menu irá acessar.';
       
   tratamento          postgres    false    204            _           0    0 -   COLUMN tb_c_menu_sist_tratamento.nm_link_objt    COMMENT     �   COMMENT ON COLUMN tratamento.tb_c_menu_sist_tratamento.nm_link_objt IS 'Nome ou endereço do link para o objeto que o menu irá acessar.';
       
   tratamento          postgres    false    204            `           0    0 -   COLUMN tb_c_menu_sist_tratamento.cd_usua_incs    COMMENT     �   COMMENT ON COLUMN tratamento.tb_c_menu_sist_tratamento.cd_usua_incs IS 'Código do usuário que realizou a inclusão do registro.';
       
   tratamento          postgres    false    204            a           0    0 (   COLUMN tb_c_menu_sist_tratamento.dt_incs    COMMENT     a   COMMENT ON COLUMN tratamento.tb_c_menu_sist_tratamento.dt_incs IS 'Data de inclusão registro.';
       
   tratamento          postgres    false    204            b           0    0 -   COLUMN tb_c_menu_sist_tratamento.cd_usua_altr    COMMENT     �   COMMENT ON COLUMN tratamento.tb_c_menu_sist_tratamento.cd_usua_altr IS 'Código do usuário que realizou a alteração do registro.';
       
   tratamento          postgres    false    204            c           0    0 (   COLUMN tb_c_menu_sist_tratamento.dt_altr    COMMENT     f   COMMENT ON COLUMN tratamento.tb_c_menu_sist_tratamento.dt_altr IS 'Data de alteração do registro.';
       
   tratamento          postgres    false    204            d           0    0 -   COLUMN tb_c_menu_sist_tratamento.nu_pcao_menu    COMMENT     h   COMMENT ON COLUMN tratamento.tb_c_menu_sist_tratamento.nu_pcao_menu IS 'Número da posição do menu.';
       
   tratamento          postgres    false    204            e           0    0    TABLE tb_c_menu_sist_tratamento    ACL     [   GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE tratamento.tb_c_menu_sist_tratamento TO evaldo;
       
   tratamento          postgres    false    204            P          0    3770277    tb_c_menu_sist_tratamento 
   TABLE DATA           �   COPY tratamento.tb_c_menu_sist_tratamento (id_menu_sist_tratamento, nm_menu_sist_tratamento, fl_menu_princ, id_menu_supr, nm_objt, nm_link_objt, cd_usua_incs, dt_incs, cd_usua_altr, dt_altr, nu_pcao_menu) FROM stdin;
 
   tratamento          postgres    false    204   �        �
           2606    3770284 1   tb_c_menu_sist_tratamento pk_menu_sist_tratamento 
   CONSTRAINT     �   ALTER TABLE ONLY tratamento.tb_c_menu_sist_tratamento
    ADD CONSTRAINT pk_menu_sist_tratamento PRIMARY KEY (id_menu_sist_tratamento);
 _   ALTER TABLE ONLY tratamento.tb_c_menu_sist_tratamento DROP CONSTRAINT pk_menu_sist_tratamento;
    
   tratamento            postgres    false    204            �
           2606    3770286 $   tb_c_menu_sist_tratamento uk_nm_objt 
   CONSTRAINT     f   ALTER TABLE ONLY tratamento.tb_c_menu_sist_tratamento
    ADD CONSTRAINT uk_nm_objt UNIQUE (nm_objt);
 R   ALTER TABLE ONLY tratamento.tb_c_menu_sist_tratamento DROP CONSTRAINT uk_nm_objt;
    
   tratamento            postgres    false    204            f           0    0 2   CONSTRAINT uk_nm_objt ON tb_c_menu_sist_tratamento    COMMENT     n   COMMENT ON CONSTRAINT uk_nm_objt ON tratamento.tb_c_menu_sist_tratamento IS 'Chave única do objeto de menu';
       
   tratamento          postgres    false    2769            �
           1259    3770292    fki_fk_menu_menu_supr    INDEX     g   CREATE INDEX fki_fk_menu_menu_supr ON tratamento.tb_c_menu_sist_tratamento USING btree (id_menu_supr);
 -   DROP INDEX tratamento.fki_fk_menu_menu_supr;
    
   tratamento            postgres    false    204            �
           2606    3770287 +   tb_c_menu_sist_tratamento fk_menu_menu_supr    FK CONSTRAINT     �   ALTER TABLE ONLY tratamento.tb_c_menu_sist_tratamento
    ADD CONSTRAINT fk_menu_menu_supr FOREIGN KEY (id_menu_supr) REFERENCES tratamento.tb_c_menu_sist_tratamento(id_menu_sist_tratamento);
 Y   ALTER TABLE ONLY tratamento.tb_c_menu_sist_tratamento DROP CONSTRAINT fk_menu_menu_supr;
    
   tratamento          postgres    false    204    204    2767            g           0    0 9   CONSTRAINT fk_menu_menu_supr ON tb_c_menu_sist_tratamento    COMMENT     �   COMMENT ON CONSTRAINT fk_menu_menu_supr ON tratamento.tb_c_menu_sist_tratamento IS 'Foreign key de autorelacionamento entre o menu e submenu.';
       
   tratamento          postgres    false    2770            P     x����n�0Ư�S�6C|u�n��Z�^U�,�$3l��δ�=H^l�C�,�
��E8��9������8�V�%ܕpS�R
poA�ǹ����͇� Fx���
S��(�z't*F+�W�@��$e8����zF	��;.uUٷ^/�H	CyHhF	5���|���W[i�-�x��Ɏ�(�+հ(�E�뽐*���dt:6������7g���|c�|l�FH�,K�d�}99���������'�Gr��sY���e�Sy�4����
~�s����l2�T�A�O-/�$��H�~e㌑4��$�.bL�}ƽѴ;�B�g�6]��ft#��4��͔�)�0w(_[�LW�_C5�_�����9J�:�J�U��ᇽ�Ý�����^݉O�ҥ^u���d���A{�Ƅ%H���Ac����7\益t`�p�K��;��%�X�&8������UK��͐�İݮ���ۗ)em�x�3�Ԟ؎��k������:s�����M��R��b����P[�oN�ٜV�=�B>�A�Ep/     