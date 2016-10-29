<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModifierFighter<?= $fighter->id ?>">Boutique</button>
<div class="modal fade" id="ModifierFighter<?= $fighter->id ?>" tabindex="-1" role="dialog" aria-labelledby="ModifierFighter">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="ModifierFighter<?= $fighter->id ?>">Modifier le combattant</h4>
			</div>
			<div class="modal-body">
				<?php if($nbPoints>0){ ?>
				<p>Vous avez <?= $nbPoints?> points à ajouter</p>
				<table class="table">
				<?php 
					$arrayligne = array();
					$vue = $this->Form->create();
					$vue.= $this->Form->hidden('type',['value' => 'ajoutCompetence']);
					$vue.= $this->Form->hidden('skill',['value' => 'vue']);
					$vue.= $this->Form->hidden('id',['value' =>  $fighter->id]);
					$vue.= $this->Form->button(__('Augmenter'),['class'=>'btn btn-default']);
					$vue.=$this->Form->end();
					$arrayligne["vue"] = $vue;
					$force = $this->Form->create();
					$force.= $this->Form->hidden('type',['value' => 'ajoutCompetence']);
					$force.= $this->Form->hidden('skill',['value' => 'force']);
					$force.= $this->Form->hidden('id',['value' =>  $fighter->id]);
					$force.= $this->Form->button(__('Augmenter'),['class'=>'btn btn-default']);
					$force.=$this->Form->end();
					$arrayligne["force"] = $force;
					$sante = $this->Form->create();
					$sante.= $this->Form->hidden('type',['value' => 'ajoutCompetence']);
					$sante.= $this->Form->hidden('skill',['value' => 'sante']);
					$sante.= $this->Form->hidden('id',['value' =>  $fighter->id]);
					$sante.= $this->Form->button(__('Augmenter'),['class'=>'btn btn-default']);
					$sante.=$this->Form->end();
					$arrayligne["sante"] = $sante;
				?>
					<?= $this->Html->tableHeaders(['Compétence', 'Point actuel', 'Ajouter']);?>
					<?= $this->Html->tableCells([['Vue',$fighter->skill_sight,$arrayligne["vue"]],['Force',$fighter->skill_strength,$arrayligne["force"]],['Santé',$fighter->current_health,$arrayligne["sante"]]]);?>
				</table>
				<?php }else{?>
					<p>Vous n'avez pas de points de compétences disponibles</p>
				<?php }?> 
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>