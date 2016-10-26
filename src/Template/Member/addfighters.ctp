<div class="fighters form">
  <?= $this->Form->create() ?>
      <fieldset>
          <legend><?= __('Ajouter un combattant') ?></legend>
          <?= $this->Form->input('name') ?>
      </fieldset>
  <?= $this->Form->button(__('Ajouter')); ?>
  <?= $this->Form->end() ?>
</div>
