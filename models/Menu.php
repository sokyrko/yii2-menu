<?php
/**
 * Created by PhpStorm.
 * User: bigdrop
 * Date: 24.11.16
 * Time: 16:04
 */

namespace sokyrko\yii2menu\models;
use yii\db\ActiveRecord;

/**
 * Class Menu
 * @package common\models
 * @property integer $id
 * @property string $name
 * @property MenuItem[] $items
 */
class Menu extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menus';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(MenuItem::className(), ['menu_id' => 'id'])
                    ->onCondition(['parent_id' => null])
                    ->orderBy(['position' => SORT_ASC]);
    }
}