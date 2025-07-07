# API Platform Exercise

## 📋 Description

Ce projet est un exercice de veille technologique sur **API Platform**, une solution complète pour créer des API REST et GraphQL avec Symfony. Il implémente une API de gestion de recettes avec les fonctionnalités CRUD complètes.

## 🚀 Fonctionnalités

- **API REST** complète pour la gestion des recettes
- **CRUD** : Création, lecture, mise à jour et suppression de recettes
- **Validation** des données avec Symfony Validator
- **Sérialisation** automatique des données
- **Tests** d'intégration avec PHPUnit
- **Documentation** API automatique avec OpenAPI/Swagger

## 🏗️ Architecture

Le projet suit une architecture hexagonale avec les couches suivantes :

### Entités
- **Recipe** : Entité principale représentant une recette
- **User** : Entité utilisateur pour la gestion des auteurs de recettes

### Énumérations
- **RecipeSkillLevel** : Niveau de difficulté des recettes (débutant, intermédiaire, expert)

### Use Cases
- **CreateRecipeUseCase** : Logique métier pour la création de recettes

### State Processors
- **RecipePostStateProcessor** : Traitement personnalisé lors de la création/modification

## 🛠️ Technologies utilisées

- **PHP 8.4**
- **Symfony 7.3.1**
- **API Platform 4.1.18**
- **Doctrine ORM 3.5.0**
- **PostgreSQL**
- **PHPUnit** pour les tests
- **Docker** pour l'environnement de développement
- **PHPStan** pour l'analyse statique
