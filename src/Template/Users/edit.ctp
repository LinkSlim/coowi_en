<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $user->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Roles'), ['controller' => 'Roles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Role'), ['controller' => 'Roles', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Jobs'), ['controller' => 'Jobs', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Job'), ['controller' => 'Jobs', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Petitions'), ['controller' => 'Petitions', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Petition'), ['controller' => 'Petitions', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Studies'), ['controller' => 'Studies', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Study'), ['controller' => 'Studies', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Edit User') ?></legend>
        
        <?php
                
        	if($this->request->session()->read('Auth.User.rol_id') != App\Controller\AppController::ADMIN){
            	echo $this->Form->input('rol_id', ['options' => $roles, 'disabled' => TRUE]);
            }
            else{
            	echo $this->Form->input('rol_id', ['options' => $roles, 'disabled' => FALSE]);
            }
            echo $this->Form->input('nif');
            echo $this->Form->input('email');
            echo $this->Form->input('password');
            echo $this->Form->input('name');
            echo $this->Form->input('subname');
            echo $this->Form->input('phone');
            echo $this->Form->input('location');
            echo $this->Form->input('postal_code');
            echo $this->Form->input('photo');
            //$this->Form->input('date');            
            if($this->request->session()->read('Auth.User.rol_id') == 3){
            	echo $this->Form->input(
            	'state',
            	[
            		'type' => 'select',
			        'multiple' => false,
			        'options' => ['activado' => 'activado', 'desactivado' => 'desactivado'], 
			        'empty' => false
            	]);
            }
            
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
