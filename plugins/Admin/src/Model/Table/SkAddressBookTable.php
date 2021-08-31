<?php
namespace Admin\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class SkAddressBookTable extends Table
{

   
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('sk_address_book');
        $this->setDisplayField('ab_id');
        $this->setPrimaryKey('ab_id');

    }

  
}