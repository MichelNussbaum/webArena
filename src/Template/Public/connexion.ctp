<?php $this->assign('title', 'Connexion');?>
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
            <?= $this->Form->hidden('type',['value' => 'connexion']) ?>
        		<?= $this->Form->password('password',['class' => 'form-control']) ?>
        	</div>
        </div>
    </fieldset>
    <div class="col-sm-5 control-label">
		<?= $this->Form->button(__('Se Connecter'),['class'=>'btn btn-default']); ?>
	</div>
<?= $this->Form->end() ?>
<?php
if($_SERVER['HTTP_HOST'] == "localhost:8888"){
  //on met les id de l'application de test
  $appId = "1242440412484253";
  $appSecret = "77412844f205bd09ed47a7954611259e";
}elseif ($_SERVER['HTTP_HOST'] == "michelnussbaum.fr" || $_SERVER['HTTP_HOST'] == "www.michelnussbaum.fr") {
  //on met les id de l'application de prod
  $appId = "1242436859151275";
  $appSecret = "d35c67c6507a9587e2657b27c0ae720e";
}
$fb = new Facebook\Facebook([
  'app_id' => $appId,
  'app_secret' => $appSecret,
  'default_graph_version' => 'v2.2',
  ]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl('http://'.$_SERVER['HTTP_HOST'].'/webArena/Public/facebook', $permissions); //app test
//$loginUrl = $helper->getLoginUrl('http://michelnussbaum.fr/webArena/Public/facebook', $permissions); //app prod

echo '<a type="button" class="btn btn-primary" href="' . htmlspecialchars($loginUrl) . '">Se Connecter avec Facebook</a>';?>
<button type="button" class="btn btn-link" data-toggle="modal" data-target="#MDPOublie">Mot de passe oublié ?</button>
</div>

<!-- Mot de passe oublié ? -->
<div class="modal fade" id="MDPOublie" tabindex="-1" role="dialog" aria-labelledby="MDPOublie">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="MDPOublie">Mot de passe oublié ?</h4>
      </div>
      <div class="modal-body">
        <div class="players form">
        <?= $this->Form->create($player,["class"=>"form-horizontal"]) ?>
            <fieldset>
                <legend><?= __("Merci de rentrer votre email") ?></legend>
                <div class="form-group">
                <label class="col-sm-2 control-label">Email</label>
        	        <div class="col-sm-6">
                    <?= $this->Form->hidden('type',['value' => 'MDPOublié']) ?>
                		<?= $this->Form->email('email',['class' => 'form-control']) ?>
                	</div>
                </div>
            </fieldset>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <?= $this->Form->button(__('Envoyer'),['class'=>'btn btn-default']); ?>
        <?= $this->Form->end() ?>
      </div>
    </div>
  </div>
</div>
