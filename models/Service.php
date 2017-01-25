<?php

namespace app\models;

use yii\db\ActiveRecord;

class Service extends ActiveRecord
{

    public static function tableName()
    {
        return 'service';
    }

    public function getProduct()
    {
        return $this->hasMany(Product::className(), ['serv_id' => 'id']);
    }

    public function rules()
    {
        return [
            // name and link are both required
            [['name', 'link'], 'required'],

        ];
    }
}
