<?php
/**
 * Created by PhpStorm.
 * User: bigdrop
 * Date: 24.11.16
 * Time: 16:28
 */

namespace sokyrko\yii2menu\controllers;

use sokyrko\yii2menu\models\Menu;
use sokyrko\yii2menu\models\MenuItem;
use sokyrko\yii2menu\models\MenuSearch;
use yii\base\ErrorException;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * @package sokyrko\yii2menu\controllers
 */
trait MenuTrait
{

    public function actionIndex()
    {
        $searchModel = new MenuSearch();
        $searchModel->load(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => new ActiveDataProvider([
                'query' => $searchModel->search(),
            ]),
        ]);
    }


    public function actionCreate()
    {
        $model = new Menu();

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->session->setFlash('success', 'Menu has been created.');
            return $this->redirect(['menu/index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->getMenu($id);

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->session->setFlash('success', 'Menu has been updated.');
            return $this->redirect(['menu/index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionChildren($parentId)
    {
        return $this->render('children', [
            'parent' => $this->getItem($parentId),
        ]);
    }

    public function actionDelete($id)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $model = $this->getMenu($id);

        if (!$model->delete()) {
            throw new ErrorException('Model cant be deleted');
        }

        return ['success' => true];
    }

    /**
     * @param $menuId
     * @return Menu
     * @throws NotFoundHttpException
     */
    private function getMenu($menuId)
    {
        if ($menu = Menu::findOne($menuId)) {
            return $menu;
        }

        throw new NotFoundHttpException('Menu not found');
    }

    /**
     * @param $itemId
     * @return MenuItem
     * @throws NotFoundHttpException
     */
    private function getItem($itemId)
    {
        if ($item = MenuItem::findOne($itemId)) {
            return $item;
        }

        throw new NotFoundHttpException('Menu item not found');
    }
}