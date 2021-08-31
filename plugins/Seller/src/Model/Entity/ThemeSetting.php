<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;


class ThemeSetting extends Entity
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
        'theme_logo' => true,
        'minimum_booking'=>true,
        'theme_favicon' => true,
'theme_appbanner3' => true,
'theme_appbanner2' => true,
'theme_appbanner1' => true,
'theme_category1' => true,
'theme_category2' => true,
'theme_category3' => true,
        'theme_white_logo' => true
    ];
}