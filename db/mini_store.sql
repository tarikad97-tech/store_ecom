DROP DATABASE IF EXISTS mini_store;
CREATE DATABASE mini_store CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE mini_store;

-- =========================
-- TABLE: categorie
-- =========================
CREATE TABLE categorie (
  id_cat INT NOT NULL AUTO_INCREMENT,
  nom_cat VARCHAR(255) NOT NULL,
  PRIMARY KEY (id_cat)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =========================
-- TABLE: produit
-- =========================
CREATE TABLE produit (
  id_pr INT NOT NULL AUTO_INCREMENT,
  nom_pr VARCHAR(255) NOT NULL,
  imgpr_pr VARCHAR(255) DEFAULT NULL,
  prix_pr DOUBLE DEFAULT NULL,
  id_cat INT NOT NULL,
  PRIMARY KEY (id_pr),
  KEY idx_produit_cat (id_cat),
  CONSTRAINT fk_produit_categorie
    FOREIGN KEY (id_cat) REFERENCES categorie(id_cat)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =========================
-- TABLE: client
-- =========================
CREATE TABLE client (
  id_cl INT NOT NULL AUTO_INCREMENT,
  nom_cl VARCHAR(255) NOT NULL,
  tel VARCHAR(30) NOT NULL,           -- mieux que INT (peut contenir +212, espaces, etc.)
  adresse VARCHAR(255) NOT NULL,
  PRIMARY KEY (id_cl)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =========================
-- TABLE: log (auth)
-- =========================
CREATE TABLE log (
  id_log INT NOT NULL AUTO_INCREMENT,
  email VARCHAR(255) NOT NULL,
  passeword VARCHAR(255) NOT NULL,    -- en pratique: hash (bcrypt) => 60+ chars
  id_cl INT NOT NULL,
  PRIMARY KEY (id_log),
  UNIQUE KEY uq_log_email (email),
  KEY idx_log_client (id_cl),
  CONSTRAINT fk_log_client
    FOREIGN KEY (id_cl) REFERENCES client(id_cl)
    ON UPDATE CASCADE
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =========================
-- TABLE: card (panier)
-- =========================
CREATE TABLE card (
  id_pa INT NOT NULL AUTO_INCREMENT,
  id_cl INT NOT NULL,
  PRIMARY KEY (id_pa),
  KEY idx_card_client (id_cl),
  CONSTRAINT fk_card_client
    FOREIGN KEY (id_cl) REFERENCES client(id_cl)
    ON UPDATE CASCADE
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =========================
-- TABLE: sous_card (lignes panier)
-- =========================
CREATE TABLE sous_card (
  id_sdpa INT NOT NULL AUTO_INCREMENT,
  id_pa INT NOT NULL,
  id_pr INT NOT NULL,
  PRIMARY KEY (id_sdpa),
  KEY idx_souscard_card (id_pa),
  KEY idx_souscard_produit (id_pr),
  CONSTRAINT fk_souscard_card
    FOREIGN KEY (id_pa) REFERENCES card(id_pa)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  CONSTRAINT fk_souscard_produit
    FOREIGN KEY (id_pr) REFERENCES produit(id_pr)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =========================
-- TABLE: img_pr (images produit)
-- =========================
CREATE TABLE img_pr (
  id_imgpr INT NOT NULL AUTO_INCREMENT,
  image VARCHAR(255) NOT NULL,
  id_pr INT NOT NULL,
  PRIMARY KEY (id_imgpr),
  KEY idx_imgpr_produit (id_pr),
  CONSTRAINT fk_imgpr_produit
    FOREIGN KEY (id_pr) REFERENCES produit(id_pr)
    ON UPDATE CASCADE
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
