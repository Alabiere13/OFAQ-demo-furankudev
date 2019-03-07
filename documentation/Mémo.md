# Projet FAQ-O-Clock - Franck MULLER

## Utilisateurs pour les tests

    * User : moldu/moldu
    * Modérateur : lechuck/lechuck
    * Admin : vador/vador

## 04/03/2019

### Avancées :

    + Lecture de l'énoncé, synthèse d'un cahier des charges
    + Listing des routes
    + Création du MCD
    + Création du trello avec user stories et organisation perso

### Difficultés :

    - Logique des noms et méthodes des routes
    - Point le plus complet avant d'attaquer le code

## 05/03/2019

### Avancées :

    + Création des entités via maker et code
    + Paramètrage du .env et création de la BDD
    + Migrations
    + Controllers, méthodes (vides), templates (minimum), routes et tests
    + Fixtures pour chaque entité et tests
    + Utilisateurs de test
    + Custom Query pour home et tests

### Difficultés :

    - Choix de champs pour fonctionnalités potentielles (images, slug)
    - Anticiper les éléments à traiter dans le construct des entités

## 06/03/2019

### Avancées :

    + Installation thème Boostrap
    + Appel API dans Provider/Faker pour usernames de User
    + Template de base avec et sans sidebar
    + Template question index
    + Template question show
    + Affichage liste questions
    + Affichage question avec ses réponses
    + Toggle isValid sur Answer
    + Ajout fixtures pour table pivot Question-Catégorie
    + Affichage liste catégories
    + Affichage catégories d'une question

### Difficultés :

    - Oubli de make:user au lieu de make:entity pour User, régulation à la main

## 07/03/2019

### Avancées :

    + Création des FormTypes, paramétrage pour User, Question, Answer
    + Templates signin, account, edit account, ajout de question, ajout de réponse
    + Condition de login sur l'ajout de question ou de réponse
    + Condition d'être l'utilisateur à l'origine de la question pour la validation d'une réponse
    + Liste de questions par catégorie
    + Ajout event listener sur gestion du mot de passe de UserType
    + Correction du bug qui modifie le mot de passe à la modification de ses données de profil


### Difficultés :

    - Difficulté à venir sur la partie admin de user, qui devra gérer le rôle (désactivé pour la partie publique)