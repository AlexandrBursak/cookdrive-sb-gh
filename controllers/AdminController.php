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
        $orders_per_service = [];

        foreach ($orders as $key => $value) {
            if (($service_id = Product::findOne($value['product_id'])->serv_id) !== null) {
                $orders_per_service[$service_id][]=$value;
            }
        }

        return $this->render('orderindex', ['orders_per_service' => $orders_per_service]);
    }

    public function actionOrderCookdrive()
    {
        $orders = Order::find()->select('product_id, SUM(quantity) AS quantity_sum, GROUP_CONCAT(DISTINCT user_id) as users_id')->groupBy(['product_id'])->asArray()->where(['date' => date("Y:m:d")])->all();
        $product = [];

        $date = date("d.m.Y");

        foreach ($orders as $key => $value) {            
            array_push($product, ['id' => Product::findOne($value['product_id'])->product_id, 
                                  'quantity' => $value['quantity_sum']]);     
        }
        if (!empty($product)) {

        // cookies file (session settings)
            $cookieFile = "cookies.txt";
            if(!file_exists($cookieFile)) {
                $fh = fopen($cookieFile, "w");
                fwrite($fh, "");
                fclose($fh);
            } //
            
            foreach ($product as $key => $item) {  
                $cd_url = 'http://cookdrive.com.ua/cart/add/id/'.$item['id'];

                $curl = \curl_init(); // start require
                curl_setopt($curl, CURLOPT_URL, $cd_url); //URL
                curl_setopt($curl, CURLOPT_HEADER, 1); //display headers
                curl_setopt($curl, CURLOPT_POST, 1); //POST type
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); //now curl give back response
                curl_setopt($curl, CURLINFO_HEADER_OUT, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, //data of POST
                array (
                    'cnt'=>$item['quantity'],
                    'double'=>0,
                    'blank'=>0,
                    'special'=>0,
                ));
                curl_setopt($curl, CURLOPT_COOKIEFILE, $cookieFile); // Cookie read
                curl_setopt($curl, CURLOPT_COOKIEJAR, $cookieFile); // Cookie write

                $res = curl_exec($curl);
                $sent_headers = curl_getinfo($curl, CURLINFO_HEADER_OUT); //get headers
                //if error -> type error
                if(!$res) {
                    $error = curl_error($curl).'('.curl_errno($curl).')';
                    echo $error;
                }
                curl_close($curl);

            } // endforeach.  
            
            // order form request
                $cd_url = 'http://cookdrive.com.ua/cart/order';

                $curl = \curl_init(); // start require
                curl_setopt($curl, CURLOPT_URL, $cd_url); //URL
                curl_setopt($curl, CURLOPT_HEADER, 1); //display headers
                curl_setopt($curl, CURLOPT_POST, 1); //POST type
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); //now curl give back response
                curl_setopt($curl, CURLINFO_HEADER_OUT, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, //data of POST
                array (
                        'type'=>0,
                        'phone'=>979471223,
                        'name'=>'Михайло',
                        'street'=>'Зарічанська',
                        'home'=>'5/3',
                        'code'=>'',
                        'floor'=>'5',
                        'apartment'=>'SoftBistro',
                        'time'=>'1',
                        'date'=>$date,
                        'hour'=>'00',
                        'minute'=>'00',
                        'comment'=>'Оплата карткою',
                        'porch'=>'',

                ));
                curl_setopt($curl, CURLOPT_COOKIEFILE, $cookieFile); // Cookie read
                curl_setopt($curl, CURLOPT_COOKIEJAR, $cookieFile); // Cookie write

                $res = curl_exec($curl);
                $sent_headers = curl_getinfo($curl, CURLINFO_HEADER_OUT); //get headers
                
                //if error -> type error
                if(!$res) {
                    $error = curl_error($curl).'('.curl_errno($curl).')';
                    echo $error;
                }
                curl_close($curl);
            // end request
        } //end if

        //cut res_link from $res
        $first = substr($res, strrpos($res, 'Location:')+10);
        $last = strpos($first, 'Vary')-2;
        $cart_link = substr($first, 0, $last); // 
        
        // clear cookie file
        $fh = fopen($cookieFile, "w");
        fwrite($fh, "");
        fclose($fh);

        return $this->redirect("http://cookdrive.com.ua".$cart_link);

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