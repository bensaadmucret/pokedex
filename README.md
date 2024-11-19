# Projet Pokedex

Ce projet a été créé pour récupérer, afficher et interagir avec des données de Pokémon en utilisant une architecture moderne basée sur Symfony et Docker.

## Objectif

L'objectif est de fournir une interface utilisateur intuitive pour visualiser les Pokémon et de permettre des interactions via une API RESTful.

## Contraintes

### Technologies et Composants

- **PHP** : Version 8.3
- **Base de données** : PostgreSQL
- **Framework** : Symfony 7.1
- **Gestionnaire de ressources** : Webpack Encore
- **CSS** : Tailwind CSS

### Commande de Récupération des Pokémons

- Développer une commande Symfony pour récupérer une liste de Pokémon depuis l'API publique [PokeAPI](https://pokeapi.co/).
- Récupérer 100 Pokémons aléatoires à chaque exécution.
- Créer ou mettre à jour les Pokémon dans la base de données.
- Gérer les erreurs de récupération avec des messages clairs.

### Affichage de la Liste des Pokémons

- Utiliser Live Components pour le rendu dynamique de la liste.
- Afficher les informations de chaque Pokémon (nom, image, type(s), taille).
- Ajouter des fonctionnalités de recherche, tri et filtre par type.

### Création d’un Point d’API pour les Combats (Optionnel)

- Créer un point d'API custom avec ApiPlatform pour simuler un combat entre deux Pokémons.
- Définir un algorithme de combat basé sur les caractéristiques des Pokémons.
- Renvoyer le gagnant du combat et les détails du combat.
- Gérer les erreurs proprement (ex. : si un ID de Pokémon n’existe pas).

## Installation

1. Clonez le dépôt :
    ```sh
    git clone <URL_DU_DEPOT>
    cd <NOM_DU_PROJET>
    ```

2. Construisez et démarrez les conteneurs Docker :
    ```sh
    docker compose build --no-cache
    docker compose up --pull always -d --wait

    ```
3. Installez les dépendances :
    ```sh
    docker compose exec php composer install
    ```
4. Créez les tables de la base de données :
    ```sh
    docker compose exec php bin/console doctrine:schema:create
    ```
Pour arrêter les conteneurs Docker :
    ```sh
    docker compose down --remove-orphans
    ```

## Utilisation

### Commandes Makefile

Le Makefile fournit plusieurs commandes pour faciliter le développement et la gestion des conteneurs Docker.

- **Afficher l'aide** :
    ```sh
    make help
    ```

- **Construire les images Docker** :
    ```sh
    make build
    ```

- **Démarrer les conteneurs Docker en mode détaché** :
    ```sh
    make up
    ```

- **Construire et démarrer les conteneurs Docker** :
    ```sh
    make start
    ```

- **Arrêter les conteneurs Docker** :
    ```sh
    make down
    ```

- **Afficher les logs en direct** :
    ```sh
    make logs
    ```

- **Se connecter au conteneur FrankenPHP** :
    ```sh
    make sh
    ```

- **Se connecter au conteneur FrankenPHP via bash** :
    ```sh
    make bash
    ```

- **Exécuter les tests avec PHPUnit** :
    ```sh
    make test c="--group e2e --stop-on-failure"
    ```

- **Exécuter une commande Composer** :
    ```sh
    make composer c='req symfony/orm-pack'
    ```

- **Installer les dépendances Composer** :
    ```sh
    make vendor
    ```

- **Lister toutes les commandes Symfony ou exécuter une commande Symfony spécifique** :
    ```sh
    make sf c=about
    ```

- **Vider le cache Symfony** :
    ```sh
    make cc
    ```

## Développement

Pour développer l'application, vous pouvez utiliser les commandes Makefile pour interagir avec les conteneurs Docker et exécuter des commandes Symfony et Composer.

## Contribution

Les contributions sont les bienvenues ! Si vous souhaitez contribuer à ce projet, veuillez suivre ces étapes :

1. Fork le dépôt.
2. Créez une branche pour votre fonctionnalité (`git checkout -b feature/ma-fonctionnalite`).
3. Commit vos modifications (`git commit -m 'Ajout de ma fonctionnalité'`).
4. Push vers la branche (`git push origin feature/ma-fonctionnalite`).
5. Ouvrez une Pull Request.

## Licence

Ce projet est sous licence MIT. Voir le fichier [LICENSE](LICENSE) pour plus de détails.
