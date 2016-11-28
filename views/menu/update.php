<?php
/**
 * @var $this \yii\web\View
 * @var $model \sokyrko\yii2menu\models\Menu
 */

use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = 'Update menu';
?>
<?php Pjax::begin(['id' => 'grid_view']) ?>
<div class="row">
    <div class="col-md-1 col-xs-12">
        <?= Html::a('Back', ['menu/index'], ['class' => 'btn btn-danger']) ?>
    </div>
    <div class="col-md-8 col-xs-12">
        <?= $this->render('_menu_form', [
            'model' => $model
        ]) ?>

        <?= $this->render('_item_list', [
            'model' => $model,
        ]) ?>
    </div>
</div>
<?php Pjax::end() ?>
