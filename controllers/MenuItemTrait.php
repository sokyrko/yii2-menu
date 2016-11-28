<?php
/**
 * Created by PhpStorm.
 * User: bigdrop
 * Date: 25.11.16
 * Time: 13:45
 */

namespace sokyrko\yii2menu\controllers;

use sokyrko\yii2menu\models\MenuItem;
use yii\base\ErrorException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * @package sokyrko\yii2menu\controllers
 */
trait MenuItemTrait
{
    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }

    /**
     * @param $menuId
     * @param null $parentId
     * @return array|Response
     */
    public function actionCreate($menuId, $parentId = null)
    {
        $model = new MenuItem(['menu_id' => $menuId, 'parent_id' => $parentId]);

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            if ($parentId) {
                return $this->redirect(['menu/children', 'parentId' => $parentId]);
            } else {
                return $this->redirect(['menu/update', 'id' => $menuId]);
            }
        }

        return ['errors' => $model->getErrors()];
    }

    /**
     * @param $id
     * @return array|Response
     */
    public function actionUpdate($id)
    {
        $model = $this->getItem($id);

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            if ($parent = $model->parent_id) {
                return $this->redirect(['menu/children', 'parentId' => $parent]);
            } else {
                return $this->redirect(['menu/update', 'id' => $model->menu_id]);
            }
        }

        return ['errors' => $model->getErrors()];
    }

    public function actionMove()
    {
        $id = \Yii::$app->request->post('id');
        $newIndex = \Yii::$app->request->post('newIndex');

        $toMove = $this->getItem($id);

        /**
         * @var $menuItems MenuItem[]
         */
        $menuItems = MenuItem::find()->andWhere([
            'parent_id' => $toMove->parent_id,
            'menu_id' => $toMove->menu_id,
        ])->orderBy(['position' => SORT_ASC])->all();

        $key = array_search($toMove, $menuItems);
        array_splice($menuItems, $key, 1);
        array_splice($menuItems, $newIndex, 0, [$toMove]);

        $transaction = \Yii::$app->db->beginTransaction();

        try {
            foreach ($menuItems as $idx => $menuItem) {
                $menuItem->position = $idx;
                if (!$menuItem->save()) {
                    throw new ErrorException(Json::encode($menuItem->getErrors()));
                }
            }
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            return ['errors' => $e->getMessage()];
        }

        return ['success' => true];
    }

    /**
     * @param $id
     * @return array
     * @throws ErrorException
     */
    public function actionDelete($id)
    {
        $model = $this->getItem($id);

        if (!$model->delete()) {
            throw new ErrorException('Model cant be deleted');
        }

        return ['success' => true];
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