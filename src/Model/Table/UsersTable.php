<?php
namespace App\Model\Table;

use App\Model\Entity\User;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Roles
 * @property \Cake\ORM\Association\HasMany $Jobs
 * @property \Cake\ORM\Association\HasMany $Petitions
 * @property \Cake\ORM\Association\HasMany $Studies
 */
class UsersTable extends Table
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

        $this->table('users');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->belongsTo('Roles', [
            'foreignKey' => 'rol_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Jobs', [
            'foreignKey' => 'user_id',
        	'cascadeCallbacks' => true
        ]);
        $this->hasMany('Petitions', [
            'foreignKey' => 'user_id',
        	'cascadeCallbacks' => true
        ]);
        $this->hasMany('Studies', [
            'foreignKey' => 'user_id',
        	'cascadeCallbacks' => true
        ]);
        $this->hasMany('Rates', [
        		'foreignKey' => 'user2_id',
        		'cascadeCallbacks' => true
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
            ->requirePresence('nif', 'create')
            ->notEmpty('nif')
            ->add('nif', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmpty('email')
            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->requirePresence('password', 'create')
            ->notEmpty('password');

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->requirePresence('subname', 'create')
            ->notEmpty('subname');

        $validator
            ->requirePresence('phone', 'create')
            ->notEmpty('phone');

        $validator
            ->requirePresence('location', 'create')
            ->notEmpty('location');

        $validator
            ->requirePresence('postal_code', 'create')
            ->notEmpty('postal_code');

        $validator
            ->allowEmpty('photo');

        $validator
            ->date('date')
            ->requirePresence('date', 'create')
            ->notEmpty('date');

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
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->isUnique(['nif']));
        $rules->add($rules->existsIn(['rol_id'], 'Roles'));
        return $rules;
    }   
}
