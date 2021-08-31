<?php
namespace Admin\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class ThemeSettingTable extends Table
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

        $this->setTable('theme_setting');
        $this->setDisplayField('theme_id');
        $this->setPrimaryKey('theme_id');
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
            ->integer('theme_id')
            ->allowEmpty('theme_id', 'create');

        $validator
           
            ->maxLength('theme_logo', 255)
            ->requirePresence('theme_logo', 'create')
            ->notEmpty('theme_logo');

        $validator
           
            ->maxLength('theme_favicon', 100)
            ->requirePresence('theme_favicon', 'create')
            ->notEmpty('theme_favicon');

  $validator
           
            ->maxLength('theme_white_logo', 100)
            ->requirePresence('theme_white_logo', 'create')
            ->notEmpty('theme_white_logo');

       $validator
          
            ->maxLength('minimum_booking', 100)
            ->requirePresence('minimum_booking', 'create')
            ->notEmpty('minimum_booking');


        return $validator;
    }
}