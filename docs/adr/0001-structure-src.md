# Découpage du dossier `src`

- Statut : accepté
- Date : 26/01/2021

## Contexte et définition du problème

Pour tout nouveau projet, on doit décider si on suit les conventions proposées par Symfony ou si on part sur quelque chose d'un peu plus haut niveau

## Options envisagées

### Architecture Hexagonale

- Découpage métier fort
- Beaucoup de dossier au départ
- Prise en main plus compliqué par un débutant (car ne respecte pas la convention Symfony)
- Adapter pour un gros projet, car on peut redécouper les besoins metiers

Contenu du dossier `src`

```
Application
    Command
    Query
    View
Domain
    Entity
    Repository
Infrastructure
    Controller
    Repository
    Bridge
    ...
```

### Architecture Symfony Classique

- Découpage technique uniquement
- Facile à prendre en main part un débutant
- Peu adapter pour un gros projet

```
Controller
Entity
Repository
...
```

## Décision 

**Architecture Hexagonale** pour garder une cohérence par rapport au code de Vimeet qui fonctionne toujours après quelques années
