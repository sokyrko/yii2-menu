<?php
/**
 * @var $this \yii\web\View
 * @var $model \sokyrko\yii2menu\models\Menu
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="row">
    <div class="col-sm-9">
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
        <?= $form->field($model, 'name') ?>
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>
