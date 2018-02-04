<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Registry Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $entry_key
 * @property string $entry_value
 * @property bool $published
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\User $user
 */
class Registry extends Entity
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
        'user_id' => true,
        'entry_key' => true,
        'entry_value' => true,
        'published' => true,
        'created' => true,
        'modified' => true,
        'user' => true
    ];
}
