<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Offer Entity.
 *
 * @property int $id
 * @property int $item_id
 * @property \App\Model\Entity\Item $item
 * @property float $price
 * @property \Cake\I18n\Time $date
 * @property string $comment
 * @property string $state
 */
class Offer extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
