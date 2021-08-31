<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;


class Orders extends Entity
{

    protected $_accessible = ['*' => true,'order_id' => false];
}