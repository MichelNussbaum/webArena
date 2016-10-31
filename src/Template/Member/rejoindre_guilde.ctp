<?php $this->assign('title', 'Rejoindre une guilde');?>
<div class="col-md-3 col-sm-offset-4">
	
	<!-- Formulaire de création de guilde -->
		
	<?= $this->Form->create('',['class'=>'form-horizontal']); ?>

	<div class="form-group">

		<?= $this->Form->input(__('search_guilde_by_name'),array('class'=>'form-control','type'=>'text','placeholder'=>'Nom de guilde','required')) ?>

	</div>

	<?= $this->Form->end(); ?>

</div>

<div class="col-md-4 col-sm-offset-4">
	
	<h1>Liste des guildes</h1>
		
	<?php if(isset($allGuild)){ ?>
		
		<ul class="list-group">
	
		<?php foreach($allGuild as $guild){?>
				<?= $this->Form->create(); ?>
			<li class="list-group-item"> <p>Name : <?php echo $guild["name"]; ?></p>
			<?= $this->Form->hidden("idGuild",["value"=>$guild["id"]]);?>
			 <?= $this->Form->button(__('Rejoindre'),array('class'=>'btn btn-primary','type'=>'submit')) ?> 
			</li>
			<?= $this->Form->end(); ?>
		<?php } ?>
		
	<?php }else{
			echo 'Il n\' y a pas de Guilde existante';
		} ?>

		</ul>

</div>
