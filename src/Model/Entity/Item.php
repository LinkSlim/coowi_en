<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Item Entity.
 *
 * @property int $id
 * @property int $petition_id
 * @property \App\Model\Entity\Petition $petition
 * @property string $name
 * @property \Cake\I18n\Time $date
 * @property string $description
 * @property string $state
 * @property \App\Model\Entity\Offer[] $offers
 * @property \App\Model\Entity\Tag[] $tags
 */
class Item extends Entity
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
