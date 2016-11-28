<?php
/**
 * @var $this View
 * @var $parent MenuItem
 */

use sokyrko\yii2menu\models\MenuItem;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Pjax;

$this->title = 'Update menu';

?>
<?php Pjax::begin(['id' => 'grid_view']) ?>
<div class="row">
    <div class="col-md-1 col-xs-12">
        <?php if ($parent->parent) : ?>
            <?= Html::a('Back', ['menu/children', 'parentId' => $parent->parent_id], ['class' => 'btn btn-danger']) ?>
        <?php elseif ($parent->menu) : ?>
            <?= Html::a('Back', ['menu/update', 'id' => $parent->menu_id], ['class' => 'btn btn-danger']) ?>
        <?php endif; ?>
    </div>
    <div class="col-md-8 col-xs-12">
        <?= $this->render('_item_form', [
            'item' => $parent,
        ]) ?>

        <?= $this->render('_item_list', [
            'parent' => $parent,
            'model' => $parent->menu,
        ]) ?>
    </div>
    <div class="col-xs-12 col-md-3">
        <?= $this->render('_menu_tree', [
            'items' => $parent->menu->items,
            'currentItem' => $parent,
        ]); ?>
    </div>
</div>
<?php Pjax::end() ?>
