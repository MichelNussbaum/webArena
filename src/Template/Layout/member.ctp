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

$cakeDescription = 'Web Arena';
?>
<!DOCTYPE html>
<html>
<head>
  <?= $this->Html->charset() ?>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>
    <?= $cakeDescription ?>:
    <?= $this->fetch('title') ?>
  </title>
  <?= $this->Html->meta('icon') ?>

  <!--<?= $this->Html->css('base.css') ?>-->
  <!--<?= $this->Html->css('cake.css') ?>-->
  <?= $this->Html->css('bootstrap.min.css') ?>
   <?= $this->Html->css('dataTables.bootstrap.min.css') ?>
  <?= $this->Html->script('jQuery.min');?>
  <?= $this->Html->script('bootstrap.min'); ?>
  <?= $this->Html->script('datatables'); ?>
  <?= $this->Html->script('dataTables.bootstrap.min'); ?>

  <?= $this->fetch('meta') ?>
  <?= $this->fetch('css') ?>
  <?= $this->fetch('script') ?>
</head>
<body>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <?php echo $this->Html->link('The Game', array('action' => 'index'), array('class' => 'navbar-brand'))?>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right">
          <li>
            <?= $this->Html->link($authUser['email'], array('controller' => 'Pages', 'action' => 'display'))?>
          </li>
          <li><?php echo $this->Html->link('Déconnexion', array('action' => 'deconnexion'), array('class' => 'btn btn-danger'))?></li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
  <?= $this->Flash->render() ?>
  <div class="container">
    <?= $this->fetch('content') ?>
  </div>
</body>
<footer>
  <p> The Winner! - Michel NUSSBAUM , Filipe CARVALHAIS SANCHES, Vladimir POUTINE - Options :  B,F,G - Bonus 1 : <?= $this->Html->link('Hébergement','http://michelnussbaum.fr/webArena');?> - Bonus 2 : <?= $this->Html->link('GIT Log',DS.'webroot' . DS . 'files' . DS .'versions.log');?></p>
  </footer>
</html>
