CREATE TABLE refeicao (
  id_refeicao INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  nome_refeicao VARCHAR NULL,
  hora_inicio TIME NULL,
  hora_final TIME NULL,
  PRIMARY KEY(id_refeicao)
);

CREATE TABLE grupo (
  id_grupo INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  grupo VARCHAR NULL,
  PRIMARY KEY(id_grupo)
);

CREATE TABLE restaurante (
  id_restaurante INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  nome_restaurante VARCHAR NULL,
  PRIMARY KEY(id_restaurante)
);

CREATE TABLE status_usuario (
  id_status INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  nome_status VARCHAR NULL,
  PRIMARY KEY(id_status)
);

CREATE TABLE status_pagamento (
  id_status_pagamento INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  nome_status VARCHAR NULL,
  PRIMARY KEY(id_status_pagamento)
);

CREATE TABLE propagandas (
  id_propaganda INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  id_restaurante INTEGER UNSIGNED NOT NULL,
  data_inicio DATE NULL,
  data_fim DATE NULL,
  url_imagem VARCHAR NULL,
  PRIMARY KEY(id_propaganda),
  INDEX propagandas_FKrestaurante(id_restaurante),
  FOREIGN KEY(id_restaurante)
    REFERENCES restaurante(id_restaurante)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);

CREATE TABLE refeitorio (
  id_refeitorio INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  id_restaurante INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY(id_refeitorio),
  INDEX refeitorio_FKhistoricoacesso(id_restaurante),
  FOREIGN KEY(id_restaurante)
    REFERENCES restaurante(id_restaurante)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);

CREATE TABLE cardapio_desjejum (
  id_refeicao INTEGER UNSIGNED NOT NULL,
  data_refeicao DATE NULL,
  bebidas_q VARCHAR NULL,
  bebidas_q_veg VARCHAR NULL,
  achocolatado VARCHAR NULL,
  pao VARCHAR NULL,
  pao_veg VARCHAR NULL,
  complemento VARCHAR NULL,
  complemento_veg VARCHAR NULL,
  proteina VARCHAR NULL,
  proteina_veg VARCHAR NULL,
  fruta VARCHAR NULL,
  INDEX cardapio_desjejum_FKrefeicao(id_refeicao),
  FOREIGN KEY(id_refeicao)
    REFERENCES refeicao(id_refeicao)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);

CREATE TABLE cardapio_jantar (
  id_refeicao INTEGER UNSIGNED NOT NULL,
  data_refeicao DATE NULL,
  salada VARCHAR NULL,
  molho VARCHAR NULL,
  sopa VARCHAR NULL,
  pao VARCHAR NULL,
  prato_principal VARCHAR NULL,
  prato_veg VARCHAR NULL,
  complementos VARCHAR NULL,
  sobremesa VARCHAR NULL,
  refresco VARCHAR NULL,
  INDEX cardapio_jantar_FKrefeicao(id_refeicao),
  FOREIGN KEY(id_refeicao)
    REFERENCES refeicao(id_refeicao)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);

CREATE TABLE administrador (
  id_admin INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  id_restaurante INTEGER UNSIGNED NOT NULL,
  nome_admin VARCHAR NULL,
  senha_admin VARCHAR NULL,
  PRIMARY KEY(id_admin),
  INDEX administrador_FKrestaurante(id_restaurante),
  FOREIGN KEY(id_restaurante)
    REFERENCES restaurante(id_restaurante)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);

CREATE TABLE cardapio_almoco (
  id_refeicao INTEGER UNSIGNED NOT NULL,
  data_refeicao DATE NULL,
  salada VARCHAR NULL,
  molho VARCHAR NULL,
  prato_principal VARCHAR NULL,
  guarnicao VARCHAR NULL,
  prato_veg VARCHAR NULL,
  acompanhamentos VARCHAR NULL,
  sobremesa VARCHAR NULL,
  refresco VARCHAR NULL,
  INDEX cardapio_almoco_FKrefeicao(id_refeicao),
  FOREIGN KEY(id_refeicao)
    REFERENCES refeicao(id_refeicao)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);

