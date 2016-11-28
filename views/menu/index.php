<?php
/**
 * @var $this \yii\web\View
 * @var $dataProvider \yii\data\ActiveDataProvider
 * @var $searchModel MenuSearch
 */

use sokyrko\yii2menu\models\Menu;
use sokyrko\yii2menu\models\MenuSearch;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = 'Menu module';
?>
<?php Pjax::begin(['id' => 'grid_view']) ?>
    <h1><?= $this->title ?></h1>
    <p><?= Html::a('Create new', Url::to(['menu/create']), ['class' => 'btn btn-success']) ?></p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'name',
                'value' => function ($item) {
                    /**
                     * @var $item Menu
                     */
                    return strip_tags(StringHelper::truncate($item->name, 30, '...'));
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [
                    'delete' => function ($url, $model) {
                        /**
                         * @var $model Menu
                         */
                        return Html::a(
                            '<span class="glyphicon glyphicon-trash"></span>',
                            Url::to(['menu/delete', 'id' => $model->id]),
                            ['class' => 'delete-button']);
                    }
                ]
            ]
        ],
    ]); ?>
<?php Pjax::end() ?>