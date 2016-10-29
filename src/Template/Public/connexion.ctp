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
<?php
$fb = new Facebook\Facebook([
  'app_id' => '1242436859151275', // Replace {app-id} with your app id
  'app_secret' => 'd35c67c6507a9587e2657b27c0ae720e',
  'default_graph_version' => 'v2.2',
  ]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl('http://localhost:8888/webArena/Public/facebook', $permissions);

echo '<a type="button" class="btn btn-primary" href="' . htmlspecialchars($loginUrl) . '">Se Connecter avec Facebook</a>';?>
<?= $this->Html->link('Mot de passe oublié ?', array('controller' => 'Public', 'action' => 'forgetPassword'), array('class' => 'btn btn-link'));?>


</div>

