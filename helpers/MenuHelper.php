<?php
/**
 * Created by PhpStorm.
 * User: bigdrop
 * Date: 25.11.16
 * Time: 17:44
 */

namespace sokyrko\yii2menu\helpers;

use sokyrko\yii2menu\models\MenuItem;
use yii\helpers\ArrayHelper;

/**
 * Class MenuHelper
 * @package sokyrko\yii2menu\helpers
 */
class MenuHelper
{

    /**
     * @param MenuItem $item
     * @param MenuItem $parent
     * @return bool
     */
    public static function isChild(MenuItem $item, MenuItem $parent)
    {
        $children = self::getChildIds($parent);

        if (ArrayHelper::isIn($item->id, $children)) {
            return true;
        }

        return false;
    }

    private static function getChildIds(MenuItem $parent)
    {
        $idsTotal = [];
        $children = $parent->children;
        $idsTotal = ArrayHelper::merge(ArrayHelper::getColumn($children, 'id'), $idsTotal);

        foreach ($children as $child) {
            $idsTotal = ArrayHelper::merge(self::getChildIds($child), $idsTotal);
        }

        return $idsTotal;
    }
}