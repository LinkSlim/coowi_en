<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        
    </ul>
</nav>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Add User') ?></legend>
        <?php
            echo $this->Form->input('rol_id', ['options' => $roles]);
            /*$this->Form->input(
		    'roles', 
		    [
		        'type' => 'select',
		        'multiple' => false,
		        'options' => $roles, 
		        'empty' => true
		    ]
			);*/
            
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
            //$this->Form->input('state');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
