<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Items'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Petitions'), ['controller' => 'Petitions', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Petition'), ['controller' => 'Petitions', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Offers'), ['controller' => 'Offers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Offer'), ['controller' => 'Offers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Tags'), ['controller' => 'Tags', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Tag'), ['controller' => 'Tags', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="items form large-9 medium-8 columns content">
    <?= $this->Form->create($item) ?>
    <fieldset>
        <legend><?= __('Add Item') ?></legend>
        <?php
            echo $this->Form->input('petition_id', ['options' => $petitions, 'readonly' => TRUE]);
            echo $this->Form->input('name');
			//echo $this->Form->input('date', ['readonly' => TRUE]);
            echo $this->Form->input('description');
            echo $this->Form->input('state', ['value' => "activada", 'disabled' => TRUE, 'readonly' => TRUE]);
			echo $this->Form->input('tags._ids', ['options' => $tags]);            
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
