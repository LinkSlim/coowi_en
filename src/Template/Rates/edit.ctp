<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $rate->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $rate->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Rates'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="rates form large-9 medium-8 columns content">
    <?= $this->Form->create($rate) ?>
    <fieldset>
        <legend><?= __('Edit Rate') ?></legend>
        <?php
            echo $this->Form->input('user1_id');
            echo $this->Form->input('user2_id', ['options' => $users]);
            echo $this->Form->input('comment');
            echo $this->Form->input('rate');
            echo $this->Form->input('date');
            echo $this->Form->input('state');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
