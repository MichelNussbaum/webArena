<div class="players form">
<?= $this->Form->create($player,["class"=>"form-horizontal"]) ?>
    <fieldset>
        <legend><?= __("Merci de rentrer votre email") ?></legend>
        <div class="form-group">
        <label class="col-sm-2 control-label">Email</label>
	        <div class="col-sm-6">
        		<?= $this->Form->email('email',['class' => 'form-control']) ?>
        	</div>
        </div>
    </fieldset>
<?= $this->Form->button(__('Envoyer'),['class'=>'btn btn-default']); ?>
<?= $this->Form->end() ?>
</div>