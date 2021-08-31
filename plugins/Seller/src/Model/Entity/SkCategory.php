<?php namespace Admin\Model\Entity;

use Cake\ORM\Entity;

class SkCategory extends Entity
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
        'category_id' => true,
        'category_name' => true,
        'category_slug' => true,
        'category_parent'=>true,
        'category_descri'=>true,
        'category_icon'=>true,
        'category_meta_title'=>true,
        'category_meta_desc'=>true,
        'category_status'=>true,
        'category_created_datetime'=>true,
         'category_trash_status'=>true
   ];
}
