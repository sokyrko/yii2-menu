<?php
/**
 * @var $this \yii\web\View
 * @var $model \sokyrko\yii2menu\models\Menu
 */

$this->title = 'Create menu';

echo $this->render('_menu_form', [
    'model' => $model
]);