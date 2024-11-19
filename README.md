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

Clonez le dépôt :
```sh
    git clone (https://github.com/bensaadmucret/pokedex)
    cd pokedex
```

Construisez et démarrez les conteneurs Docker :
 ```sh
    docker compose build --no-cache
    docker compose up --pull always -d --wait
    Ouvrez https://localhost sur votre navigateur Web préféré et 
    Acceptez le certificat TLS généré automatiquement
```
Installez les dépendances :
```sh
    docker compose exec php composer install
```
Pour arrêter les conteneurs Docker :
```sh
    docker compose down --remove-orphans
```
## Gestion de la Base de Données avec Doctrine

### Créer la base de données
## Utilisation

```sh
docker compose exec php bin/console doctrine:database:create
```

Pour créer les tables de la base de données :

```sh
docker compose exec php bin/console doctrine:schema:create
```

Générer une migration

```sh
docker compose exec php bin/console make:migration
- OU
docker compose exec php bin/console doctrine:migrations:diff
```

Appliquer les migrations

```sh
docker compose exec php bin/console doctrine:migrations:migrate
```
Vérifier le statut des migrations

```sh
docker compose exec php bin/console doctrine:migrations:status
```

Pour mettre à jour les tables de la base de données :

```sh
docker compose exec php bin/console doctrine:schema:update --force
```

Supprimer les tables de la base de données :

```sh
docker compose exec php bin/console doctrine:schema:drop
```

Supprimer la base de données :

```sh
docker compose exec php bin/console doctrine:database:drop
```

## Pour créer et synchroniser les Pokémon :

```sh
docker compose exec php bin/console app:sync-pokemon
```
## Pour spécifier des options :

```sh
docker compose exec php bin/console app:sync-pokemon --from=1 --to=100 --batch-size=20

from : L'ID de départ du Pokémon à synchroniser. Par défaut, 1.
to   : L'ID de fin du Pokémon à synchroniser.
batch-size : Le nombre de Pokémon à traiter en parallèle. Par défaut, 10.
```

## Un script shell pour automatiser l'exécution de la commande
### Pour exécuter le script avec des options :
```sh
./sync_pokemon.sh 1 100 20
```


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

## Contribution

Les contributions sont les bienvenues ! Si vous souhaitez contribuer à ce projet, veuillez suivre ces étapes :

1. Fork le dépôt.
2. Créez une branche pour votre fonctionnalité (`git checkout -b feature/ma-fonctionnalite`).
3. Commit vos modifications (`git commit -m 'Ajout de ma fonctionnalité'`).
4. Push vers la branche (`git push origin feature/ma-fonctionnalite`).
5. Ouvrez une Pull Request.

## Licence

Ce projet est sous licence MIT. Voir le fichier [LICENSE](LICENSE) pour plus de détails.
