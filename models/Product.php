<?php


namespace app\models;


use yii\db\ActiveRecord;

use app\models\Service;


class Product extends ActiveRecord{

    public function getService()
    {
        return $this->hasOne(Service::className(), ['id' => 'serv_id']);
    }
}