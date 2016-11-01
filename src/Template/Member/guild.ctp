<?php $this->assign('title', 'Guilde');?>
<div class="page-header">
  <?php if(!empty($fighter["guild_name"])){?>
  	<h2>Vous appertenez à la guilde <?=$fighter["guild_name"]?></h2>
  	<?php }else{ ?>
  		<h2>Vous n'appertenez à aucune guilde</h2>
  	<?php } ?>
</div>
<div class="row">
	<div class="col-sm-2 col-md-2">
		    <div class="thumbnail">
		      <div class="caption">
		        <h3>Créer</h3>
		        <?=$this->Form->create();?>
		        <?=$this->Form->hidden('action',['value' => "creer"]);?>
				<?=$this->Form->hidden('idFighter',['value' => $fighter->id]);?>
				<?=$this->Form->input('name',['class' => 'form-control']);?>
				<?=$this->Form->button(__('Créer'),['class'=>'btn btn-primary']);?>
				<?=$this->Form->end();?>
		      </div>
		    </div>
	  </div>
<?php foreach ($guilds as $guild){ ?>
	<div class="col-sm-2 col-md-2">
	    <div class="thumbnail">
	      <div class="caption">
	        <h3><?= $guild->name ?></h3>
	        <?=$this->Form->create();?>
	        <?=$this->Form->hidden('action',['value' => "rejoindre"]);?>
			<?=$this->Form->hidden('idGuild',['value' => $guild->id]);?>
			<?=$this->Form->hidden('idFighter',['value' => $fighter->id]);?>
			<?=$this->Form->button(__('Rejoindre'),['class'=>'btn btn-primary']);?>
			<?=$this->Form->end();?>
	      </div>
	    </div>
  </div>
	
<?php } ?>
</div>