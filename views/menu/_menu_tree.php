<?php
/**
 * @var $this \yii\web\View
 * @var $items MenuItem[]
 * @var $currentItem MenuItem
 */


use common\helpers\MenuHelper;
use sokyrko\yii2menu\models\MenuItem;
use yii\helpers\Url;

?>
<?php if ($items) : ?>
    <ul class="list-group">
        <?php foreach ($items as $child) : ?>
            <li class="list-group-item">
                <a href="<?= Url::to(['menu/children', 'parentId' => $child->id]) ?>"><?= $child->title ?></a>
                <?php if ($child->children) : ?>
                    <i class="fa fa-level-down" aria-hidden="true"></i>
                    <?php if (MenuHelper::isChild($currentItem, $child) || $currentItem->id == $child->id) : ?>
                        <?= $this->render('_menu_tree', [
                            'items' => $child->children,
                            'currentItem' => $currentItem,
                        ]); ?>
                    <?php endif; ?>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>