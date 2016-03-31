<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Petition Entity.
 *
 * @property int $id
 * @property int $user_id
 * @property \App\Model\Entity\User $user
 * @property string $title
 * @property string $description
 * @property \Cake\I18n\Time $creation_date
 * @property \Cake\I18n\Time $shell_by_date
 * @property string $location
 * @property float $budget
 * @property string $photo
 * @property string $state
 * @property \App\Model\Entity\Item[] $items
 */
class Petition extends Entity
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
