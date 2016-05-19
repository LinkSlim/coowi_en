<?php
	use App\Controller\AppController;
?>


<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <?php  if($_SESSION['Auth']['User']['rol_id'] == AppController::ADMIN){ //Menu para el Admin?>
			        <li><?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id]) ?> </li>
			        <li><?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?> </li>
			        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?> </li>
			        <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?> </li>
			        <li><?= $this->Html->link(__('List Roles'), ['controller' => 'Roles', 'action' => 'index']) ?> </li>
			        <li><?= $this->Html->link(__('New Role'), ['controller' => 'Roles', 'action' => 'add']) ?> </li>
			        <li><?= $this->Html->link(__('List Jobs'), ['controller' => 'Jobs', 'action' => 'index']) ?> </li>
			        <li><?= $this->Html->link(__('New Job'), ['controller' => 'Jobs', 'action' => 'add']) ?> </li>
			        <li><?= $this->Html->link(__('List Petitions'), ['controller' => 'Petitions', 'action' => 'index']) ?> </li>
			        <li><?= $this->Html->link(__('New Petition'), ['controller' => 'Petitions', 'action' => 'add']) ?> </li>
			        <li><?= $this->Html->link(__('List Studies'), ['controller' => 'Studies', 'action' => 'index']) ?> </li>
			        <li><?= $this->Html->link(__('New Study'), ['controller' => 'Studies', 'action' => 'add']) ?> </li>
         <?php  } 
        	   else{ 
	        	   	if($_SESSION['Auth']['User']['id'] == $user->id){ //Menu para el usuario que visita su perfil
	        	   	?>
		        	    <li><?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id]) ?> </li>
				        <li><?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?> </li>
				        <li><?= $this->Html->link(__('New Job'), ['controller' => 'Jobs', 'action' => 'add']) ?> </li>
				        <li><?= $this->Html->link(__('New Study'), ['controller' => 'Studies', 'action' => 'add']) ?> </li>
				        <li><?= $this->Html->link(__('New Petition'), ['controller' => 'Petitions', 'action' => 'add']) ?> </li>			        			                		
			<?php 	}
					else{?>
 						<li></li> <!--$this->Html->link(__('New Rate'), ['controller' => 'Rates', 'action' => 'edit', $user->id]) -->
				<?php		
					}
        	   }?> 
    </ul>
</nav>


