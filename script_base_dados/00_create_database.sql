-- Database: solus

-- DROP DATABASE solus;

CREATE DATABASE solus
    WITH 
    OWNER = postgres
    ENCODING = 'UTF8'
    LC_COLLATE = 'Portuguese_Brazil.1252'
    LC_CTYPE = 'Portuguese_Brazil.1252'
    TABLESPACE = pg_default
    CONNECTION LIMIT = -1;

COMMENT ON DATABASE solus
    IS 'Banco de Dados Transacionais';
	
	