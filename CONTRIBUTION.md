COMMENT CONTRIBUER AU PROJET ?
==============================

# Github

## Backlog
Retrouvez l'ensemble des [cas d'utilisation](https://github.com/TBoileau/code-challenge/labels/use%20case) dans la section [issues](https://github.com/TBoileau/code-challenge/issues).

Si vous avez un doute sur ce qu'est un cas d'utilisation, je vous invite à jeter un oeil [ici](docs/index.md#cas-dutilisation). 

## S'assigner un cas d'utilisation
Dans la section **issues** seront listés tous les cas d'utilisation, vous pouvez alors vous assigner un cas d'utilisation, mais il sera important de respecter les règles suivantes :
* Je veux prendre en charge un cas d'utilisation, je m'engage donc à la concevoir, responsabilisez-vous ! Ce n'est pas grave si vous ne pouvez pas la terminer mais prévenez-nous !
* Si aucun commit en 7 jours n'est fait après l'assignation, je supprimerais l'assignation
* Si aucun commit en 14 jours depuis le dernier commit n'est fait, je reprendrais le suite du développement
* Si vous avez le moindre doute sur la comphrésion du cas d'utilisation, n'hésitez pas à le dire en commentant l'**issue**

## Workflow
Vous venez de vous assigner un cas d'utilisation, quelle est la marche à suivre :
* Clonez le projet sur votre PC
* Situez-vous sur la branche `develop`
* Créez une nouvelle branche avec le prefix `feature/`, par exemple `feature/authentication`
* Implémenter et tester le cas d'utilisation
* Pousser votre feature sur **github**
* Une fois le cas d'utilisation terminé, faites une **pull request**
* On effectuera un **code review** de votre code, une fois validé

*Note : vous pouvez utiliser [git flow](https://danielkummer.github.io/git-flow-cheatsheet/index.fr_FR.html) pour vous simplifier la vie !*

Règles :
* Toujours partir de la branche `develop` pour implémenter un nouveau cas d'utilisation
* Toujours prefixer le nom de vos branche par `feature/`
* Pensez à *push* votre **feature** pour que l'on puisse son avancement, attention on n'est pas la pour fliquer. 
* Ne jamais proposer de **pull request** si le code n'est pas testé

# Bonnes pratiques
Il est essentiel de respecter les bonnes pratiques suivantes :
* Appliquer le [PSR-12](https://www.php-fig.org/psr/psr-12/)
* Respecter les [bonne pratiques de Symfony](https://symfony.com/doc/current/best_practices.html) dans la mesure du possible
* Pratiquer le [Test driven development](docs/tdd.md)
* Suivre l'architecture mise en place : [Clean architecture](docs/index.md#clean-architecture)

**Vous avez le moindre doute, c'est normal, cela ne doit pas vous empécher de contribuer, on est tous là pour apprendre. N'hésitez surtout pas à poser vos questions, que ce soit en live sur [Twitch](https://www.twitch.tv/toham) ou sur le [Discord](https://discord.gg/AMd6d4a).**