<div class="users view large-9 medium-8 columns content">
<?php if($_SESSION['Auth']['User']['id'] == $user->id){  //Si el perfil del propio usuario se mostraran las cosas relacionadas?>
    <h3><?= h($user->name) ?></h3>
    <table class="vertical-table">
    	<tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($user->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Role') ?></th>
            <td><?= h($user->role->rol)//$user->has('role') ? $this->Html->link($user->role->rol, ['controller' => 'Roles', 'action' => 'view', $user->role->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Nif') ?></th>
            <td><?= h($user->nif) ?></td>
        </tr>        
        <tr>
            <th><?= __('Password') ?></th>
            <td><?= h($user->password) ?></td>
        </tr>
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($user->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Subname') ?></th>
            <td><?= h($user->subname) ?></td>
        </tr>
        <tr>
            <th><?= __('Phone') ?></th>
            <td><?= h($user->phone) ?></td>
        </tr>
        <tr>
            <th><?= __('Email') ?></th>
            <td><?= h($user->email) ?></td>
        </tr>
        <tr>
            <th><?= __('Location') ?></th>
            <td><?= h($user->location) ?></td>
        </tr>
        <tr>
            <th><?= __('Postal Code') ?></th>
            <td><?= h($user->postal_code) ?></td>
        </tr>
        <tr>
            <th><?= __('Photo') ?></th>
            <td><?= h($user->photo) ?></td>
        </tr>
        <tr>
            <th><?= __('State') ?></th>
            <td><?= h($user->state) ?></td>
        </tr>        
        <tr>
            <th><?= __('Creation date') ?></th>
            <td><?= h($user->date) ?></td>
        </tr>
        <tr>
            <th><?= __('Average rate') ?></th>
            <td><?= h($user->averageRate) ?></td>
        </tr>
    </table>
    
        
    <div class="related">
        <h4><?= __('Related Jobs') ?></h4>
        <?php if (!empty($user->jobs)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('User Id') ?></th>
                <th><?= __('Company') ?></th>
                <th><?= __('Start Date') ?></th>
                <th><?= __('Ending Date') ?></th>
                <th><?= __('Position') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->jobs as $jobs): ?>
            <tr>
                <td><?= h($jobs->id) ?></td>
                <td><?= h($jobs->user_id) ?></td>
                <td><?= h($jobs->company) ?></td>
                <td><?= h($jobs->start_date) ?></td>
                <td><?= h($jobs->ending_date) ?></td>
                <td><?= h($jobs->position) ?></td>
                <td class="actions">                    
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Jobs', 'action' => 'edit', $jobs->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Jobs', 'action' => 'delete', $jobs->id], ['confirm' => __('Are you sure you want to delete # {0}?', $jobs->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Studies') ?></h4>
        <?php if (!empty($user->studies)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('User Id') ?></th>
                <th><?= __('Center') ?></th>
                <th><?= __('Degree') ?></th>
                <th><?= __('Start Date') ?></th>
                <th><?= __('Ending Date') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->studies as $studies): ?>
            <tr>
                <td><?= h($studies->id) ?></td>
                <td><?= h($studies->user_id) ?></td>
                <td><?= h($studies->center) ?></td>
                <td><?= h($studies->degree) ?></td>
                <td><?= h($studies->start_date) ?></td>
                <td><?= h($studies->ending_date) ?></td>
                <td class="actions">                    
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Studies', 'action' => 'edit', $studies->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Studies', 'action' => 'delete', $studies->id], ['confirm' => __('Are you sure you want to delete # {0}?', $studies->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    
    <div class="related">
        <h4><?= __('Related Petitions') ?></h4>
        <?php if (!empty($user->petitions)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('User Id') ?></th>
                <th><?= __('Title') ?></th>
                <th><?= __('Description') ?></th>
                <th><?= __('Creation Date') ?></th>
                <th><?= __('Shell By Date') ?></th>
                <th><?= __('Location') ?></th>
                <th><?= __('Budget') ?></th>
                <th><?= __('Photo') ?></th>
                <th><?= __('State') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->petitions as $petitions): ?>
            <tr>
                <td><?= h($petitions->id) ?></td>
                <td><?= h($petitions->user_id) ?></td>
                <td><?= h($petitions->title) ?></td>
                <td><?= h($petitions->description) ?></td>
                <td><?= h($petitions->creation_date) ?></td>
                <td><?= h($petitions->shell_by_date) ?></td>
                <td><?= h($petitions->location) ?></td>
                <td><?= h($petitions->budget) ?></td>
                <td><?= h($petitions->photo) ?></td>
                <td><?= h($petitions->state) ?></td>
                <td class="actions">
                    <?= $petitions->state=="contratada" ? $this->Html->link(__('View'), ['controller' => 'Petitions', 'action' => 'contract', $petitions->id]) : $this->Html->link(__('View'), ['controller' => 'Petitions', 'action' => 'viewOffers', $petitions->id]) ?>
                    <?php 
                    	if($petitions->state != "contratada"){
                    		echo $this->Html->link(__('Edit'), ['controller' => 'Petitions', 'action' => 'edit', $petitions->id]);
                    		echo " ";
                    		echo $this->Form->postLink(__('Delete'), ['controller' => 'Petitions', 'action' => 'delete', $petitions->id], ['confirm' => __('Are you sure you want to delete # {0}?', $petitions->id)]);
                    	}
                    ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <?php } 
    else {?>
    
        <h3><?= h($user->name) ?></h3>
    <table class="vertical-table">
    	<tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($user->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Role') ?></th>
            <td><?= h($user->role->rol)//$user->has('role') ? $this->Html->link($user->role->rol, ['controller' => 'Roles', 'action' => 'view', $user->role->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Nif') ?></th>
            <td><?= h($user->nif) ?></td>
        </tr>        
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($user->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Subname') ?></th>
            <td><?= h($user->subname) ?></td>
        </tr>
        <tr>
            <th><?= __('Phone') ?></th>
            <td><?= h($user->phone) ?></td>
        </tr>
        <tr>
            <th><?= __('Email') ?></th>
            <td><?= h($user->email) ?></td>
        </tr>
        <tr>
            <th><?= __('Location') ?></th>
            <td><?= h($user->location) ?></td>
        </tr>
        <tr>
            <th><?= __('Postal Code') ?></th>
            <td><?= h($user->postal_code) ?></td>
        </tr>
        <tr>
            <th><?= __('Photo') ?></th>
            <td><?= h($user->photo) ?></td>
        </tr>
        <tr>
            <th><?= __('State') ?></th>
            <td><?= h($user->state) ?></td>
        </tr>        
        <tr>
            <th><?= __('Creation date') ?></th>
            <td><?= h($user->date) ?></td>
        </tr>
        <tr>
            <th><?= __('Average Rate') ?></th>
            <td><?= h($user->averageRate) ?></td>
        </tr>
    </table>    
    <?php }?>
</div>

