<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;


class Transactions extends Entity
{

    protected $_accessible = ['*' => true,'trans_id' => false];
}