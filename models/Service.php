<?php
/**
 * Created by PhpStorm.
 * User: MyBe
 * Date: 20.01.2017
 * Time: 11:47
 */

namespace app\models;


use yii\db\ActiveRecord;

class Service extends ActiveRecord
{

    public function rules()
    {
        return [
            // name and link are both required
            [['name', 'link'], 'required'],

        ];
    }
}