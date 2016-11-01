<?php $this->assign('title','Inscription'); ?>
<div>
  <?= $this->Form->create("",["class"=>"form-horizontal"]) ?>
  <fieldset>
    <legend><?= __('Ajouter un joueur') ?></legend>
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
    <?= $this->Form->button(__("S'inscrire"),['class'=>'btn btn-primary']); ?>
  </div>
  <?= $this->Form->end() ?>
</div>
