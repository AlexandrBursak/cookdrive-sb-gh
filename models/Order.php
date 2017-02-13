<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 17.01.17
 * Time: 17:17
 */

namespace app\models;

use app\models\Product;
use app\models\Service;

class Order extends \yii\db\ActiveRecord
{

    public function rules()
    {
        return [
            ['quantity', 'integer', 'min' => 1]
        ];
    }

    public function getUser(){
        /*ToDo

        Add relation Order->User with hasOne() function

         return $this->hasOne(User::className(), ['id' => 'user_id']);
        */
    }
    public function  getProfile(){
        return $this->hasOne(Profile::className(), ['user_id' => 'user_id']);
    }

    public function getProduct(){

        return $this->hasOne(Product::className(), ['id' => 'product_id']);

    }
    public function getService(){

        return $this->hasOne(Service::className(), ['id' => 'serv_id']);

    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID замовлення',
            'date' => 'Дата замовлення',
            'user_id' => 'Користувач/ID користувача',
            'product_id' => 'Продукт/ID продукту',
            'quantity' => 'Кількість',
            'summ' => 'Всьго'
        ];
    }

}