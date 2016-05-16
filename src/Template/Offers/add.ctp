<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Offers'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="offers form large-9 medium-8 columns content">
    <?= $this->Form->create($offer) ?>
    <fieldset>
        <legend><?= __('Add Offer') ?></legend>
        <?php
            echo $this->Form->input('items', ['options' => $items]);
            echo $this->Form->input('price');
            echo $this->Form->input('comment');            
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
