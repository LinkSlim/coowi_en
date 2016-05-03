<?php
namespace App\Model\Table;

use App\Model\Entity\Petition;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Petitions Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\HasMany $Items
 */
class PetitionsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('petitions');
        $this->displayField('title');
        $this->primaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Items', [
            'foreignKey' => 'petition_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        $validator
            ->requirePresence('description', 'create')
            ->notEmpty('description');

        $validator
            ->date('creation_date')
            ->requirePresence('creation_date', 'create')
            ->notEmpty('creation_date');

        $validator
            ->date('shell_by_date')
            ->requirePresence('shell_by_date', 'create')
            ->notEmpty('shell_by_date');

        $validator
            ->requirePresence('location', 'create')
            ->notEmpty('location');

        $validator
            ->decimal('budget')
            ->allowEmpty('budget');

        $validator
            ->allowEmpty('photo');

        $validator
            ->requirePresence('state', 'create')
            ->notEmpty('state');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        return $rules;
    }
    
    //Comprobamos que el usuario con ID 'userId' es propietario de la peticion con ID 'petitionId'
    //si ambos IDs estan en una misma fila de la tabla 'Petition' de la BBDD
    public function isOwnedBy($petitionId, $userId) { // Es para usar con el isAuthorized del tutorial del blog
        return $this->exists(['id' => $petitionId, 'user_id' => $userId]);
    }
    
//     public function getPetitionsByTags() { // Try to avoid naming a function as get()
//         return $this->query("SELECT p.title FROM petitions As p INNER JOIN items ON p.id = items.petition_id INNER JOIN items_tags ON items.id = items_tags.item_id WHERE items_tags.tag_id = '1' GROUP BY p.title ORDER BY p.title;");
//     }
}
