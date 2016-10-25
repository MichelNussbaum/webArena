<div class="players form">
<?= $this->Flash->render('auth') ?>
<?= $this->Form->create("test",["class"=>"form-horizontal"]) ?>
    <fieldset>
        <legend><?= __("Merci de rentrer vos nom d'utilisateur et mot de passe") ?></legend>
         <div class="form-group">
         <label class="col-sm-2 control-label">Email</label>
	        <div class="col-sm-6">
				<?= $this->Form->email('email',['class' => 'form-control']) ?>
			</div>
	    </div>
	    <div class="form-group">
         	<label class="col-sm-2 control-label">Password</label>
         	<div class="col-sm-6">
        		<?= $this->Form->password('password',['class' => 'form-control']) ?>
        	</div>
        </div>
    </fieldset>
    <div class="col-sm-5 control-label">
		<?= $this->Form->button(__('Se Connecter'),['class'=>'btn btn-default']); ?>
	</div>
<?= $this->Form->end() ?>
<?= $this->Html->link('Mot de passe oublié ?', array('controller' => 'Players', 'action' => 'forget'), array('class' => 'btn btn-link'));?>
</div>