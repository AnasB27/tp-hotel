CREATE DATABASE IF NOT EXISTS hotel_db;
USE hotel_db;

-- 1) Table client 
CREATE TABLE client (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    date_naissance DATE,
    adresse TEXT NOT NULL,
    code_postal VARCHAR(10),
    ville VARCHAR(50),
    email VARCHAR(100) NOT NULL,
    telephone VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
);

-- 2) Table chambre 
CREATE TABLE chambre (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero VARCHAR(10) UNIQUE NOT NULL, 
    type ENUM('simple', 'double', 'suite') NOT NULL 
);

-- 3) Table reservation 
CREATE TABLE reservation (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NOT NULL,
    date_arrivee DATE NOT NULL,
    date_depart DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (client_id) REFERENCES client(id) ON DELETE CASCADE 
);

-- 4) Table de liaison reservation_chambre 
CREATE TABLE reservation_chambre (
    reservation_id INT NOT NULL,
    chambre_id INT NOT NULL,
    PRIMARY KEY (reservation_id, chambre_id), -- Clé primaire composée 
    FOREIGN KEY (reservation_id) REFERENCES reservation(id) ON DELETE CASCADE,
    FOREIGN KEY (chambre_id) REFERENCES chambre(id) ON DELETE CASCADE,
    CONSTRAINT unique_chambre_reservation UNIQUE (reservation_id, chambre_id) -- Éviter les doublons 
);

INSERT INTO chambre (numero, type) VALUES 
('101', 'simple'), ('102', 'double'), ('201', 'suite'), ('202', 'double');