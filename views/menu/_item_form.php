<?php
/**
 * @var $this \yii\web\View
 * @var $item \sokyrko\yii2menu\models\MenuItem
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

if ($item->id) {
    $action = ['menu-item/update', 'id' => $item->id];
} else {
    $action = ['menu-item/create', 'menuId' => $item->menu_id, 'parentId' => $item->parent_id];
}

?>
<div class="row">
    <div class="col-xs-9">
        <?php $form = ActiveForm::begin([
            'action' => $action,
        ]); ?>
        <?= $form->field($item, 'title') ?>
        <?= $form->field($item, 'url') ?>

        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>
