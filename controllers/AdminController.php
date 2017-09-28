<?php

namespace app\controllers;

use dektrium\user\controllers\AdminController as BaseAdminController;
use Yii;
use app\models\Order;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\History;
use app\models\Product;

class AdminController extends BaseAdminController
{
    public function actionOrders()
    {
        $orders = Order::find()->select('product_id, SUM(quantity) AS quantity_sum, GROUP_CONCAT(DISTINCT user_id) as users_id')->groupBy(['product_id'])->asArray()->where(['date' => date("Y:m:d")])->all();
        //debug($orders);exit();
        $orders_per_service = [];
        foreach ($orders as $key => $value) {
            if (($service_id = Product::findOne($value['product_id'])->serv_id) !== null) {
                $orders_per_service[$service_id][]=$value;
            }
        }

        //debug($orders_per_service);
        return $this->render('orderindex', ['orders_per_service' => $orders_per_service]);
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
     * @param integer $itemId
     * @param integer $qty
     * @return mixed
     */
    public function actionOrderUpdate($id, $itemId, $qty)
    {
        if(Yii::$app->request->isAjax) {
            $model = $this->findOrderModel($id);

            //if ($model->load(Yii::$app->request->post())) {
            //TODO: model validation can be most inform.

                $history_order = History::find()->where(['orders_id' => $id])->orderBy([
                    'id' => SORT_DESC   // Отримуємо данні останньої отриманої історії в одному екземплярі
                ])->asArray()->one();   // по айді замовлення ( в зворотньому порядку HARDCODE: not bug - feature )

                $qty = !$qty ? 1 : $qty;
                $history = new History();           // створюємо новий запис в історії
                $history->orders_id = $model->id;   //той же id замовлення який буде у новому записі в історії
                $history->summa = $history_order['summa'] * (-1); // інвертуємо мінусову суму в (+) - поповнення
                $history->operation = 4;                          // 4 - повернення коштів (заміну товару адміністратором)
                $history->users_id = $history_order['users_id'];  // той же юзер в новій історії
                $history->date = date("Y:m:d");     // сьогоднішня дата
                $history->save();

                $new_product = Product::find()->where(['id' => $itemId])->asArray()->one();

                $history = new History();
                $history->orders_id = $model->id;
                $history->summa = -($new_product['price'] * $qty);
                $history->operation = 1;  //1 - замовленя, зняття грошей за замовлення
                $history->users_id = $history_order['users_id'];
                $history->date = date("Y:m:d");
                $history->save();

                $model->product_id = $itemId;
                $model->quantity = $qty;
                $model->product_name = $new_product['product_name'];
                $model->product_price = $new_product['price'];
                $model->product_serv_id = $new_product['serv_id'];
                $model->date = date("Y:m:d");
                $model->save();
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
        //History::findAll(['orders_id' => $id])->deleteAll();
        History::deleteAll("orders_id = " . $id );
        $this->findOrderModel($id)->delete();

        return $this->redirect(['user-orders']);
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


    /**
     * @param integer $id
     * @param integer $summ
     */
    public function actionMoney($id, $summ)
    {
        if(Yii::$app->request->isAjax && $summ !=0) {
            $summ = !$summ ? 0 : $summ;
            $history = new History();
            $history->summa = $summ;
            if($summ > 0) {
                $history->operation = 2; //2 - поповнення балансу адміністратором
            } elseif($summ < 0) {
                $history->operation = 3; //3 - зняття коштів з балансу адміністратором
            }

            $history->users_id = $id;
            $history->date = date("Y:m:d");
            $history->save();
        } else {
            return $this->redirect(['index']);
        }

    }

    /**
     * return autocomplate data
     * @return mixed
     */
    public function actionAutocomplate()
    {
        if(Yii::$app->request->isAjax) {
            $term = strip_tags(Yii::$app->request->get('term'));
            $data = Product::find()->select(['concat(sub_category," ",product_name) as value', 'concat("[",sub_category,"] ",product_name) as  label', 'id as id', 'photo_url', 'sub_category', 'price', 'product_name'])
                ->where(['like', 'product_name', $term])
                ->orFilterWhere(['like', 'sub_category', $term])
                ->andFilterWhere(['date_add' => date("Y:m:d")])
                ->asArray()->all();
            return json_encode($data);
        } else {
            return $this->redirect(['index']);
        }

    }


}