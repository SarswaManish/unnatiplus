<?php
namespace Admin\Model\Entity;

use Cake\ORM\Entity;

class SkAdmin extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'admin_id' => true,
        'admin_first_name' => true,
        'admin_last_name' => true,
        'admin_business_name'=>true,
        'admin_status'=>true,
        'admin_profile_image'=>true,
        'admin_password'=>true,
'admin_mobile_number'=>true
    ];
}
