<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $itemsTag->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $itemsTag->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Items Tags'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Tags'), ['controller' => 'Tags', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Tag'), ['controller' => 'Tags', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="itemsTags form large-9 medium-8 columns content">
    <?= $this->Form->create($itemsTag) ?>
    <fieldset>
        <legend><?= __('Edit Items Tag') ?></legend>
        <?php
            echo $this->Form->input('tag_id', ['options' => $tags]);
            echo $this->Form->input('item_id', ['options' => $items]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
