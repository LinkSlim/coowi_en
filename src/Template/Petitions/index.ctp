<?php
	use App\Controller\AppController;
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <?php  if($_SESSION['Auth']['User']['rol_id'] == AppController::ADMIN){ ?>
			        <li><?= $this->Html->link(__('New Petition'), ['action' => 'add']) ?></li>
			        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
			        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
			        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
			        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
        <?php  } 
        	   else{ ?>
	        	    <li><?= $this->Html->link(__('New Petition'), ['action' => 'add']) ?></li>			        			                		
		<?php }?>        		
    </ul>
</nav>
<div class="petitions index large-9 medium-8 columns content" >
    <h3><?= __('My Petitions') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                
                
                <th><?= $this->Paginator->sort('title') ?></th>
                <th><?= $this->Paginator->sort('description') ?></th>
                <th><?= $this->Paginator->sort('creation_date') ?></th>
                <th><?= $this->Paginator->sort('shell_by_date') ?></th>
                <th><?= $this->Paginator->sort('location') ?></th>
                <th><?= $this->Paginator->sort('budget') ?></th>
                <th><?= $this->Paginator->sort('photo') ?></th>
                <th><?= $this->Paginator->sort('status') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($petitions as $petition): ?>
            <tr>
                
<!--                <td> //$petition->has('user') ? $this->Html->link($petition->user->name, ['controller' => 'Users', 'action' => 'view', $petition->user->id]) : '' </td>  //Como mostrar el nomrbre de un usuario dado su id, y convertirlo en enlace para entrar en los datos de ese usuario con ese id--> 
                <td><?= h($petition->title) ?></td>
                <td><?= h($petition->description) ?></td>
                <td><?= h($petition->creation_date) ?></td>
                <td><?= h($petition->shell_by_date) ?></td>
                <td><?= h($petition->location) ?></td>
                <td><?= $this->Number->format($petition->budget) ?>&#8364;</td>
                <td><?= h($petition->photo) ?></td>
                <td><?= h($petition->state) ?></td>
                <td class="actions">
                    <?= $petition->state=="contratada" ? $this->Html->link(__('View'), ['action' => 'contract', $petition->id]) : $this->Html->link(__('View'), ['action' => 'viewOffers', $petition->id]) ?>
                    <?php 
                    	if($petition->state != "contratada"){
                    		echo $this->Html->link(__('Edit'), ['action' => 'edit', $petition->id]);
                    		echo " ";
                    		echo $this->Form->postLink(__('Delete'), ['action' => 'delete', $petition->id], ['confirm' => __('Are you sure you want to delete # {0}?', $petition->id)]);
                    	}
                    ?>
                    
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
