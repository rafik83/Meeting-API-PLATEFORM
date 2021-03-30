# Découpage Macro du projet

## Serveur

Tout le code pour la partie Serveur du projet ce situe dans le dossier `server`, il s'agit d'une application Symfony.

Au niveau du dossier `server/src` on retrouve un découpage "Métier":

- Admin : Code pour toute la partie administration du projet
- Api : Code pour l'api (utilisant api-platform)
- Common : Des classes utilitaires pouvant être réutiliser sur d'autre projet (Pagination, Contraint de validation générique, ...)
- Core : Le coeur de l'application (Principalement Entité et Repository)
- Vimeet : Code permettant de communiquer avec le projet Vimeet (par exemple : import / export des nomenclatures au format Vimeet)

## Client

Soon...
