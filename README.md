Application de Réservation de Terrains Sportifs
Description

Cette application permet aux utilisateurs de rechercher et réserver des terrains sportifs selon différents critères (sport, ville, date). Elle affiche les centres sportifs disponibles, gère les réservations en fonction des disponibilités, et conserve un historique des recherches pour améliorer l’expérience utilisateur. L’interface est responsive et simple d’utilisation.
Fonctionnalités principales

    🔍 Recherche de terrains par sport, ville et date

    📍 Affichage des centres sportifs disponibles

    📅 Réservation possible selon les disponibilités

    🧠 Historique des recherches stocké dans MongoDB

    💡 Interface responsive, adaptée aux mobiles, tablettes et ordinateurs

Technologies utilisées
Côté Frontend	Côté Backend	Base de données
HTML / CSS / JavaScript	Symfony (PHP 8+)	MongoDB (historique des recherches) + MySQL (gestion des terrains)
Installation

    Cloner le dépôt

git clone https://github.com/ton-compte/nom-du-projet.git
cd nom-du-projet

    Installer les dépendances backend

composer install

    Configurer la base de données

    MySQL : créer la base, importer le schéma des terrains et réservations.

    MongoDB : assurer la connexion pour l’historique des recherches.

    Configurer les variables d’environnement
    Copier .env.example en .env et adapter les paramètres (base de données, etc).

    Lancer le serveur Symfony

symfony server:start

    Ouvrir le frontend
    Le frontend est directement servi par Symfony ou en mode développement via un serveur HTTP (Apache, Nginx).

Utilisation

    Accéder à l’application via le navigateur à l’adresse locale indiquée.

    Rechercher un terrain selon le sport, la ville et la date.

    Visualiser les centres disponibles et réserver un créneau.

    Consulter son historique de recherches (enregistré automatiquement).

Architecture

    Backend : Symfony (PHP 8+), API REST pour gérer terrains, réservations, et historique.

    Frontend : HTML/CSS/JS, interface responsive, communique avec backend via AJAX/Fetch.

    Bases de données :

        MySQL pour les données structurées des terrains et réservations.

        MongoDB pour l’historique non relationnel des recherches utilisateurs.

Contribution

Les contributions sont les bienvenues !
Pour contribuer :

    Forker le projet

    Créer une branche de fonctionnalité (feature/ma-fonctionnalite)

    Faire une pull request détaillée

Licence

Ce projet est sous licence MIT. Voir le fichier LICENSE pour plus d’informations.
