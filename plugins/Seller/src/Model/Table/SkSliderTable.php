<?php
namespace Admin\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RbProduct Model
 *
 * @method \App\Model\Entity\RbProduct get($primaryKey, $options = [])
 * @method \App\Model\Entity\RbProduct newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\RbProduct[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RbProduct|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RbProduct patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\RbProduct[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\RbProduct findOrCreate($search, callable $callback = null, $options = [])
 */
class SkSliderTable extends Table
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

        $this->setTable('sk_taxes');
        $this->setDisplayField('tax_id');
        $this->setPrimaryKey('tax_id');
       //$this->belongsTo('SkCategoryView', ['foreignKey' => 'category_view_id','joinType' => 'INNER','className' => 'SkCategoryView']);

    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
   
}
