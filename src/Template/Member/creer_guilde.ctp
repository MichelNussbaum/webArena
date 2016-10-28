<div class="col-md-6 col-sm-offset-3">
	<h1> Création de guilde </h1>
	<p> Vous êtes prêt à diriger une guilde ?</p>
	<p> Il vous suffit seulement de renseigner le nom de votre guilde</p>
	<p> Vous pourrez ensuite former un groupe de joueur pour combattre les autres guildes</p>

</div>
<div class="col-md-3 col-sm-offset-4">
	
	<!-- Formulaire de création de guilde -->
		
	<?= $this->Form->create('',['class'=>'form-horizontal']); ?>

	<div class="form-group">

		<?= $this->Form->input(__('name'),array('class'=>'form-control','type'=>'text','placeholder'=>'Exemple : Raptors','required')) ?>
		<?= $this->Form->button(__('Reset'),array('type'=>'reset','class'=>'btn-warning btn-lg')) ?>
		<?= $this->Form->button(__('Créer'),array('type'=>'submit','class'=>'btn-primary btn-lg')) ?>
		<?php if(isset($failInsertGuild)){ ?>
			<div> Ce nom de guilde est déjà utilisé ! </div>
			<div> Veuillez reessayer avec un autre nom, svp </div>
		<?php }else{ ?>
			<div>La guilde a bien été insérée. </div>
		<?php } ?>
	</div>

	<?= $this->Form->end(); ?>

</div>