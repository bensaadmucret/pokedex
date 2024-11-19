#!/bin/bash

# Vérifiez si Docker Compose est installé
if ! [ -x "$(command -v docker-compose)" ]; then
  echo 'Erreur : Docker Compose n\'est pas installé.' >&2
  exit 1
fi

# Exécutez la commande Symfony dans le conteneur PHP
docker compose exec php bin/console app:sync-pokemon --from=$1 --to=$2 --batch-size=$3
