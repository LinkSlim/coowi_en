<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;

/**
 * User Entity.
 *
 * @property int $id
 * @property int $rol_id
 * @property \App\Model\Entity\Role $role
 * @property string $nif
 * @property string $email
 * @property string $password
 * @property string $name
 * @property string $subname
 * @property string $phone
 * @property string $location
 * @property string $postal_code
 * @property string $photo
 * @property \Cake\I18n\Time $date
 * @property string $state
 * @property \App\Model\Entity\Job[] $jobs
 * @property \App\Model\Entity\Petition[] $petitions
 * @property \App\Model\Entity\Study[] $studies
 */
class User extends Entity
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

    /**
     * Fields that are excluded from JSON an array versions of the entity.
     *
     * @var array
     */
    
    //Metodo para cifrar la contraseña (sin este metodo no funciona la autenticacion o login)
    protected function _setPassword($value)
    {
        $hasher = new DefaultPasswordHasher();
        return $hasher->hash($value);
    }
}
