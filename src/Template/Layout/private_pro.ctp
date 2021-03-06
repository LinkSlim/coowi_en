<?php
use App\Controller\AppController;

/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>
	<script type="text/javascript">
// 		function preventBack(){
// 			window.history.forward();
// 		}
// 		setTimeout("preventBack()", 0);
// 		window.onunload = function() {null};
	</script>


    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('cake.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <nav class="top-bar expanded" data-topbar role="navigation">
        <ul class="title-area large-3 medium-4 columns">
            <li class="name">
                <h1><a href=""><?= $this->fetch('title') ?></a></h1>
            </li>
        </ul>
        <div class="top-bar-section">
            <img src="http://coowi.com/images/coowi_logo.jpg"	alt="Coowi" width="85" />
            <ul class="right">
                <?php echo $this->element('../Element/search');?>
                <li><a target="_self" href=<?= AppController::LINK_MY_OFFERS; ?>>My Offers</a></li>
                <li><a target="_self" href=<?= AppController::LINK_MY_PETITIONS; ?>>My Petitons</a></li>                
                <li><a target="_self" href=<?= AppController::LINK_MY_USER.$this->request->session()->read('Auth.User.id') ?>><?= $this->request->session()->read('Auth.User.name');?></a></li>                
                <li><a target="_self" href=<?= AppController::LINK_LOGOUT; ?>>Logout</a></li>                
            </ul>
        </div>
    </nav>
    <?= $this->Flash->render() ?>
    <?= $this->Flash->render('auth') ?> <!--Mensaje para avisar al usuario de que no esta autorizado-->
    <div class="container clearfix">
        <?= $this->fetch('content') ?>
    </div>
    <footer>
    </footer>
</body>
</html>
