<?php
/**
 * Created by PhpStorm.
 * User: bigdrop
 * Date: 24.11.16
 * Time: 16:33
 */

namespace sokyrko\yii2menu\models;

use yii\base\Model;
use yii\db\ActiveQuery;

/**
 * Class MenuSearch
 * @package sokyrko\yii2menu\models
 */
class MenuSearch extends Model
{
    public $name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'string'],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function search()
    {
        return Menu::find()->andFilterWhere([
            'like', 'name', $this->name,
        ]);
    }
}