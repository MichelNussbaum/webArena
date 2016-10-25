<<?php $this->assign('title','Inscription'); ?>
<div>
<?= $this->Form->create($player) ?>
    <fieldset>
        <legend><?= __('Ajouter un joueur') ?></legend>
        <?= $this->Form->input('email') ?>
        <?= $this->Form->input('password') ?>
    </fieldset>
<?= $this->Form->button(__('Ajouter')); ?>
<?= $this->Form->end() ?>
</div>
