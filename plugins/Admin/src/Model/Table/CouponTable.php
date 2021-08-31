<?php
namespace Admin\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class CouponTable extends Table
{

   
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('coupon');
        $this->setDisplayField('coupon_id');
        $this->setPrimaryKey('coupon_id');

    }

  
}