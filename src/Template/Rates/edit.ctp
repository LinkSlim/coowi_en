<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>

    </ul>
</nav>
<div class="rates form large-9 medium-8 columns content">
    <?= $this->Form->create($rate) ?>
    <fieldset>
        <legend><?= __('Edit Rate') ?></legend>
        <?php
            //echo $this->Form->input('user1_id');
            echo $this->Form->input('user2_id', ['options' => $users]);
            echo $this->Form->input('comment');
            echo $this->Form->input('rate', ['min' => 1, 'max' => 10]);
            //echo $this->Form->input('date');
            //echo $this->Form->input('state');
        ?>
    </fieldset>
    <?= $this->Form->button(__('CANCEL'), array('type' => 'cancel', 'name' => 'cancel', 'formnovalidate')); ?>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
