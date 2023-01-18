# L'approche DDD

## Definition

## Pourquoi ?
Model propre au métier
Proteger les regles métiers du domaine
Pas de dépendance avec la couche infrastructure (BDD, API...)
Architecture facile et lisible


# Comment adopter

## Connaitre les bonnes pratiques de developpement
## SOLID
## TDD
## PATTERN
## ARCHITECTURE

# Notion du DDD

## Cas d'utilisation

## Tactical pattern

https://blog.engineering.publicissapient.fr/2018/06/25/craft-les-patterns-tactiques-du-ddd/#:~:text=Un%20Aggregate%20est%20un%20ensemble,une%20m%C3%A9thode%20de%20la%20racine.

## Strategy pattern
BC, Ubiqutous langage, context map

## CQS

## Command Bus / Query Bus / Conteneur d'injection de dépendance

## Port/Adaptor

## Clean archi

### Domain
### Couche Applicative
### Couche Infra

## Rituel
event storming

# Point d'attention

## Pas de fuite objet métier
Aucun objet métier doit sortir du domaine. Excepté la couche applicative qui les manipules (UseCase)

## Inversion de dépendance
Les classes d'implémentation non lié au domaine (api, repo) doivent etre interfacées et seule l'interface est injectée dans la couche applicative


## Pas de silver bullet
90% des projets des juniors en DDD sont échoués. Il faut pratiquer et faire évoluer sa démarche. Du moment ou les tests sont là, nous pouvons refactoriser sans soucis.

## Toujours réfléchir en métier
Ne pas écrire du code inutile et croire que le métier le veut!

## Doit facilité le developpement