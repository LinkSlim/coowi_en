<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Study'), ['controller' => 'Studies', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="jobs form large-9 medium-8 columns content">
    <?= $this->Form->create($job) ?>
    <fieldset>
        <legend><?= __('Add Job') ?></legend>
        <?php
            echo $this->Form->hidden('user_id');
            echo $this->Form->input('user_id', ['options' => $users, 'empty' => true, 'type' => 'hidden']);
            echo $this->Form->input('company');
            echo $this->Form->input('start_date');
            echo $this->Form->input('ending_date', ['empty' => true]);
            echo $this->Form->input('position');
        ?>
    </fieldset>
    <?= $this->Form->button(__('CANCEL'), array('type' => 'cancel', 'name' => 'cancel', 'formnovalidate')); ?>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
