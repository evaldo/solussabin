--
-- PostgreSQL database cluster dump
--

-- Started on 2022-08-01 23:20:02

SET default_transaction_read_only = off;

SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;

--
-- Roles
--

CREATE ROLE "abrahao.allack";
ALTER ROLE "abrahao.allack" WITH NOSUPERUSER INHERIT NOCREATEROLE NOCREATEDB LOGIN NOREPLICATION NOBYPASSRLS PASSWORD 'SCRAM-SHA-256$4096:L8ou6nhaU6MrmHlihQYhQQ==$s8jewqUTfbPb4GMytUGVf2xAEj+OQlzuteZU+TZ//uk=:JbZXyaayxzRFVFCj2zOZ8Scml3XAoCnrDoR8jGLR63g=';
CREATE ROLE "ana.vieira";
ALTER ROLE "ana.vieira" WITH NOSUPERUSER INHERIT NOCREATEROLE NOCREATEDB LOGIN NOREPLICATION NOBYPASSRLS PASSWORD 'SCRAM-SHA-256$4096:9uXvuBibvR0hBc/tX9qayA==$MJtwQCmoMNGaINg3HeWb4da7e7/1rQAvQ3OokEKx78E=:zPm1E3e7taeP8obpCkd1S2vudUPJ37CoauVRF3J4Ig0=';
CREATE ROLE "gabriela.nogueira";
ALTER ROLE "gabriela.nogueira" WITH NOSUPERUSER INHERIT NOCREATEROLE NOCREATEDB LOGIN NOREPLICATION NOBYPASSRLS PASSWORD 'SCRAM-SHA-256$4096:3vfJ93AOm1D6rSpKoTPgFA==$9e4TXqpyPMc2ZSECKfeiqO5HDtZOU5nPBs+IOJVE8lA=:ELSIDcxbbl8FRLVGYfeOnyrLYlzt0VfLtzTEpNLy2g0=';
CREATE ROLE "jocemar.costa";
ALTER ROLE "jocemar.costa" WITH NOSUPERUSER INHERIT NOCREATEROLE NOCREATEDB LOGIN NOREPLICATION NOBYPASSRLS PASSWORD 'SCRAM-SHA-256$4096:Sg31WkEwHjgrnF86IzSDYQ==$TcYzCq7FnONpyGttys+VTDlu8r+N6DlBO+6ueMccprc=:1ZLnDT9m7eUw1ciCzXY3KRB01hLj0LG3ZyVBDfSE+Yk=';
CREATE ROLE "karina.oliveira";
ALTER ROLE "karina.oliveira" WITH NOSUPERUSER INHERIT NOCREATEROLE NOCREATEDB LOGIN NOREPLICATION NOBYPASSRLS PASSWORD 'SCRAM-SHA-256$4096:I3/Fe4W2Q0fRUA0j+TD/zQ==$dDuAF1egvzH+ff2ZIXVdHGW6nHKOM1YXvbsWfc7p29k=:IK5ufLJIHbWLC/1XpCYFfLO7R98V+e2xYP/OPZFONnI=';
CREATE ROLE "leandra.talma";
ALTER ROLE "leandra.talma" WITH NOSUPERUSER INHERIT NOCREATEROLE NOCREATEDB LOGIN NOREPLICATION NOBYPASSRLS PASSWORD 'SCRAM-SHA-256$4096:2eAUxOuGg75ZMXTvkSmTaQ==$Zf20Nw10iLhs7B+gNFfOEMvU0ht1y5xFqdHLFgJQnIE=:Zkt5tsI448VQ3sKmY+mudIuzMdPyqrHGPsy8YZFfxcc=';
CREATE ROLE "maisa.bastos";
ALTER ROLE "maisa.bastos" WITH NOSUPERUSER INHERIT NOCREATEROLE NOCREATEDB LOGIN NOREPLICATION NOBYPASSRLS PASSWORD 'SCRAM-SHA-256$4096:e133UpLuV/B74lTrjnu2Lw==$/zMBgjlq24q5XiesVxY0rnEEfgyftkoNQtZW5dUWHrA=:zZor6Wbuo6Bni2s+uhHzaffjTQs4M2R8oKTvILjhDX0=';
CREATE ROLE "mayra.magalhaes";
ALTER ROLE "mayra.magalhaes" WITH NOSUPERUSER INHERIT NOCREATEROLE NOCREATEDB LOGIN NOREPLICATION NOBYPASSRLS PASSWORD 'SCRAM-SHA-256$4096:bV8dDa1+7SMR1Y3S+TG3Rw==$ZzhABl+3URHe27Ol9UeVF6UYln+5jYBJVZWPVlURr0w=:FauV0ohbv7pmg2iIRYUCNoLhgAMRltG7dNcjzAEAuW4=';
CREATE ROLE "milena.ribeiral";
ALTER ROLE "milena.ribeiral" WITH NOSUPERUSER INHERIT NOCREATEROLE NOCREATEDB LOGIN NOREPLICATION NOBYPASSRLS PASSWORD 'SCRAM-SHA-256$4096:S92933yrGsL6V2OlasLt6A==$nSqF0pr6x/KRT/eDdfSFYll6ZgmH8FAqCh+/FEZJDs0=:QWK4OeeQ2aDA3FZd8ALRQafdYR7yehC1/hGUofigLRA=';
CREATE ROLE "monise.freitas";
ALTER ROLE "monise.freitas" WITH NOSUPERUSER INHERIT NOCREATEROLE NOCREATEDB LOGIN NOREPLICATION NOBYPASSRLS PASSWORD 'SCRAM-SHA-256$4096:zIC3CSlCr3MGfzlDo1wkvQ==$9IcGIrh1JWcBBgJbK+ZTG6qtB4Byu+f7qxs/EtqWXik=:f7L7Vi6eTjyoldLTctHAGYLa86McYqEIfTT1AdxADLc=';
CREATE ROLE postgres;
ALTER ROLE postgres WITH SUPERUSER INHERIT CREATEROLE CREATEDB LOGIN REPLICATION BYPASSRLS PASSWORD 'SCRAM-SHA-256$4096:a9owKOf3iMoZUDYFfVoMaw==$U2TiYtxtyP7rxzwWAHA4+ARi/kEQlIjNgwk8no9maFo=:PeboKnaE61VI2xYewsQpgefpK72OW9iqePUIgfUrZRQ=';
CREATE ROLE "rafaella.aquino";
ALTER ROLE "rafaella.aquino" WITH NOSUPERUSER INHERIT NOCREATEROLE NOCREATEDB LOGIN NOREPLICATION NOBYPASSRLS PASSWORD 'SCRAM-SHA-256$4096:k6+Y/qIzdibxwieKOmX3Vw==$NEdjQK5ii7LHQAdgmONP8o8l/kM5rrMx0IziYCVrSYQ=:zzRFhjSs0Veync6gVhpEXnmIqhdKaz+pJkyDQZG3CNQ=';
CREATE ROLE "rayane.ribeiro";
ALTER ROLE "rayane.ribeiro" WITH NOSUPERUSER INHERIT NOCREATEROLE NOCREATEDB LOGIN NOREPLICATION NOBYPASSRLS PASSWORD 'SCRAM-SHA-256$4096:kT0Q2I1i2ILtzB4HpqSrhw==$OLbal2HJ9G4bihvIY2HPSDYOxybKC8LbTYonHd68bBI=:BqgdZEQqKuj5rEfS1KipDja1l31h5XU2Mv4VWAnJAjE=';
CREATE ROLE "talira.matias";
ALTER ROLE "talira.matias" WITH NOSUPERUSER INHERIT NOCREATEROLE NOCREATEDB LOGIN NOREPLICATION NOBYPASSRLS PASSWORD 'SCRAM-SHA-256$4096:3IFdqnamvxn6VBWuAo2Szg==$r6R6OCDVyTkUmY5Ar/UXLuqXNmpHaxjlrEK41MYRWYw=:Si/t5TnVLO5ez+BW56KboRNFBmODK9bM+wP7zh5Jjvs=';
CREATE ROLE "tatiane.neto";
ALTER ROLE "tatiane.neto" WITH NOSUPERUSER INHERIT NOCREATEROLE NOCREATEDB LOGIN NOREPLICATION NOBYPASSRLS PASSWORD 'SCRAM-SHA-256$4096:ON+SQ29AzI45Sl5w8Fmvjw==$GEnMvyTP/JCpZzVzTAX16ujY69XWoHdyk+gdrrpIs7A=:YkgzuANuLLoRl1W16iHG0045r6Uf2CHzw2zpyPKQ0dM=';
CREATE ROLE "tatyene.nehrer";
ALTER ROLE "tatyene.nehrer" WITH NOSUPERUSER INHERIT NOCREATEROLE NOCREATEDB LOGIN NOREPLICATION NOBYPASSRLS PASSWORD 'SCRAM-SHA-256$4096:ORaAnMxPtzuElGzX1wZMAg==$s50dEgJlTo3udRx+s4gUdasCgdSFyR9d79VmJudgAA8=:UQu6xOEiCPFfsW7TRZfezdqNlVfDEPAVxgR8pnvBGoU=';






-- Completed on 2022-08-01 23:20:02

--
-- PostgreSQL database cluster dump complete
--
