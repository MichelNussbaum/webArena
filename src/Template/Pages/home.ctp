<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Network\Exception\NotFoundException;

$this->layout = false;

if (!Configure::read('debug')):
    throw new NotFoundException('Please replace src/Template/Pages/home.ctp with your own version.');
endif;

$cakeDescription = 'Web Arena';
?>

<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>
    </title>
    <?= $this->Html->meta('ece.ico','/ece.ico',['type' => 'icon']) ?>
    <!--<?= $this->Html->css('base.css') ?>-->
    <?= $this->Html->css('bootstrap.min.css') ?>
</head>
<body class="home">
    <div class="container">
    <div class="jumbotron">
      <h1>Bienvenue sur Web Areana</h1>
      <p>Web Arena est un jeu de rôle créé dans le cadre de notre formation sur CakePHP à l'ECE Paris par Julien Falconnet</p>
      <p>
          <!-- Lien Inscription -->
          <?php echo $this->Html->link('Inscription', array('controller' => 'Public','action' => 'inscription'), array('class' => 'btn btn-primary btn-lg'));?>
          <!-- Lien Connexion -->
          <?php echo $this->Html->link('Connexion', array('controller' => 'Public', 'action' => 'connexion'), array('class' => 'btn btn-success btn-lg'));?>
      </p>
    </div>
    <div class="page-header">
        <h1>Règles du jeu</h1>
    </div>
    <ul>
        <li>
            Un combattant se trouve dans une arène en damier à une position X,Y. Cette position ne peut pas se trouver hors des dimension de l'arène. Un seul combattant par case. Une arène par site.
        </li>
        <li>
            Un combattant commence avec les caractéristiques suivantes : vue= 2, force=1, point de vie=5 (ces valeurs doivent être paramétrées). Il apparaît à une position libre aléatoire.
        </li>
        <li>
            Constantes paramétrées et valeurs de livraison : largeur (x) de l'arène (15), longueur (y) de l'arène (10) (ces valeurs doivent être paramétrées dans un modèle).
        </li>
        <li>
            La caractéristique de vue détermine à quelle distance (de Manhattan = x+y) un combattant peut voir. Ainsi seuls les combattants et les éléments du décor à portée sont affichés sur la page concernée. 0 correspond à la case courante.
        </li>
        <li>
            La caractéristique de force détermine combien de point de vie perd son adversaire quand le combattant réussit son action d'attaque...
        </li>
        <li>
            Lorsque le combattant voit ses points de vie atteindre 0, il est retiré du jeu. Un joueur dont le combattant a été retiré du jeu est invité à en recréer un nouveau.
        </li>
        <li>
            Une action d'attaque réussit si une valeur aléatoire entre 1 et 20 (d20) est supérieur à un seuil calculé comme suit : 10 + niveau de l'attaqué - niveau de l'attaquant.
        </li>
        <li>
            Progression : à chaque attaque réussie le combattant gagne 1 point d'expérience. Si l'attaque tue l'adversaire, le combattant gagne en plus autant de points d'expériences que le niveau de l'adversaire vaincu. Tous les 4 points d'expériences, le combattant change de niveau et peut choisir d'augmenter une de ses caractéristiques : vue +1 ou force+1 ou point de vie+3. En cas de progression, les points de vie maximaux augmentent ET les points de vie courants remontent au maximum.
        </li>
        <li>
            En pratique, on incrémentera le niveau que lorsqu'une augmentation sera prise, et on utilisera (xp/4) - niveau pour savoir s'il reste des augmentations à prendre. Le niveau commence et les points d'expérience commencent à 0.
        </li>
        <li>
            Chaque action provoque la création d'un événement avec une description claire. Par exemple : « jonh attaque bill et le touche ».
        </li>
    </ul>
    <div class="page-header">
        <h1>Options choisies</h1>
    </div>
    <ul>
        <li>
            <h3>Option B : Gestion de la communication et de guilde<small> - amélioration</small></h3>
            <p>Le système doit permettre d'envoyer un message à un autre combattant. Il doit aussi ajouter l'action crier qui permet de créer un événement avec une description à saisir.</p>
            <p>Le système doit gérer la possibilité de créer et ou de rejoindre une guilde. Un combattant qui attaque une cible gagne +1 en attaque par autre membre de sa guilde au contact de sa cible.</p>
        </li>
        <li>
            <h3>Option F : Utilisation de Bootstrap <small> - bibliothèque externe</small></h3>
            <p>Utilisez bootstrap 3 (attention c'est une version récente, beaucoup de tutoriels en ligne concernent la version 2) pour la composition de vos pages. Respectez les conventions bootstrap, utilisez les classes et les id de bootstrap dans votre HTML et utilisez la css personnalisée la plus restreinte possible.</p>
        </li>
        <li>
            <h3>Option G : Utilisation d'une connexion externe Google/Facebook<small> - bibliothèque externe</small></h3>
            <p>Permettre aux utilisateurs de se connecter avec leur compte facebook</p>
        </li>
    </ul>
    <div class="page-header">
        <h1>Bonus choisis</h1>
    </div>
    <ul>
        <li>
            <h3>Utilisation d'un suivi de version GIT<small> - 1 point</small></h3>
            <p>
                Utiliser un système de suivi de version, type subversion(svn) pour toute la durée du projet. L'école en propose un (webapps.ece.fr/svn-manager), mais un autre est possible (git par exemple).
            <p>Pour obtenir le bonus, il faudra livrer avec le projet le fichier de log du gestionnaire avec mention des fichiers modifiés (pour svn, il s'agit du résultat de svn log -v, pour git, il s'agit du résultat de git log). Le fichier devra s'appeler versions.log et un lien dans le footer de toutes les pages devra y mener.</p>
            </p>
        </li>
        <li>
            <h3>Mise en ligne sur Internet<small> - 2 points</small></h3>
            <p>Le site devra être disponible et fonctionnel sur un hébergement accessible sur Internet. Il existe des hébergements gratuits. L'école propose également des hébergements, mais la compatibilité avec notre Framework est inconnue. L'adresse d'hébergement devra être indiquée dans le footer de toutes les pages.</p>
            </p>
        </li>
    </ul>
</div>
</body>
<footer>
    <div class="container">
        <p> Gr1-05-BF - Michel NUSSBAUM , Filipe CARVALHAIS SANCHES, Vladimir IGNAJATOVIĆ - Options :  B,F,G - Bonus 1 : <?= $this->Html->link('Hébergement','http://michelnussbaum.fr/webArena');?> - Bonus 2 : <?= $this->Html->link('GIT Log',DS.'webroot' . DS . 'files' . DS .'versions.log');?></p>
    </div>
</footer>
</html>
