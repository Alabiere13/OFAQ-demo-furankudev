# Projet FAQ-O-Clock - Franck MULLER - 04/03/2019 au 12/03/2019

## Objectif

Développer un site de questions/réponses sur le modèle de Quora, ou encore StackOverflow : La FAQ-O-Clock

## Entités principales

    + Utilisateurs
        * Nom d'utilisateur
        * Email
        * Mot de passe
        * Statut
        * Vote question (bonus)
        * Vote réponse (bonus)
    + Questions
        * Auteur/Utilisateur
        * Intitulé
        * Corps de la question
        * Date
        * Statut
    + Réponses (plusieurs possibles par question)
        * Auteur/Utilisateur
        * Corps de la réponse
        * Date
        * Validation
        * Statut
        * Question
    + Catégorie
        * Intitulé
        * Statut 

## Fonctionnalités attendues

    + Validation d'une réponse par l'auteur de la question
    + Réponses validées en premier et distinctes
    + Modération des questions et réponses
    + Un nuage de tags sur la page d'accueil ou dans une sidebar
    + Flash messages
    + Navigation adaptée à l'utilisateur
    + Fixtures pour la création des données
    + Documentation avec identifiants et mots de passe

## Bonus à garder en tête

    + Vote par utilisateur et par question
    + Vote par utilisateur et par réponse
    + Tri par nombre de votes décroissant
    + Requête AJAX (vote)
    + Pagination (7 questions par page)

## Routes

| URL | Méthode HTTP | Controller | Méthode | Titre | Contenu | Commentaire |
|--|--|--|--|--|--|--|
| `/` | `GET` | `QuestionController` | `index` | Acceuil | Voir toutes les questions (les plus récentes d'abord) et les tags associés | Visiteur et + |
| `/question/tag/{id}` | `GET` | `QuestionController` | `indexByTag` | Questions par tag | Voir toutes les questions (les plus récentes d'abord) liées à un tag défini | Visiteur et + |
| `/question/new` | `GET & POST` | `QuestionController` | `new` | Question - ajouter | Formulaire pour ajouter une question et définir des tags | Utilisateur et + |
| `/question/{id}/show` | `GET` | `QuestionController` | `show` | Question - afficher | Voir la question, avec toutes ses réponses et les tags associés | Visiteur et + |
| `/question/{id}` | `GET & POST` | `QuestionController` | `edit` | Question - modifier | Formulaire pour gérer ou modifier une question | Utilisateur et + |
| `/question/{id}` | `PUT` | `QuestionController` | `editStatus` | Question - modifier le statut | Lien du bouton pour bloquer ou débloquer une question | Modérateur et + |
| `/question/{id}` | `DELETE` | `QuestionController` | `delete` | Question - supprimer | Lienpour supprimer une question | Utilisateur et + |
|--|--|--|--|--|--|--|
| `/question/{id}/answer/new` | `POST` | `AnswerController` | `new` | Réponse - ajouter | Formulaire pour ajouter une réponse à une question | Utilisateur et + |
| `/question/{id}/answer/{id}` | `GET & POST` | `AnswerController` | `edit` | Réponse - modifier | Formulaire pour gérer ou modifier une réponse | Utilisateur et + |
| `/question/{id}/answer/{id}` | `PUT` | `AnswerController` | `editStatus` | Réponse - modifier le statut | Lien du bouton pour bloquer ou débloquer une réponse | Modérateur et + |
| `/question/{id}/answer/{id}` | `DELETE` | `AnswerController` | `delete` | Réponse - supprimer | Lien pour supprimer une réponse | Utilisateur et + |
|--|--|--|--|--|--|--|
| `/login` | `GET` | `SecurityController` | `login` | Connexion | Formulaire de connexion | Visiteur |
| `/logout` | `GET` | `SecurityController` | `-` | Déconnexion | - | Utilisateur et +, pas de méthode, gestion via route et security.yaml |
|--|--|--|--|--|--|--|
| `/account` | `GET` | `UserController` | `account` | Mon profil - afficher | Consulter ses propres informations utilisateur, la liste de ses questions, et de ses réponses | Utilisateur et + |
| `/account/edit` | `GET & POST` | `UserController` | `edit` | Mon profil - modifier | Formulaire pour modifier ses propres informations utilisateur, la liste de ses questions, et de ses réponses | Utilisateur et + |
|--|--|--|--|--|--|--|
| `/backend/tag` | `GET` | `Backend\TagController` | `index` | Catégories - lister | Liste des catégories | Modérateur et + |
| `/backend/tag/{id}` | `GET & POST` | `Backend\TagController` | `edit` | Catégories - modifier | Formulaire pour modifier une catégorie | Modérateur et + |
| `/backend/tag/{id}` | `PUT` | `Backend\TagController` | `editStatus` | Catégories - modifier le statut | Lien du bouton pour modifier le statut d'une catégorie | Modérateur et + |
| `/backend/tag/{id}` | `DELETE` | `Backend\TagController` | `delete` | Catégories - supprimer | Lien pour supprimer une catégorie | Modérateur et + |
|--|--|--|--|--|--|--|
| `/backend/user` | `GET` | `Backend\UserController` | `index` | Utilisateurs - lister | Liste des utilisateurs | Administrateur |
| `/backend/user/{id}` | `GET & POST` | `Backend\UserController` | `edit` | Utilisateurs - modifier | Formulaire pour modifier un utilisateur | Administrateur |
| `/backend/user/{id}` | `PUT` | `Backend\UserController` | `editStatus` | Utilisateurs - modifier le statut | Lien du bouton pour modifier le statut d'un utilisateur | Administrateur |
| `/backend/user/{id}` | `DELETE` | `Backend\UserController` | `delete` | Utilisateurs - supprimer | Lien pour supprimer un utilisateur | Administrateur |