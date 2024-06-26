PGDMP                         y            desenv    10.9    13.3     O           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
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
                   postgres    false    2898            �            1259    3770249    tb_c_usua_acesso    TABLE     	  CREATE TABLE tratamento.tb_c_usua_acesso (
    cd_usua_acesso integer NOT NULL,
    nm_usua_acesso character varying(255) NOT NULL,
    fl_sist_admn character varying(255),
    cd_usua_incs character varying(255) NOT NULL,
    dt_incs timestamp without time zone NOT NULL,
    cd_usua_altr character varying(255),
    dt_altr timestamp without time zone,
    ds_usua_acesso character varying(400),
    cd_faixa_ip_1 character varying(50),
    cd_faixa_ip_2 character varying(50),
    fl_acesso_ip character varying(1)
);
 (   DROP TABLE tratamento.tb_c_usua_acesso;
    
   tratamento            postgres    false            U           0    0    TABLE tb_c_usua_acesso    COMMENT     v   COMMENT ON TABLE tratamento.tb_c_usua_acesso IS 'Armazena os usuários de acesso para controle de perfil de acesso.';
       
   tratamento          postgres    false    202            V           0    0 &   COLUMN tb_c_usua_acesso.cd_usua_acesso    COMMENT     �   COMMENT ON COLUMN tratamento.tb_c_usua_acesso.cd_usua_acesso IS 'Código identificador da tabela de usuários de acesso para controle de perfil de acesso.';
       
   tratamento          postgres    false    202            W           0    0 &   COLUMN tb_c_usua_acesso.nm_usua_acesso    COMMENT     �   COMMENT ON COLUMN tratamento.tb_c_usua_acesso.nm_usua_acesso IS 'Nome do usuário de acesso para controle de perfil de acesso.';
       
   tratamento          postgres    false    202            X           0    0 $   COLUMN tb_c_usua_acesso.fl_sist_admn    COMMENT     t   COMMENT ON COLUMN tratamento.tb_c_usua_acesso.fl_sist_admn IS 'Flag (S/N) se o usuário é administrador ou não.';
       
   tratamento          postgres    false    202            Y           0    0 $   COLUMN tb_c_usua_acesso.cd_usua_incs    COMMENT     {   COMMENT ON COLUMN tratamento.tb_c_usua_acesso.cd_usua_incs IS 'Código do usuário que realizou a inclusão do registro.';
       
   tratamento          postgres    false    202            Z           0    0    COLUMN tb_c_usua_acesso.dt_incs    COMMENT     X   COMMENT ON COLUMN tratamento.tb_c_usua_acesso.dt_incs IS 'Data de inclusão registro.';
       
   tratamento          postgres    false    202            [           0    0 $   COLUMN tb_c_usua_acesso.cd_usua_altr    COMMENT     }   COMMENT ON COLUMN tratamento.tb_c_usua_acesso.cd_usua_altr IS 'Código do usuário que realizou a alteração do registro.';
       
   tratamento          postgres    false    202            \           0    0    COLUMN tb_c_usua_acesso.dt_altr    COMMENT     ]   COMMENT ON COLUMN tratamento.tb_c_usua_acesso.dt_altr IS 'Data de alteração do registro.';
       
   tratamento          postgres    false    202            ]           0    0 &   COLUMN tb_c_usua_acesso.ds_usua_acesso    COMMENT     �   COMMENT ON COLUMN tratamento.tb_c_usua_acesso.ds_usua_acesso IS 'Descrição do usuário de acesso ao sistema. Por exemplo, o nome completo.';
       
   tratamento          postgres    false    202            ^           0    0 %   COLUMN tb_c_usua_acesso.cd_faixa_ip_1    COMMENT     [   COMMENT ON COLUMN tratamento.tb_c_usua_acesso.cd_faixa_ip_1 IS 'Código de faixa de IP 1';
       
   tratamento          postgres    false    202            _           0    0 %   COLUMN tb_c_usua_acesso.cd_faixa_ip_2    COMMENT     [   COMMENT ON COLUMN tratamento.tb_c_usua_acesso.cd_faixa_ip_2 IS 'Código de faixa de IP 2';
       
   tratamento          postgres    false    202            `           0    0 $   COLUMN tb_c_usua_acesso.fl_acesso_ip    COMMENT     x   COMMENT ON COLUMN tratamento.tb_c_usua_acesso.fl_acesso_ip IS 'Flag de acesso de (S) por IP ou (N) em qualquer lugar.';
       
   tratamento          postgres    false    202            a           0    0    TABLE tb_c_usua_acesso    ACL     L   GRANT ALL ON TABLE tratamento.tb_c_usua_acesso TO evaldo WITH GRANT OPTION;
       
   tratamento          postgres    false    202            L          0    3770249    tb_c_usua_acesso 
   TABLE DATA           �   COPY tratamento.tb_c_usua_acesso (cd_usua_acesso, nm_usua_acesso, fl_sist_admn, cd_usua_incs, dt_incs, cd_usua_altr, dt_altr, ds_usua_acesso, cd_faixa_ip_1, cd_faixa_ip_2, fl_acesso_ip) FROM stdin;
 
   tratamento          postgres    false    202          �
           2606    3770256    tb_c_usua_acesso pk_usua_acesso 
   CONSTRAINT     m   ALTER TABLE ONLY tratamento.tb_c_usua_acesso
    ADD CONSTRAINT pk_usua_acesso PRIMARY KEY (cd_usua_acesso);
 M   ALTER TABLE ONLY tratamento.tb_c_usua_acesso DROP CONSTRAINT pk_usua_acesso;
    
   tratamento            postgres    false    202            L   V   x�3�L-K�I���1��tLtM���3��\�
RR�s2�R3�R�3s�9-���,��L�x�\1z\\\ r�     