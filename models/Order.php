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
    public function getUser(){
        /*ToDo

        Add relation Order->User with hasOne() function

         return $this->hasOne(User::className(), ['id' => 'user_id']);
        */
    }

    public function getProduct(){

        return $this->hasOne(Product::className(), ['id' => 'product_id']);

    }
    public function getService(){

        return $this->hasOne(Service::className(), ['id' => 'serv_id']);

    }

}