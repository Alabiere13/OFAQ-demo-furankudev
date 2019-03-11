# Projet FAQ-O-Clock - Franck MULLER

## Trello : https://trello.com/b/EWBHIAlo/projet-faq-o-clock-franck-muller-04-03-2019-au-12-03-2019

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

## 08/03/2019

### Avancées :

    + Ajout modération sur questions et réponses
    + Ajout système de vote sur la page question
    + Modérateur peut voir les questions et réponses bloquées
    + Ajout des votes dans les fixtures
    + Correctif des fixtures pour ne plus avoir à commenter l'entity par rapport à l'array collection

### Difficultés :

    - Organisation du code pour gérer le vote sur la question et le nombre de votes pour la questions, car la table vote a une valeur true ou false (en cas d'annulation du vote)

## 10/03/2019

### Avancées :

    + Ajout menu dynamique pour l'administration (user pour admin et user et tags pour modérateur et admin)
    + Templates Admin users et tags
    + Ajout, modificatio, suppression de tag
    + Toggle statut d'un tag
    + Toggle statut d'un utilisateur / modérateur en tant qu'admin
    + Flash messages manquants



### Difficultés :

    - Mise en place de la pagination via un bundle, abandon

## 11/03/2019

### Avancées :

    + Gestion de la pagination manuelle via repository, controller et template
    + Gestion page précedente et suivante en fonction du numéro de page
    + Ajout des liens vers les numéros de pages existants
    + Gestion des droits utilisateurs sur Security yaml
    + Corrections de petits bugs (mot de passe modifié lors d'un edit du profil, ...) suite aux tests et vérification du respect du cahier des charges
    + Gestion erreur 404 et ajout page custom
    + Création d'une colonne Slug dans Question et de l'utilitaire en version améliorée (gestion signes spéciaux)
    + Ajout du slug dans les fixtures
    + Organisation du code de fixtures en méthodes privates appelées dans load
    + Création d'un listener pour gestion automatique du slug au new et edit, ajout de la gestion du updatedAt sur toutes les entités (sauf Role)
    + Création d'un subscriber pour faire apparaître la question la plus consultée dans les vues générées via QuestionController
    + Gestion du style des questions ou réponses bloquées par la modération pour les différencier dans les listes en tant que modo
    + Optimisation des customs queries pour gérer à la fois la pagination et la modération dans index de Questions



### Difficultés :

    - Gestion des évènements prePersist et Update via Subscriber, passage vers Listener pour corriger le problème