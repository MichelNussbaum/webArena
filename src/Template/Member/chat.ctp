<div class="col-md-3">
	<ul class="nav nav-pills nav-stacked" id="myTabs" role="tablist">
		<li role="presentation" class="active">
		<a href="#nouveau" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true"><span class="badge">+</span> Nouveau</a>
		</li>
		<?php foreach ($fighters as $fighter) {?>
			<li role="presentation">
				<a href="#<?=$fighter[0]->id?>" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true"><?=$fighter[0]->name?>	<span class="badge"><?=count($fighter[1])?></span></a>
			</li>
		<?php } ?>
		
	</ul>
</div>
<div class="col-md-9">
	<div class="tab-content" id="myTabContent">
	<div class="tab-pane fade active in" role="tabpanel" id="nouveau">
		<div class="panel panel-default">
			<div class="panel-body">
				<?php foreach ($enemies as $enemy) {
					$options[$enemy->id] = $enemy->name; 
				}?>
				<?= $this->Form->create() ?>
				<?= $this->Form->hidden('fighter_id_from',['value' =>  $fighterCo->id]) ?>
				<label for="messagepour">Envoyer à</label>
				<?= $this->Form->select('fighter_id', $options,['class' => 'form-control',"id"=>"messagepour"]);?>
				<?= $this->Form->input('title',['class' => 'form-control']) ?>
				<label for="message">Message</label>
				<?= $this->Form->textarea('message',['class' => 'form-control',"id"=>"message"]) ?>
				<?= $this->Form->button(__('Envoyer'),['class'=>'btn btn-default']); ?>
				<?= $this->Form->end() ?>
			</div>
		</div>
	</div>
	<?php foreach ($fighters as $fighter) {?>
		<div class="tab-pane fade in" role="tabpanel" id="<?=$fighter[0]->id?>">
			<div class="panel panel-default">
		  		<div class="panel-body">
					<?php foreach ($fighter[1] as $message) {?>
						<div class="panel panel-default">
						  <div class="panel-heading">
						  <h3 class="panel-title"><?= $message->title?></h3>
						  </div>
						  <div class="panel-body">
						    <p>
						    <?php if($fighter[0]->id == $message->fighter_id_from){?>
						    	<?= $fighter[0]->name ?> : 
						    <?php }else{ ?>
						    	Moi : 
						    <?php } ?>
						    <?= $message->message?>
						    </p>
						  </div>
						  <div class="panel-footer">
						  <small><?= $message->date?></small>
						  </div>
						</div>
					<?php } ?>
				</div>
				<div class="panel-footer">
					<?= $this->Form->create() ?>
					<?= $this->Form->hidden('fighter_id_from',['value' =>  $fighterCo->id]) ?>
					<?= $this->Form->hidden('fighter_id',['value' =>  $fighter[0]->id]) ?>
					<?= $this->Form->input('title',['class' => 'form-control']) ?>
					<label for="message">Message</label>
					<?= $this->Form->textarea('message',['class' => 'form-control',"id"=>"message"]) ?>
					<?= $this->Form->button(__('Envoyer'),['class'=>'btn btn-default']); ?>
					<?= $this->Form->end() ?>
				</div>
			</div>
		</div>
	<?php } ?>
	</div>	
</div>