<?php
	use App\Controller\AppController;
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>        
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
            <td><?= $this->Number->format($petition->budget) ?></td>
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
        <h4><?= __('Related Items') ?></h4>
        <?php if (!empty($petition->items)): ?>
            <table cellpadding="0" cellspacing="0">
                <tr>
                    
                    
                    <th><?= __('Name') ?></th>
                    <th><?= __('Date') ?></th>
                    <th><?= __('Description') ?></th>
                    <th><?= __('Status') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
                <?php foreach ($petition->items as $items): ?>
                    <tr>
                        
                        <td><b><?= h($items->name) ?></b></td>
                        <td><b><?= h($items->date) ?></b></td>
                        <td><b><?= h($items->description) ?></b></td>
                        <td><b><?= h($items->state) ?></b></td>
                        <td class="actions">
                        	<?php  if($_SESSION['Auth']['User']['rol_id'] == AppController::PRO){ ?>
                            	<?= $this->Html->link(__('Make offer'), ['controller' => 'Offers', 'action' => 'add', $items->id]) ?>
                            <?php  } ?>
                        </td>
                    </tr>                    
                    <!--Element es para incrustar un trozo de codigo de otro fichero en este. Los Elementos son reutilizables -->
                     <?= $this->element('ofertas2', ["item_id" => $items->id]);   ?> 
                        

                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>    
</div>
