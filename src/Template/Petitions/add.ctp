<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Petitions'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="petitions form large-9 medium-8 columns content">
    <?= $this->Form->create($petition) ?>
    <fieldset>
        <legend><?= __('Add Petition') ?></legend>
        <?php
            //echo $this->Form->input('user_id', ['options' => $users, 'empty' => true]);
            echo $this->Form->input('title');
            echo $this->Form->input('description');
            echo $this->Form->input('creation_date');
            echo $this->Form->input('shell_by_date');
            echo $this->Form->input('location');
            echo $this->Form->input('budget');
            echo $this->Form->input('photo');
            echo $this->Form->input('state', ['value' => 'activada', 'readonly' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('CANCEL'), array('type' => 'cancel', 'name' => 'cancel', 'formnovalidate')); ?>     
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
