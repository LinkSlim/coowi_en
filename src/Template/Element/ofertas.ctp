<?php

$cabecera = true;
$idGrupoRadioButon = 1;

foreach ($ofertasDeItem as $ofertas) {
    foreach ($ofertas as $oferta) {
        if ($oferta->item_id == $item_id) {        	

//            echo '<tr>';
//                echo '<td><h5>'.__('Offers:').'</h5></td>';
//                echo '<td>&nbsp</td>';
//                echo '<td>&nbsp</td>';
//                echo '<td>&nbsp</td>';
//            echo '</tr>';
            if($cabecera){
                echo '<tr>';
                echo '<th></th>';
                echo '<th>&nbsp</th>';
                echo '<th><h5>'.__('Offers:').'</h5></th>';
                 '<th>' . __('Offer ID') . '</th>';
                echo '<th>' . __('Ofertor') . '</th>';
                echo '<th>' . __('Price') . '</th>';
                echo '<th>' . __('Comment') . '</th>';
                echo '<th>' . __('Status') . '</th>';
                echo '<th>' . __('Select one') . '</th>';
                echo '</tr>';
                $cabecera = false;
            }
                        
            echo '<tr>';
            echo '<td>&nbsp</td>';
            echo '<td>&nbsp</td>';
            echo '<td>&nbsp</td>';
            '<td>' . $oferta->id . '</td>';
            echo '<td>'. $this->Html->link($oferta->user->name, ['controller' => 'Users', 'action' => 'view', $oferta->user_id]) . '</td>';
            echo '<td>' . $oferta->price . '&#8364;</td>';
            
            echo '<td>' . $oferta['comment'] . '</td>';
            echo '<td>' . $oferta['state'] . '</td>';
            echo '<td style="text-align:center"><input type="radio" name="item'.$oferta->item_id.'" value="'.$oferta->id.'" required></td>';
            echo '</tr>';
        }        
    }
    
    $idGrupoRadioButon++;    
    $cabecera = true;
}
