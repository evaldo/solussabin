ALTER TABLE tratamento.tb_c_equipe
    ADD CONSTRAINT uk_seq_equipe_panel UNIQUE (nu_seq_equipe_pnel);

COMMENT ON CONSTRAINT uk_seq_equipe_panel ON tratamento.tb_c_equipe
    IS 'Unique Key da Sequencia da Equipe no Painel';