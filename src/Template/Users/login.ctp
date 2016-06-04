<div style="text-align: center; margin-top:2%;">
	<img src="http://coowi.com/images/coowi_logo.jpg"	alt="Coowi" width="200" />
</div>

<div style="width: 500px; margin: 0 auto;">
	<?= $this->Form->create(); ?>
	<h1>Login</h1>
	<?= $this->Form->input('email'); ?>
	<?= $this->Form->input('password'); ?>
	<?= $this->Form->button('Login'); ?>
	<?= $this->Form->end(); ?>
</div>