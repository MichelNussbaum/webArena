<?php echo $this->Html->css('bootstrap');
echo $this->Html->script('jQuery.min');
echo $this->Html->script('bootstrap.min');?>
<div class="container">
	<div class="jumbotron">
	  <h1>Vos Combattants</h1>
	  <p>Sur cette page vous pouvez voir l'ensemble de vos combattants avec leurs caractéristiques</p>
	  <p><?php echo $this->Html->link('Créer un combattant', array('action' => 'addfighters'), array('class' => 'btn btn-primary btn-lg'))?></p>
	</div>
</div>

<div class="row">
	<div class="row">
	<?php foreach ($fighters as $fighter): ?>
	   <div class="col-sm-6 col-md-4">
	      <div class="thumbnail">
	        <?php echo $this->Html->image('warrior.png', ['alt' => 'warrior',"width" => 75]);?>
	        <div class="caption">
	            <h1><?= $fighter->name ?></h1>
	            <h2>LVL : <?= $fighter->level ?></h2>
	            <h3>XP : <?= $fighter->xp ?></h3>
	            <!-- progression dans le niveau	 -->
	            <progress value="<?= $fighter->xp%4 ?>" max="4"></progress>
	            <ul>
	          <li>♥️ <?= $fighter->current_health ?></li>
	          <li>💪 : <?= $fighter->skill_strength ?></li>
	          <li>👀 : <?= $fighter->skill_sight ?></li>
	          <li>❇ X: <?= $fighter->coordinate_x ?></li>
	          <li>❇ Y: <?= $fighter->coordinate_y ?></li>
	          <li>guild : <?= $fighter->guild_id ?></li>
	        </ul>
	            <p><?= $this->Html->link('Utiliser', array('action' => 'arena',$fighter->id), array('class' => 'btn btn-success'));?>
	              <?= $this->Html->link('Éditer', array('action' => 'addfighters'), array('class' => 'btn btn-primary'));?>
	             <?= $this->Form->postLink(__('Supprimer'), ['action' => 'delete', $fighter->id], ['confirm' => __('Etes vous sur de vouloir supprimer {0}?', $fighter->name),'class' => 'btn btn-danger'])?></p>
	          </div>
	      </div>
	  </div>
	<?php endforeach ?>
	</div>
