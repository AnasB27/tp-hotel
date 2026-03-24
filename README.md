# 🏨 Système de Gestion Hôtelière - Outil Interne (TP 2026)

## 📋 Présentation du Projet
Ce projet consiste en le développement d'une application Web de gestion de réservations hôtelières . L'objectif est de fournir un outil interne permettant d'enregistrer des clients, de créer des réservations et d'y associer plusieurs chambres simultanément.

---

## 🏗️ Architecture : Le Modèle MVC
Le projet adopte une architecture **MVC (Modèle-Vue-Contrôleur)** pour assurer une maintenance évolutive et une séparation nette des responsabilités :

* **Model (`/models`)** : Contient exclusivement la logique d'accès aux données et les requêtes SQL (CRUD).
* **View (`/views`)** : Gère l'affichage HTML et l'interaction utilisateur via des formulaires POST.
* **Controller (`/controllers`)** : Orchestre la logique métier, valide les données (if/else) et gère les redirections.

Le système utilise un **point d'entrée unique (`index.php`)** agissant comme un routeur basé sur un paramètre `slug`.

---

## 🛡️ Sécurité & Implémentation Technique

### 1. PDO & Requêtes Préparées
Conformément aux objectifs techniques[cite: 12], l'interaction avec MySQL s'effectue via l'extension **PDO** :
* **Prévention des Injections SQL** : Utilisation systématique de `prepare()` et `execute()`. Les données utilisateurs ne sont jamais concaténées directement dans les requêtes.
* **Transactions SQL** : La création d'une réservation impliquant plusieurs tables (`reservation` et `reservation_chambre`) est sécurisée par un bloc `try/catch` avec `beginTransaction()` et `commit()` pour garantir l'atomicité de l'opération.

### 2. Sécurisation de l'affichage (XSS)
L'affichage des données issues de la base de données est systématiquement filtré via une fonction d'échappement globale:
* **Fonction `e()`** : Encapsule `htmlspecialchars()` pour neutraliser les caractères spéciaux HTML.
* **Syntaxe** : `<?= e($donnee) ?>` est utilisé dans toutes les vues pour prévenir les failles Cross-Site Scripting.

### 3. Navigation Factorisée
La navigation est centralisée dans le fichier `nav.php`, inclus dynamiquement sur chaque page via le routeur principal.

---

## 🧠 Logique Métier & Fonctions de Validation

L'application intègre des règles de gestion strictes validées côté serveur[cite: 14, 80]:

* **Vérification de la Majorité** : Lors de l'ajout d'un client, le système calcule l'âge via l'objet PHP `DateTime` pour bloquer l'enregistrement des mineurs.
* **Vérification du Chevauchement (Overlap)** : Une fonction dédiée `isRoomAvailable()` vérifie qu'aucune chambre sélectionnée n'est déjà occupée sur la période demandée.
* **Validation Chronologique** : 
    * [cite_start]La date d'arrivée doit être strictement antérieure à la date de départ[cite: 81].
    * La réservation ne peut pas être effectuée à une date passée (comparaison avec `date('Y-m-d')`).
* **Contrainte de Sélection** : Une réservation doit obligatoirement comporter au moins une chambre associée[cite: 82].

---

## 📂 Modèle de Données (Schéma SQL)
Le projet repose sur 4 tables interconnectées:
1.  **`client`** : Informations personnelles (nom, prenom, email, tel, adresse, date_naissance) .
2.  **`chambre`** : Répertoire des unités (numero, type) .
3.  **`reservation`** : Entité pivot liant un client à une période .
4. **`reservation_chambre`** : Table de liaison gérant la relation Many-to-Many entre réservations et chambres .

---

## 🚀 Installation & Lancement
1.  Importer le script `hotel.sql` dans votre gestionnaire de base de données.
2.  Configurer les identifiants de connexion dans `config/database.php`.
3.  Exécuter le projet via un serveur local (WAMP/MAMP) sur `index.php`.