CREATE TABLE usuario (
  id_usuario INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  id_status INTEGER UNSIGNED NOT NULL,
  id_grupo INTEGER UNSIGNED NOT NULL,
  matricula_usuario INTEGER UNSIGNED NULL,
  nome_usuario VARCHAR NULL,
  cpf VARCHAR(11) NULL,
  email_usuario VARCHAR NULL,
  PRIMARY KEY(id_usuario),
  INDEX usuario_FKgrupo(id_grupo),
  INDEX usuario_FKstatus(id_status),
  FOREIGN KEY(id_grupo)
    REFERENCES grupo(id_grupo)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(id_status)
    REFERENCES status_usuario(id_status)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);

CREATE TABLE preco_refeicao (
  id_preco_refeicao INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  id_refeicao INTEGER UNSIGNED NOT NULL,
  id_grupo INTEGER UNSIGNED NOT NULL,
  preco_refeicao DECIMAL NULL,
  PRIMARY KEY(id_preco_refeicao),
  INDEX preco_refeicao_FKIndex1(id_refeicao),
  INDEX preco_refeicao_FKIndex2(id_grupo),
  FOREIGN KEY(id_refeicao)
    REFERENCES refeicao(id_refeicao)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(id_grupo)
    REFERENCES grupo(id_grupo)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);

CREATE TABLE historico_acesso (
  id_historico INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  id_preco_refeicao INTEGER UNSIGNED NOT NULL,
  id_usuario INTEGER UNSIGNED NOT NULL,
  id_refeitorio INTEGER UNSIGNED NOT NULL,
  data_entrada DATETIME NULL,
  data_saida DATETIME NULL,
  matricula INTEGER UNSIGNED NULL,
  id_grupo INTEGER UNSIGNED NULL,
  preco_refeicao DECIMAL NULL,
  PRIMARY KEY(id_historico),
  INDEX historico_acesso_FKrefeitorio(id_refeitorio),
  INDEX historico_acesso_FKusuario(id_usuario),
  INDEX historico_acesso_FKIndex3(id_preco_refeicao),
  FOREIGN KEY(id_refeitorio)
    REFERENCES refeitorio(id_refeitorio)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(id_usuario)
    REFERENCES usuario(id_usuario)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(id_preco_refeicao)
    REFERENCES preco_refeicao(id_preco_refeicao)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);

CREATE TABLE historico_lotacao (
  id_refeitorio INTEGER UNSIGNED NOT NULL,
  qtd_pessoas INTEGER UNSIGNED NULL,
  tempo_medio INTEGER UNSIGNED NULL,
  INDEX historico_lotacao_FKrefeitorio(id_refeitorio),
  FOREIGN KEY(id_refeitorio)
    REFERENCES refeitorio(id_refeitorio)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);

CREATE TABLE carteira_usuario (
  id_carteira INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  id_usuario INTEGER UNSIGNED NOT NULL,
  saldo DECIMAL NULL,
  PRIMARY KEY(id_carteira),
  INDEX carteira_usuario_FKusuario(id_usuario),
  FOREIGN KEY(id_usuario)
    REFERENCES usuario(id_usuario)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);

CREATE TABLE historico_compra (
  id_historico INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  id_status_pagamento INTEGER UNSIGNED NOT NULL,
  id_usuario INTEGER UNSIGNED NOT NULL,
  data_compra DATETIME NULL,
  valor_compra DECIMAL NULL,
  saldo_inserido BOOL NULL,
  origem_caixa BOOL NULL,
  PRIMARY KEY(id_historico),
  INDEX historico_compra_FKusuario(id_usuario),
  INDEX historico_compra_FKstatuspgto(id_status_pagamento),
  FOREIGN KEY(id_usuario)
    REFERENCES usuario(id_usuario)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(id_status_pagamento)
    REFERENCES status_pagamento(id_status_pagamento)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);


