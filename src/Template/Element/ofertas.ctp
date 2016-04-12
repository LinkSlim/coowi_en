<?php 
   
?>

<tr>
    <td><h5><?= __('Offers') ?></h5></td>
</tr>
<tr>
    <th><?= __('User') ?></th>
    <th><?= __('Price') ?></th>
    <th><?= __('Comment') ?></th>
</tr>
<tr>
<!--    <td>$hay ? 'Item ID: '.$item_id : $color; </td>-->
    <td><?= $ofertas->first()['user_id'] ?></td>
    <td><?= $ofertas->first()['price'] ?></td>
    <td><?= $ofertas->first()['comment'] ?></td>
</tr>




