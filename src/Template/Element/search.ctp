<li><?php echo $this->Form->create('Tags', array('type' => 'GET', 'class' => 'navbar-form navbar-left', 'url' => array('controller' => 'petitions', 'action' => 'searchPetitions'))); ?>

    <?php echo $this->Form->input('inputTags', array('label' => false, 'div' => false, 'id' => 's', 'class' => 'form-control s', 'placeholder' => 'Buscar peticiones')); ?>
</li>
<li>
    <?php echo $this->Form->button('Buscar', array('div' => false, 'class' => 'btn btn-primary')); ?>
</li>    
<?php echo $this->Form->end(); ?>
    


