<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Rate'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="rates index large-9 medium-8 columns content">
    <h3><?= __('Rates') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('user1_id') ?></th>
                <th><?= $this->Paginator->sort('user2_id') ?></th>
                <th><?= $this->Paginator->sort('comment') ?></th>
                <th><?= $this->Paginator->sort('rate') ?></th>
                <th><?= $this->Paginator->sort('date') ?></th>
                <th><?= $this->Paginator->sort('state') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rates as $rate): ?>
            <tr>
                <td><?= $this->Number->format($rate->id) ?></td>
                <td><?= $this->Number->format($rate->user1_id) ?></td>
                <td><?= $rate->has('user') ? $this->Html->link($rate->user->name, ['controller' => 'Users', 'action' => 'view', $rate->user->id]) : '' ?></td>
                <td><?= h($rate->comment) ?></td>
                <td><?= $this->Number->format($rate->rate) ?></td>
                <td><?= h($rate->date) ?></td>
                <td><?= h($rate->state) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $rate->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $rate->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $rate->id], ['confirm' => __('Are you sure you want to delete # {0}?', $rate->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
