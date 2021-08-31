<?php
namespace Admin\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class TransactionsTable extends Table
{

   
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('transactions');
        $this->setDisplayField('trans_id');
        $this->setPrimaryKey('trans_id');
$this->belongsTo('Product', [
           'foreignKey' => 'trans_item_id',
           'joinType' => 'INNER',
           'className' => 'Product'
       ]);
$this->belongsTo('User', [
           'foreignKey' => 'trans_user_id',
           'joinType' => 'INNER',
           'className' => 'User'
       ]);

    }

  
}