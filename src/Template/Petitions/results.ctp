<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Petition'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="tags index large-9 medium-8 columns content">
    <h3><?= __('Search results') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('title') ?></th>
                <th><?= $this->Paginator->sort('date') ?></th>
                <th><?= $this->Paginator->sort('user') ?></th>
                <th><?= $this->Paginator->sort('state') ?></th>                
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($peticionesConTags as $peticion): ?>
            <?php foreach ($peticion as $peti): ?>
            <tr>
                <td><?= $this->Number->format($peti->id) ?></td>
                <td><?= h($peti->title) ?></td>
                <td><?= h($peti->creation_date) ?></td>
                <td><?= h($peti->user_id) ?></td>
                <td><?= h($peti->state) ?></td>
                <td class="actions">
                	<?= $this->Html->link(__('Look'), ['action' => 'look', $peti->id]) ?>                    
                </td>
            </tr>
            <?php endforeach; ?>
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
    <?php if(empty($peti)) { 
    		echo '<h4>No petitions found</h4>';
    	  }    	  
		?>
</div>
