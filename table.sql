CREATE DATABASE takalo;
USE takalo;
CREATE TYPE statut_echange AS ENUM ('en attente', 'refuse', 'accepte');

-- Table Catégorie
CREATE TABLE Categorie(
    id_categorie SERIAL PRIMARY KEY,
    nom_categorie VARCHAR(100) NOT NULL
);

-- Table Utilisateur (note: "User" est un mot réservé, on utilise "Utilisateur")
CREATE TABLE Utilisateur(
    id_user SERIAL PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    mdp_hash VARCHAR(255) NOT NULL,
    type_user VARCHAR(20) CHECK (type_user IN ('normal', 'admin')) DEFAULT 'normal'
);

-- Table Objet
CREATE TABLE Objet(
    id_objet SERIAL PRIMARY KEY,
    nom_objet VARCHAR(100) NOT NULL,
    id_categorie INT NOT NULL,
    id_user INT NOT NULL,
    date_acquisition DATE,
    prix_estime DECIMAL(10,2),
    FOREIGN KEY (id_categorie) REFERENCES Categorie(id_categorie) ON DELETE CASCADE,
    FOREIGN KEY (id_user) REFERENCES Utilisateur(id_user) ON DELETE CASCADE
);

-- Table Echange
CREATE TABLE Echange(
    id_echange SERIAL PRIMARY KEY,
    id_user_1 INT NOT NULL,
    id_user_2 INT NOT NULL,
    date_demande DATE DEFAULT CURRENT_DATE,
    date_finalisation DATE,
    statut statut_echange DEFAULT 'en attente',
    FOREIGN KEY (id_user_1) REFERENCES Utilisateur(id_user) ON DELETE CASCADE,
    FOREIGN KEY (id_user_2) REFERENCES Utilisateur(id_user) ON DELETE CASCADE,
    CHECK (id_user_1 <> id_user_2) -- Empêche un échange avec soi-même
);

-- Table Echange_fille (détails des objets échangés)
CREATE TABLE Echange_fille(
    id_echange_fille SERIAL PRIMARY KEY,
    id_echange_mere INT NOT NULL,
    id_objet INT NOT NULL,
    quantite INT DEFAULT 1 CHECK (quantite > 0),
    id_proprietaire INT NOT NULL,
    FOREIGN KEY (id_echange_mere) REFERENCES Echange(id_echange) ON DELETE CASCADE,
    FOREIGN KEY (id_objet) REFERENCES Objet(id_objet) ON DELETE CASCADE,
    FOREIGN KEY (id_proprietaire) REFERENCES Utilisateur(id_user) ON DELETE CASCADE
);