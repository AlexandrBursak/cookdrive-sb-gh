<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 17.01.17
 * Time: 17:34
 */

namespace app\models;


use yii\db\ActiveRecord;
use app\models\Service;


class Product extends ActiveRecord{
    public function getService(){
        return $this->hasOne(Service::className(), ['id' => 'serv_id']);
    }

}