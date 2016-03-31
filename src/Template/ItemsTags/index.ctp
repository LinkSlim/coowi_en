<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Items Tag'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Tags'), ['controller' => 'Tags', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Tag'), ['controller' => 'Tags', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="itemsTags index large-9 medium-8 columns content">
    <h3><?= __('Items Tags') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('tag_id') ?></th>
                <th><?= $this->Paginator->sort('item_id') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($itemsTags as $itemsTag): ?>
            <tr>
                <td><?= $this->Number->format($itemsTag->id) ?></td>
                <td><?= $itemsTag->has('tag') ? $this->Html->link($itemsTag->tag->name, ['controller' => 'Tags', 'action' => 'view', $itemsTag->tag->id]) : '' ?></td>
                <td><?= $itemsTag->has('item') ? $this->Html->link($itemsTag->item->name, ['controller' => 'Items', 'action' => 'view', $itemsTag->item->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $itemsTag->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $itemsTag->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $itemsTag->id], ['confirm' => __('Are you sure you want to delete # {0}?', $itemsTag->id)]) ?>
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
