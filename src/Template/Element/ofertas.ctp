<?php

$cabecera = true;

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
                echo '<th><h5>'.__('Offers:').'</h5></th>';
                echo '<th>&nbsp</th>';
                echo '<th>&nbsp</th>';
                echo '<th>' . __('Offer ID') . '</th>';
                echo '<th>' . __('User') . '</th>';
                echo '<th>' . __('Price') . '</th>';
                echo '<th>' . __('Comment') . '</th>';
                echo '</tr>';
                $cabecera = false;
            }
                        
            echo '<tr>';
            echo '<td>&nbsp</td>';
            echo '<td>&nbsp</td>';
            echo '<td>&nbsp</td>';
            echo '<td>' . $oferta->id . '</td>';
            echo '<td>' . $oferta['user_id'] . '</td>';
            echo '<td>' . $oferta->price . '</td>';
            echo '<td>' . $oferta['comment'] . '</td>';
            echo '</tr>';
        }
    }
    $cabecera = true;
}
