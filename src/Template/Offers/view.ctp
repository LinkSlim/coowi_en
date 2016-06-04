<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
		<li><?= $this->Html->link(__('List Offers'), ['action' => 'index']) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Offer'), ['action' => 'delete', $offer->id], ['confirm' => __('Are you sure you want to delete # {0}?', $offer->id)]) ?> </li>        
    </ul>
</nav>
<div class="offers view large-9 medium-8 columns content">
    <h3>Offer Detail</h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Item') ?></th>
            <td><?= h($offer->item->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Comment') ?></th>
            <td><?= h($offer->comment) ?></td>
        </tr>
        <tr>
            <th><?= __('Status') ?></th>
            <td><?= h($offer->state) ?></td>
        </tr>

        <tr>
            <th><?= __('Price') ?></th>
            <td><?= $this->Number->format($offer->price) ?>&euro;</td>
        </tr>
        <tr>
            <th><?= __('Date') ?></th>
            <td><?= h($offer->date) ?></td>
        </tr>
    </table>
</div>
