<?php
/**
 * Created by PhpStorm.
 * User: bigdrop
 * Date: 24.11.16
 * Time: 16:06
 */

namespace sokyrko\yii2menu\models;
use yii\db\ActiveRecord;

/**
 * Class MenuItem
 * @package common\models
 * @property integer $id
 * @property string $title
 * @property string $url
 * @property integer $menu_id
 * @property integer $parent_id
 * @property integer $position
 * @property Menu $menu
 * @property MenuItem $parent
 * @property MenuItem[] $children
 */
class MenuItem extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'url', 'menu_id'], 'required'],
            ['title', 'string', 'max' => 64],
            ['url', 'string', 'max' => 128],
            [['menu_id', 'parent_id', 'position'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu_items';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(Menu::className(), ['id' => 'menu_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(MenuItem::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(MenuItem::className(), ['parent_id' => 'id'])->orderBy(['position' => SORT_ASC]);
    }
}