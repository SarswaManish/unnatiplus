<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;


class Faq extends Entity
{

    protected $_accessible = ['*' => true,'faq_id' => false];
}