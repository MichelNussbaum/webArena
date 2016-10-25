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

$cakeDescription = 'CakePHP: the rapid development PHP framework';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    <!--<?= $this->Html->css('base.css') ?>-->
    <?= $this->Html->css('bootstrap.min.css') ?>
</head>
<body class="home">
    <div class="container">
    <div class="jumbotron">
      <h1>Bienvenue sur THE game</h1>
      <p>The game est un jeu de rôle créé dans le cadre de notre formation en web à l'ECE Paris par Julien Falconnet</p>
      <p>
          <!-- Lien Inscription -->
          <?php echo $this->Html->link('Inscription', array('controller' => 'Players', 'action' => 'add'), array('class' => 'btn btn-primary btn-lg'));?>
          <!-- Lien Connexion -->
          <?php echo $this->Html->link('Connexion', array('controller' => 'Players', 'action' => 'login'), array('class' => 'btn btn-success btn-lg'));?>
      </p>
    </div>
    <div class="page-header">
        <h1>Règles du jeu</h1>
    </div>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla at finibus enim. Quisque vitae odio et enim hendrerit tincidunt et vitae nisl. Fusce dapibus scelerisque sem sit amet vestibulum. Fusce dolor enim, dictum quis libero a, suscipit scelerisque velit. Aenean aliquet erat in quam gravida, id eleifend nibh vestibulum. Quisque elit felis, porttitor eu tincidunt vitae, ornare ac mauris. Suspendisse at viverra mi. Aenean sit amet porta augue. Ut enim elit, commodo ac volutpat eu, rutrum eget nulla.</p>

    <p>Quisque nec cursus mauris. Nulla dignissim justo et lectus ultricies commodo. Ut condimentum vehicula congue. Pellentesque commodo eget tellus eget facilisis. Fusce eu arcu venenatis, convallis turpis at, ornare ipsum. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Phasellus hendrerit, mi id aliquam aliquam, nisi dolor gravida justo, vitae lobortis lectus justo at sem. Maecenas velit sem, aliquam vitae mollis sed, porta eget nibh. Aliquam eu massa mollis, dapibus arcu nec, semper odio. Aliquam vitae nibh eros. Curabitur sed ligula sapien. Aliquam mollis dolor lobortis gravida cursus. Sed aliquam leo neque, eu hendrerit dui mollis ac.</p>

    <p>Duis condimentum quam in turpis suscipit pharetra. Nullam vitae laoreet lacus, vitae pretium mi. Phasellus efficitur justo est, vitae accumsan tellus ullamcorper ac. Ut eget tempus erat. Mauris leo odio, eleifend egestas dignissim ac, tempus ut nulla. Vestibulum placerat neque quis massa finibus congue. Maecenas a ipsum porta, rutrum eros ac, lacinia ex. Duis at blandit nulla. Maecenas auctor viverra lectus eget placerat. Integer efficitur arcu sit amet hendrerit dapibus. Duis fermentum consectetur turpis non cursus. Duis placerat dapibus arcu, eu rutrum felis fermentum quis. Morbi nisl arcu, lacinia in nisi eget, rutrum faucibus nulla. Praesent et est massa.</p>

    <p>Sed venenatis lectus vel libero vehicula tincidunt. Vestibulum auctor ullamcorper tortor, sit amet vestibulum nulla. Donec in commodo augue. In pellentesque tempus augue, ac maximus dolor consequat a. Etiam aliquam suscipit erat. Aenean sem velit, dapibus vitae sagittis nec, aliquet eget nulla. Morbi vestibulum lorem vel mi condimentum mollis commodo non velit. Fusce interdum ex eget condimentum viverra. Sed turpis urna, laoreet nec tristique sed, faucibus in nunc. Vestibulum quis rhoncus turpis, at mattis neque. In quis metus nunc. Donec augue libero, commodo id tortor pulvinar, egestas imperdiet lectus. Quisque ac mauris vitae mi faucibus efficitur ut id lacus. Suspendisse tellus risus, sodales et ullamcorper vel, facilisis convallis magna.</p>

    <p>Nunc pulvinar pulvinar nulla. Duis auctor, velit in maximus interdum, nisi ex vestibulum turpis, ac pellentesque lectus lorem at erat. Phasellus nec nulla pretium, finibus ipsum non, aliquam sem. Etiam vulputate at neque ut tempor. Integer bibendum lobortis magna, sed vulputate ex. Aenean posuere diam ut blandit commodo. Vestibulum ante felis, auctor eget sollicitudin ut, hendrerit vitae diam. Cras sodales at elit tempus elementum. Nunc efficitur scelerisque felis at tincidunt. Maecenas ac efficitur leo, at gravida velit. Pellentesque ac viverra libero. Vivamus non finibus justo, ut laoreet dolor. Quisque rutrum lacus vestibulum semper volutpat. Sed non facilisis sapien.</p>
    <div class="page-header">
        <h1>Combattants</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla at finibus enim. Quisque vitae odio et enim hendrerit tincidunt et vitae nisl. Fusce dapibus scelerisque sem sit amet vestibulum. Fusce dolor enim, dictum quis libero a, suscipit scelerisque velit. Aenean aliquet erat in quam gravida, id eleifend nibh vestibulum. Quisque elit felis, porttitor eu tincidunt vitae, ornare ac mauris. Suspendisse at viverra mi. Aenean sit amet porta augue. Ut enim elit, commodo ac volutpat eu, rutrum eget nulla.</p>

        <p>Quisque nec cursus mauris. Nulla dignissim justo et lectus ultricies commodo. Ut condimentum vehicula congue. Pellentesque commodo eget tellus eget facilisis. Fusce eu arcu venenatis, convallis turpis at, ornare ipsum. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Phasellus hendrerit, mi id aliquam aliquam, nisi dolor gravida justo, vitae lobortis lectus justo at sem. Maecenas velit sem, aliquam vitae mollis sed, porta eget nibh. Aliquam eu massa mollis, dapibus arcu nec, semper odio. Aliquam vitae nibh eros. Curabitur sed ligula sapien. Aliquam mollis dolor lobortis gravida cursus. Sed aliquam leo neque, eu hendrerit dui mollis ac.</p>
    </div>

    <div class="page-header">
        <h1>Objets</h1>
    </div>
    <div class="row">
        <div class="col-sm-6 col-md-4">
            <div class="thumbnail">
                <?php echo $this->Html->image('sword.jpg', ['alt' => 'épée',"width" => 50]);?>
                <div class="caption">
                    <h3>Objet 1</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla at finibus enim. Quisque vitae odio et enim hendrerit tincidunt et vitae nisl. Fusce dapibus scelerisque sem sit amet vestibulum. Fusce dolor enim, dictum quis libero a, suscipit scelerisque velit. Aenean aliquet erat in quam gravida, id eleifend nibh vestibulum. Quisque elit felis, porttitor eu tincidunt vitae, ornare ac mauris. Suspendisse at viverra mi. Aenean sit amet porta augue. Ut enim elit, commodo ac volutpat eu, rutrum eget nulla.</p>
                    <p>
                    <!-- Lien détails objets -->
                    <?php echo $this->Html->link('Détails', array('controller' => 'Objets', 'action' => 'details'), array('class' => 'btn btn-primary'));?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="thumbnail">
                <?php echo $this->Html->image('sword.jpg', ['alt' => 'épée',"width" => 50]);?>
                <div class="caption">
                    <h3>Objet 2</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla at finibus enim. Quisque vitae odio et enim hendrerit tincidunt et vitae nisl. Fusce dapibus scelerisque sem sit amet vestibulum. Fusce dolor enim, dictum quis libero a, suscipit scelerisque velit. Aenean aliquet erat in quam gravida, id eleifend nibh vestibulum. Quisque elit felis, porttitor eu tincidunt vitae, ornare ac mauris. Suspendisse at viverra mi. Aenean sit amet porta augue. Ut enim elit, commodo ac volutpat eu, rutrum eget nulla.</p>
                    <p>
                    <!-- Lien détails objets -->
                    <?php echo $this->Html->link('Détails', array('controller' => 'Objets', 'action' => 'details'), array('class' => 'btn btn-primary'));?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="thumbnail">
                <?php echo $this->Html->image('sword.jpg', ['alt' => 'épée',"width" => 50]);?>
                <div class="caption">
                    <h3>Objet 3</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla at finibus enim. Quisque vitae odio et enim hendrerit tincidunt et vitae nisl. Fusce dapibus scelerisque sem sit amet vestibulum. Fusce dolor enim, dictum quis libero a, suscipit scelerisque velit. Aenean aliquet erat in quam gravida, id eleifend nibh vestibulum. Quisque elit felis, porttitor eu tincidunt vitae, ornare ac mauris. Suspendisse at viverra mi. Aenean sit amet porta augue. Ut enim elit, commodo ac volutpat eu, rutrum eget nulla.</p>
                    <p>
                    <!-- Lien détails objets -->
                    <?php echo $this->Html->link('Détails', array('controller' => 'Objets', 'action' => 'details'), array('class' => 'btn btn-primary'));?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-md-4">
            <div class="thumbnail">
                <?php echo $this->Html->image('sword.jpg', ['alt' => 'épée',"width" => 50]);?>
                <div class="caption">
                    <h3>Objet 4</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla at finibus enim. Quisque vitae odio et enim hendrerit tincidunt et vitae nisl. Fusce dapibus scelerisque sem sit amet vestibulum. Fusce dolor enim, dictum quis libero a, suscipit scelerisque velit. Aenean aliquet erat in quam gravida, id eleifend nibh vestibulum. Quisque elit felis, porttitor eu tincidunt vitae, ornare ac mauris. Suspendisse at viverra mi. Aenean sit amet porta augue. Ut enim elit, commodo ac volutpat eu, rutrum eget nulla.</p>
                    <p>
                    <!-- Lien détails objets -->
                    <?php echo $this->Html->link('Détails', array('controller' => 'Objets', 'action' => 'details'), array('class' => 'btn btn-primary'));?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="thumbnail">
                <?php echo $this->Html->image('sword.jpg', ['alt' => 'épée',"width" => 50]);?>
                <div class="caption">
                    <h3>Objet 5</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla at finibus enim. Quisque vitae odio et enim hendrerit tincidunt et vitae nisl. Fusce dapibus scelerisque sem sit amet vestibulum. Fusce dolor enim, dictum quis libero a, suscipit scelerisque velit. Aenean aliquet erat in quam gravida, id eleifend nibh vestibulum. Quisque elit felis, porttitor eu tincidunt vitae, ornare ac mauris. Suspendisse at viverra mi. Aenean sit amet porta augue. Ut enim elit, commodo ac volutpat eu, rutrum eget nulla.</p>
                    <p>
                    <!-- Lien détails objets -->
                    <?php echo $this->Html->link('Détails', array('controller' => 'Objets', 'action' => 'details'), array('class' => 'btn btn-primary'));?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="thumbnail">
                <?php echo $this->Html->image('sword.jpg', ['alt' => 'épée',"width" => 50]);?>
                <div class="caption">
                    <h3>Objet 6</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla at finibus enim. Quisque vitae odio et enim hendrerit tincidunt et vitae nisl. Fusce dapibus scelerisque sem sit amet vestibulum. Fusce dolor enim, dictum quis libero a, suscipit scelerisque velit. Aenean aliquet erat in quam gravida, id eleifend nibh vestibulum. Quisque elit felis, porttitor eu tincidunt vitae, ornare ac mauris. Suspendisse at viverra mi. Aenean sit amet porta augue. Ut enim elit, commodo ac volutpat eu, rutrum eget nulla.</p>
                    <p>
                    <!-- Lien détails objets -->
                    <?php echo $this->Html->link('Détails', array('controller' => 'Objets', 'action' => 'details'), array('class' => 'btn btn-primary'));?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
