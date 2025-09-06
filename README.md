# School Deliberation App (Code Vanilla)

Une application simple de délibération scolaire construite avec PHP/HTML/CSS/JS vanilla.
Ce projet permet de gérer les étudiants, les cours et les données de délibération académique.

## Fonctionnalités

- Authentification des utilisateurs (création d’un utilisateur admin)
- Gestion des étudiants (CRUD)
- Gestion des cours
- Configuration de la base de données via constantes
- Seeders pour les données d’exemple
- Gestion des erreurs et amélioration du style
- Code propre, minimaliste et en PHP vanilla

## Installation

1. Cloner le dépôt :

   ```bash
   git clone https://github.com/laurentmwana/school-deliberation-app-vanilla
   ```

2. Accéder au dossier du projet :

   ```bash
   cd school-deliberation-app
   ```

3. Définir les informations de connexion à la base de données dans le fichier de configuration :

   ```php
   const DB_NAME     = 'nom_de_votre_base';
   const DB_USERNAME = 'votre_utilisateur';
   const DB_PWD      = 'votre_mot_de_passe';
   ```

4. Importer la base de données avec le fichier `database.sql` :

   ```bash
   mysql -u username -p database_name < database.sql
   ```

5. Exécuter le seeder pour remplir la base avec les données initiales :

   ```bash
   php seeder.php
   ```

6. Informations par défaut de l’utilisateur admin :

   ```text
   username: admin
   password: admin123
   ```

7. Lancer l’application avec le serveur PHP local :

   ```bash
   php -S localhost:8000 -t public
   ```

## Utilisation

- Accéder à l’application dans votre navigateur à l’adresse `http://localhost:8000`.
- Se connecter avec l’utilisateur admin pour gérer les étudiants et les cours.
- Effectuer des opérations CRUD sur les étudiants et les cours.
- Consulter et gérer les résultats des délibérations académiques.

## Contribution

- Forker le dépôt et créer une nouvelle branche pour vos fonctionnalités.
- Committer vos changements et pousser sur votre branche.
- Soumettre une pull request pour revue.

## Licence

Ce projet est sous licence MIT.
