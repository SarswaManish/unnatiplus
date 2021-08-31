<?php
namespace Admin\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class FaqTable extends Table
{

   
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('faq');
        $this->setDisplayField('faq_id');
        $this->setPrimaryKey('faq_id');

    }

  
}