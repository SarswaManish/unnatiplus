<?php
namespace Admin\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class NotificationTable extends Table
{

   
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('notification');
        $this->setDisplayField('noti_id');
        $this->setPrimaryKey('noti_id');

    }

  
}