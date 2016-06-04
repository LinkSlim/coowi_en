<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Petition'), ['action' => 'edit', $petition->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Petition'), ['action' => 'delete', $petition->id], ['confirm' => __('Are you sure you want to delete # {0}?', $petition->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Petitions'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Petition'), ['action' => 'add']) ?> </li>
        
    </ul>
</nav>
<div class="petitions view large-9 medium-8 columns content">
    <h3><?= h($petition->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('User') ?></th>
            <td><?= $petition->has('user') ? $this->Html->link($petition->user->name, ['controller' => 'Users', 'action' => 'view', $petition->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Title') ?></th>
            <td><?= h($petition->title) ?></td>
        </tr>
        <tr>
            <th><?= __('Description') ?></th>
            <td><?= h($petition->description) ?></td>
        </tr>
        <tr>
            <th><?= __('Location') ?></th>
            <td><?= h($petition->location) ?></td>
        </tr>
        <tr>
            <th><?= __('Photo') ?></th>
            <td><?= h($petition->photo) ?></td>
        </tr>
        <tr>
            <th><?= __('Status') ?></th>
            <td><?= h($petition->state) ?></td>
        </tr>

        <tr>
            <th><?= __('Budget') ?></th>
            <td><?= $this->Number->format($petition->budget) ?>&euro;</td>
        </tr>
        <tr>
            <th><?= __('Creation Date') ?></th>
            <td><?= h($petition->creation_date) ?></td>
        </tr>
        <tr>
            <th><?= __('Shell By Date') ?></th>
            <td><?= h($petition->shell_by_date) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4 style="color:green"><?= __('Contracted Offers!') ?></h4>
        
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <th><?= __('Item') ?></th>
                    <th><?= __('Price') ?></th>
                    <th><?= __('Contact') ?></th>
                    <th><?= __('Actions') ?></th>
                </tr>
                <?php foreach ($offers as $offer): ?>
                    <tr>                        
                        <td><b><?= $this->Html->link($offer->item->name, ['controller' => 'Items', 'action' => 'view', $offer->item->id]) ?></b></td>
                        <td><b><?= h($offer->price) ?>&euro;</b></td>
                        <td><b><?= $this->Html->link($offer->user->name, ['controller' => 'Users', 'action' => 'view', $offer->user_id])." - ".$offer->user->phone ?></b></td>
                        <td><?= $this->Html->link(__('Rate'), ['controller' => 'Rates', 'action' => 'edit', $offer->id]) ?></td>
                        
                    </tr>                                            

                <?php endforeach; ?>
            </table>
        
    </div>
</div>