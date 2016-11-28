<?php
/**
 * @var $this View
 * @var $parent MenuItem
 * @var $model Menu
 */

use kartik\sortable\Sortable;
use sokyrko\yii2menu\models\Menu;
use sokyrko\yii2menu\models\MenuItem;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

$moveUrl = Url::to(['menu-item/move']);

$js = <<<JS
    function moveItem(id, newIndex) {
        $.post('{$moveUrl}', {id: id, newIndex: newIndex}, function (data) {
            if (!data.success) {
                alert('shit happens');
            }
        });
    }
JS;

$this->registerJs($js);

$menuItems = isset($parent->children) ? $parent->children : $model->items;

$items = [];
foreach ($menuItems as $menuItem) {
    $items[] = [
        'content' => Html::tag('div',
            Html::a(
                $menuItem->title . ' ' . (($menuItem->children) ? '<i class="fa fa-level-down" aria-hidden="true"></i>' : ''),
                ['menu/children', 'parentId' => $menuItem->id]) .
            Html::tag('div',
                Html::a(
                    '<span class="glyphicon glyphicon-trash"></span>',
                    Url::to(['menu-item/delete', 'id' => $menuItem->id]),
                    ['class' => 'delete-button']), ['class' => 'pull-right'])

        ),
        'options' => ['data-item-id' => $menuItem->id],
    ];
}

Modal::begin([
    'id' => 'item-form',
    'header' => 'New menu item',
]);

echo $this->render('_item_form', [
    'item' => new MenuItem(['menu_id' => $model->id, 'parent_id' => isset($parent) ? $parent->id : null]),
]);

Modal::end();

?>

<div class="row">
    <div class="col-xs-12">
        <h2>Items for <?= isset($parent->title) ? $parent->title : $model->name ?></h2>
        <div class="row">
            <div class="col-xs-12 col-md-9">
                <?= Sortable::widget([
                    'items' => $items,
                    'pluginEvents' => [
                        'sortupdate' => 'function (event, details) { moveItem(details.item.data("item-id"), details.item.index()); }',
                    ],
                ]) ?>
                <div class="btn btn-success new-item" data-toggle="modal" data-target="#item-form">Add</div>
            </div>
        </div>
    </div>
</div>