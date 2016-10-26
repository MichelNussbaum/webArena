<?php echo $this->Html->css('bootstrap');
echo $this->Html->script('jQuery.min');
echo $this->Html->script('bootstrap.min');?>
<div class="container">
	<div class="jumbotron">
	  <h1>Vos Combattants</h1>
	  <p>Sur cette page vous pouvez voir l'ensemble de vos combattants avec leurs caractéristiques</p>
	  <p><?php echo $this->Html->link('Créer un combattant', array('controller' => 'Fighters', 'action' => 'add'), array('class' => 'btn btn-primary btn-lg'))?></p>
	</div>
</div>
