<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        
    </ul>
</nav>
<div class="offers index large-9 medium-8 columns content">
    <h3><?= __('My Offers') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('user_id') ?></th>
                <th><?= $this->Paginator->sort('item_id') ?></th>
                <th><?= $this->Paginator->sort('Item owner') ?></th>                
                <th><?= $this->Paginator->sort('price') ?></th>
                <th><?= $this->Paginator->sort('date') ?></th>
                <th><?= $this->Paginator->sort('comment') ?></th>
                <th><?= $this->Paginator->sort('state') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($offers as $offer): ?>
            <tr>
                <td><?= $this->Number->format($offer->id) ?></td>
                <td><?= h($offer->user->name) ?></td>
                <td><?= $offer->has('item') ? $this->Html->link($offer->item->name, ['controller' => 'Items', 'action' => 'view', $offer->item->id]) : '' ?></td>
                <td><?= h($offer->item->user_id) ?></td>                
                <td><?= $this->Number->format($offer->price) ?></td>
                <td><?= h($offer->date) ?></td>
                <td><?= h($offer->comment) ?></td>
                <td><?= h($offer->state) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $offer->id]) ?>
                    <?= $offer->state == "activada" ? $this->Form->postLink(__('Delete'), ['action' => 'delete', $offer->id], ['confirm' => __('Are you sure you want to delete # {0}?', $offer->id)]) : '' ?>
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
        <?php if(empty($offer)) { 
    		echo '<h4>You have not done offers. You can search petitions and make your offers</h4>';
    	  }    	  
		?>
</div>
