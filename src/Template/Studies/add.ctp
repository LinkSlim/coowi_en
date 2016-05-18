<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Studies'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="studies form large-9 medium-8 columns content">
    <?= $this->Form->create($study) ?>
    <fieldset>
        <legend><?= __('Add Study') ?></legend>
        <?php
            echo $this->Form->hidden('user_id');
            echo $this->Form->input('user_id', ['options' => $users, 'empty' => true, 'type' => 'hidden']);
            echo $this->Form->input('center');
            echo $this->Form->input('degree');
            echo $this->Form->input('start_date');
            echo $this->Form->input('ending_date', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('CANCEL'), array('type' => 'cancel', 'name' => 'cancel', 'formnovalidate')); ?>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
