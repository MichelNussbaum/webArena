<?php echo $this->Html->css('bootstrap');
echo $this->Html->script('jQuery.min');
echo $this->Html->script('bootstrap.min');?>
<div class="container">
	<div class="jumbotron">
		<h1>Vos Combattants</h1>
		<p>Sur cette page vous pouvez voir l'ensemble de vos combattants avec leurs caractéristiques</p>
		<p><button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#addfighters">Créer un combattant</button></p>
	</div>
</div>
<!-- Affichage des fighters -->
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
							<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModifierFighter">Modifier</button>
							<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#DeleteFighter">Supprimer</button>
						</div>
					</div>
				</div>
			<?php endforeach ?>
		</div>

		<!-- Addfighters -->
<div class="modal fade" id="addfighters" tabindex="-1" role="dialog" aria-labelledby="Addfighters">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="addfighters">Ajouter un combattant</h4>
      </div>
      <div class="modal-body">
				<div class="fighters form">
					<?= $this->Form->create() ?>
					<?= $this->Form->hidden('type',['value' => 'addfighters']) ?>
						<?= $this->Form->input('name',['class' => 'form-control']) ?>
				</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<?= $this->Form->button(__('Ajouter'),['class'=>'btn btn-default']); ?>
				<?= $this->Form->end() ?>
      </div>
    </div>
  </div>
</div>

<!-- ModifierFighter -->
<div class="modal fade" id="ModifierFighter" tabindex="-1" role="dialog" aria-labelledby="ModifierFighter">
<div class="modal-dialog" role="document">
<div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="ModifierFighter">Modifier le combattant</h4>
	</div>
	<div class="modal-body">
		<div class="fighters form">
			<?= $this->Form->create() ?>
			<?= $this->Form->hidden('type',['value' => 'ModifierFighter']) ?>
				<?= $this->Form->input('name',['class' => 'form-control']) ?>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<?= $this->Form->button(__('Modifer'),['class'=>'btn btn-default']); ?>
		<?= $this->Form->end() ?>
	</div>
</div>
</div>
</div>

<!-- DeleteFighter -->
<div class="modal fade" id="DeleteFighter" tabindex="-1" role="dialog" aria-labelledby="DeleteFighter">
<div class="modal-dialog" role="document">
<div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="DeleteFighter">Supprimer le combattant</h4>
	</div>
	<div class="modal-body">
		<div class="fighters form">
				<?= $this->Form->create() ?>
				<?= $this->Form->hidden('type',['value' => 'DeleteFighter']) ?>
				<?= $this->Form->hidden('id',['value' =>  $fighter->id]) ?>
				<?php $name =$fighter->name; ?>
				<?php print "Etes vous sur de vouloir supprimer $name ?" ?>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<?= $this->Form->button(__('Supprimer'),['class'=>'btn btn-default']); ?>
		<?= $this->Form->end() ?>
	</div>
</div>
</div>
</div>
