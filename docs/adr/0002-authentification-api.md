# Stockage des informations de connexion entre l'api et le client

- Statut : accepté
- Date : 26/01/2021

## Contexte et définition du problème

Notre api a besoin de savoir qui fait les appels afin de renvoyer les bonnes informations

## Options envisagées

### Session / Cookie

- Le plus simple a mettre en place coté api
- Statefull (on doit garder l'information sur le token)

### JWT

- Plus compliqué à mettre en place (RefreshToken, ...)
- Stateless (toute les informations pour identifier l'utilisateur sont sur le token)

## Décision

**Session / Cookie**: car beaucoup plus simple a mettre en place au début du projet (il n'y a presque rien a faire)
