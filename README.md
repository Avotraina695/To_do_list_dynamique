# ToDo List Advanced

Une application web ToDo List avancée pour gérer vos tâches de manière efficace. Elle utilise HTML, CSS, Bootstrap, JavaScript et PHP pour le côté dynamique.

## Fonctionnalités principales

- Ajouter, éditer et supprimer des tâches
- Marquer les tâches comme terminées
- Filtrer les tâches (completed, all, pending)
- Stockage des tâches côté serveur avec PHP (persistantes)
- Interface responsive et agréable à utiliser

## Stack technique

- **Front-end** : HTML5, CSS3, Bootstrap 5, Font Awesome, JavaScript (modules ES natifs, sans framework)
- **Back-end** : PHP 8+, API REST, architecture en couches (Controller / Model / Database)
- **Base de données** : MySQL (via PDO)
- **Gestion des dépendances** : Composer (autoload PSR-4)

## Structure du projet
## Prérequis

- PHP >= 8.0
- MySQL
- Composer

## Installation

1. Cloner le projet :

```bash
git clone https://github.com/Avotraina695/To_do_list_dynamique.git
cd To_do_list_dynamique/src
```

2. Installer les dépendances PHP :

```bash
cd back-end
composer install
```

3. Créer la base de données et la table `tasks` :

```sql
CREATE DATABASE todo_app;

USE todo_app;

CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    status ENUM('pending', 'completed') NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

4. Vérifier/adapter les identifiants de connexion dans `back-end/core/Database.php` (`host`, `dbname`, `user`, `password`).

## Lancer le projet en local

Le back-end et le front-end doivent tourner sur **deux serveurs séparés**.

**Terminal 1 — back-end (API)**
```bash
cd src/back-end
php -S localhost:8000
```

**Terminal 2 — front-end**
```bash
cd src
php -S localhost:5500
```

Ouvrir ensuite `http://localhost:5500` dans le navigateur.

## Endpoints de l'API REST

| Méthode  | Endpoint       | Description                     |
|----------|----------------|----------------------------------|
| `GET`    | `/tasks`       | Liste toutes les tâches         |
| `POST`   | `/tasks`       | Crée une nouvelle tâche         |
| `PUT`    | `/tasks/{id}`  | Met à jour le statut d'une tâche|
| `DELETE` | `/tasks/{id}`  | Supprime une tâche              |

### Exemples

```bash
# Créer une tâche
curl -X POST http://localhost:8000/tasks \
  -H "Content-Type: application/json" \
  -d '{"title":"Faire les courses","status":"pending"}'

# Lister les tâches
curl http://localhost:8000/tasks

# Mettre à jour le statut
curl -X PUT http://localhost:8000/tasks/1 \
  -H "Content-Type: application/json" \
  -d '{"status":"completed"}'

# Supprimer une tâche
curl -X DELETE http://localhost:8000/tasks/1
```

## Auteur

Avotraina695

