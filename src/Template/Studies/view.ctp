<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Study'), ['action' => 'edit', $study->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Study'), ['action' => 'delete', $study->id], ['confirm' => __('Are you sure you want to delete # {0}?', $study->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Studies'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Study'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="studies view large-9 medium-8 columns content">
    <h3><?= h($study->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('User') ?></th>
            <td><?= $study->has('user') ? $this->Html->link($study->user->name, ['controller' => 'Users', 'action' => 'view', $study->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Center') ?></th>
            <td><?= h($study->center) ?></td>
        </tr>
        <tr>
            <th><?= __('Degree') ?></th>
            <td><?= h($study->degree) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($study->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Start Date') ?></th>
            <td><?= h($study->start_date) ?></td>
        </tr>
        <tr>
            <th><?= __('Ending Date') ?></th>
            <td><?= h($study->ending_date) ?></td>
        </tr>
    </table>
</div>
