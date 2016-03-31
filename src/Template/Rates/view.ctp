<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Rate'), ['action' => 'edit', $rate->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Rate'), ['action' => 'delete', $rate->id], ['confirm' => __('Are you sure you want to delete # {0}?', $rate->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Rates'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Rate'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="rates view large-9 medium-8 columns content">
    <h3><?= h($rate->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('User') ?></th>
            <td><?= $rate->has('user') ? $this->Html->link($rate->user->name, ['controller' => 'Users', 'action' => 'view', $rate->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Comment') ?></th>
            <td><?= h($rate->comment) ?></td>
        </tr>
        <tr>
            <th><?= __('State') ?></th>
            <td><?= h($rate->state) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($rate->id) ?></td>
        </tr>
        <tr>
            <th><?= __('User1 Id') ?></th>
            <td><?= $this->Number->format($rate->user1_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Rate') ?></th>
            <td><?= $this->Number->format($rate->rate) ?></td>
        </tr>
        <tr>
            <th><?= __('Date') ?></th>
            <td><?= h($rate->date) ?></td>
        </tr>
    </table>
</div>
