<?php

namespace app\controllers;

use dektrium\user\controllers\AdminController as BaseAdminController;
use Yii;
use app\models\Order;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class AdminController extends BaseAdminController
{
    public function actionOrders()
    {
        $orders = Order::find()->select('product_name, serv_id, price, product_id, SUM(quantity) AS quantity_sum')->groupBy(['product_name','product_name', 'serv_id', 'price', 'product_id'])->asArray()->where(['date' => date("Y:m:d")])->all();

        return $this->render('orderindex', [
            'orders' => $orders,
        ]);
    }

    public function actionUserOrders()
    {
        /*$dataProvider = new ActiveDataProvider([
            'query' => Order::find()->where(['date' => date("Y:m:d")]),
        ]);*/
        $orders = Order::find()->asArray()->where(['date' => date("Y:m:d")])->all();
        $orders_per_user = [];
        foreach ($orders as $key => $value) {
            $orders_per_user[$value['user_id']][]=$value;
        }

        return $this->render('orderindex', [
            'orders_per_user' => $orders_per_user,
            'orders' => $orders,
        ]);
    }

    /**
     * Displays a single Order model.
     * @param integer $id
     * @return mixed
     */
    public function actionOrderView($id)
    {
        return $this->render('orderview', [
            'model' => $this->findOrderModel($id),
        ]);
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionOrderCreate()
    {
        $model = new Order();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['order-view', 'id' => $model->id]);
        } else {
            return $this->render('ordercreate', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionOrderUpdate($id)
    {

        $model = $this->findOrderModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['order-view', 'id' => $model->id]);
        } else {
            return $this->render('orderupdate', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionOrderDelete($id)
    {
        $this->findOrderModel($id)->delete();

        return $this->redirect(['orders']);
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findOrderModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}