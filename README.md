<a href="https://codeclimate.com/github/klawuy/TravisTest/coverage"><img src="https://codeclimate.com/github/klawuy/TravisTest/badges/coverage.svg" /></a>
<img src="https://travis-ci.org/klawuy/TravisTest.svg?branch=master">

# Projet de base d'un projet PHP avec Travis
Projet vide permettant d'avoir une base dans la création d'applications en PHP avec un Framework Joomla!

# Installation
Quatre fichiers (à la racine du projet) sont primordiaux pour le bon fonctionnement projet:
  - ``` .travis.yml ```       -> Pour le fonctionnement de Travis (fichier de config)
  - ``` .codeclimate.yml ```  -> Pour le fonctionnement de Code Climate
  - ``` composer.json ```     -> Pour le fonctionnement de Composer
  - ``` phpunit.xml ```       -> Fichier d'indication de l'emplacement des tests unitaires
  
# Travis
Tout d'abord, aller sur https://travis-ci.org/ et se connecter avec son compte GitHub.<br>
Activer le projet sur lequel on souhaite que Travis travaille.<br>
Lors d'un push sur le projet GitHub, Travis va chercher le fichier .travis.yml pour savoir ce qu'il doit faire. C'est le centre de l'intégration continue, c'est lui qui va lancer Composer et PHPUnit.<br>
Il est également possible de configurer des tâches CRON pour tester le projet toutes les semaines, tous les mois...<br>

# Composer
(Composer requiert un ```composer install``` à la première utilisation).<br>
Grâce à la commande ```composer update``` présente dans le fichier Travis, à chaque push sur une branche Travis va executer composer pour aller chercher les dernières versions des packages utiles au projet. <br>
Le fichier Travis éxécute également la commande ```composer self-update``` permettant à composer de faire une update de lui-même avant de faire une update des packages.<br>

# PHPUnit & CodeClimate
La partie intéressante de l'intégration continue est d'effectuer des tests unitaires à chaque push sur une branche pour voir si les modifications n'ont pas impacté d'autres fonctionnalités de l'application.<br>
PHPUnit est également lancé grâce à une commande présente dans le fichier .travis.yml<br>
Pour se faire nous utilisons PHPUnit qui permet de faire des tests unitaires en PHP. Ce package fonctionne grâce au fichier phpunit.xml qui indique l'emplacement des dossiers de tests à éxécuter.<br>

Cependant il faut un outil pour tester que tous les tests unitaires sont réalisés et également pour savoir quelle est la couverture de tests du projet. C'est pour cela que nous utiliserons CodeClimate qui permet de faire un "CodeCoverage". Il faut également se logger sur https://codeclimate.com avec ses identifiants GitHub pour définir quel est le projet à tester. Un commande dans le fichier Travis éxécute le codeclimate après que le script de tests unitaires se soit éxécuté.<br>

Référence pour l'apprentissage de PHPUnit: https://jtreminio.com/2013/03/unit-testing-tutorial-introduction-to-phpunit/ <br>
Référence pour la connexion entre CodeClimate et GitHub: https://docs.codeclimate.com/v1.0/docs/github <br>
Référence pour le lancement automatique de CodeClimate: https://docs.codeclimate.com/v1.0/docs/travis-ci-php-test-coverage <br>
Référence pour la connexion entre CodeClimate et Slack: https://docs.codeclimate.com/v1.0/docs/slack-integration <br>

# Résultats (GitHub et Slack)
Les résultats des tests en intégration continue sont disponibles sur http://travis-ci.org, cependant pour rendre plus facile l'accès au résultat, ce dernier est également présent sur GitHub par l'affichage d'un check vert ou d'une croix rouge à côté du nom du commit (au clic dessus nous sommes redirigés sur Travis), mais ils peuvent également être pushés sur un channel Slack qui reprend les éléments importants du commit (son nom, l'URL du résultat, le succès ou l'échec, le numéro de commit, le créateur du commit...).<br>

Référence pour la connexion entre Travis et Slack: https://docs.travis-ci.com/user/notifications/#Configuring-slack-notifications <br>

## Conseil dans la création de tests unitaires
La structure du dossier de l'application et du dossier de test doit être la même, exemple:<br>
Application:<br>
./phpUnitTutorial/Foo.php<br>
./phpUnitTutorial/Bar.php<br>
./phpUnitTutorial/Controller/Baz.php<br><br>
Dossier de test:<br>
./phpUnitTutorial/Test/FooTest.php<br>
./phpUnitTutorial/Test/BarTest.php<br>
./phpUnitTutorial/Test/Controller/BazTest.php<br>
<br>
Un fichier de test est composé du nom du fichier de l'application suivi de "Test" comme dans l'exemple précédent.<br>
<br>
Les méthodes de test doivent commencer par "test" suivi du nom de la méthode, suivi de ce qui est testé (en cas d'erreur il est plus facile de retrouver l'endroit où l'erreur apparait: <strong>pas d'abbréviations</strong>)<br>
<br>
Les méthodes testées doivent être publiques et chaque fichier de test doit étendre "PHPUnit\Framework\TestCase"<br>
<br>
<br>
<strong>D'autres règles existent mais ce sont les plus importantes</strong>
